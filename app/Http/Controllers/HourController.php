<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHourRequest;
use App\Http\Requests\UpdateHourRequest;
use App\Models\Customer;
use App\Models\Hour;
use App\Models\HourType;
use App\Models\JobType;
use App\Models\Order;
use App\Models\OrderHour;
use App\Models\TechnicalReport;
use App\Models\TechnicalReportHour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class HourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response()->view('hours.index',[
            'data' => Hour::with('type')->filter(request(['month','user']))->get()->groupBy(
                [
                    static function ($item){
                        return $item->type->description;
                    },
                    static function ($item){
                        if ($item->type->description === 'Commessa'){
                            return $item->order_hour()->order->innerCode;
                        }
                        if ($item->type->description === 'Foglio intervento'){
                            return $item->technical_report_hour()->technical_report->number;
                        }
                        return false;
                    },static function ($item){
                        if ($item->type->description === 'Commessa'){
                            return $item->order_hour()->job_type->title;
                        }
                        return false;
                    }
                ]),
            'period' => CarbonPeriod::create(Carbon::parse(request('month'))->firstOfMonth(),Carbon::parse(request('month'))->lastOfMonth()),
            'hour_types' => HourType::all(),
            'job_types' => JobType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('hours.create',[
            'hour_types' => HourType::all(),
            'orders' => Order::with('customer','status')->orderBy('status_id')->get(),
            'job_types' => JobType::all(),
            'technical_reports' => TechnicalReport::with('customer','secondary_customer')->get(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHourRequest $request
     * @return Response|RedirectResponse|JsonResponse
     * @throws ValidationException
     */
    public function store(StoreHourRequest $request): Response|RedirectResponse|JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->get('user_id',auth()->id());
        $hour = Hour::create($validated);
        if ($hour->type->id === 1){
            $details = Validator::make($request->only([ 'extra','job','signed' ]),[
                'extra' => 'required',
                'job' => 'required',
                'signed' => 'nullable'
            ]);
            if ($details->fails()){
                Session::flash('hour_type',$hour->type->id);
                $hour->delete();
            }
            $this->storeOrderHour($hour->id,$details->validated());
        }else if ($request->get('hour_type_id') === '2'){
            $details = Validator::make($request->only(['extra','night']),[
                'extra' => 'required',
                'night' => 'required'
            ]);
            if ($details->fails()){
                Session::flash('hour_type',$hour->hour_type_id);
                $hour->delete();
            }
            $this->storeTechnicalReportHour($hour->id,$details->validated());
        }
        if ($request->ajax()){
            return response('Ora Inserita Correttamente');
        }
        return redirect()->action([__CLASS__,'index'],['month' => Carbon::now()->format('Y-m')])->with('message','Ora Inserita Correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param Hour $hour
     * @return Response
     */
    public function show(Hour $hour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hour $hour
     * @return Response
     */
    public function edit(Hour $hour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHourRequest $request
     * @param Hour $hour
     * @return Response|RedirectResponse
     * @throws ValidationException
     */
    public function update(UpdateHourRequest $request, Hour $hour): Response|RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->get('user_id',auth()->id());
        $hour->update($validated);
        if ($hour->type->id === 1){
            $details = Validator::make($request->only([ 'extra','job','signed' ]),[
                'extra' => 'required',
                'job' => 'required',
                'signed' => 'nullable'
            ]);
            $hour->order_hour()->update($details->validated());
        }else if ($request->get('hour_type_id') === '2'){
            $details = Validator::make($request->only(['extra','night']),[
                'extra' => 'required',
                'night' => 'required'
            ]);
            $hour->technical_report_hour()->update($details->validated());
        }
        if ($request->ajax()){
            return response('Ora Modificata Correttamente');
        }
        return redirect()->route('hours.index')->with('message','Ora Modificata Correttamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hour $hour
     * @return RedirectResponse
     */
    public function destroy(Hour $hour): RedirectResponse
    {
        OrderHour::where('hour_id',$hour->id)->delete();
        $hour->delete();
        return back()->with('message','Ora eliminata con successo');
    }

    public function storeOrderHour($hour_id,$info): void
    {
        $order = Order::find($info['extra']) ?? Order::where('innerCode',$info['extra'])->first();
        OrderHour::create([
            'hour_id' => $hour_id,
            'signed' => $info['signed'] ?? false,
            'order_id' => $order->id,
            'job_type_id' => $info['job']
        ]);
    }

    public function storeTechnicalReportHour($hour_id,$info): void
    {
        if ($info['extra'] === '0') {
            dd(request());
            Validator::make(request()->only(['number','fi_order_id','customer_id','secondary_customer_id']),[
                'number' => 'required',
                'fi_order_id' => 'nullable',
                'customer_id' => 'required',
                'secondary_customer_id' => 'nullable'
            ]);
        }
        $technical_report = TechnicalReport::find($info['extra']) ?? TechnicalReport::where('number',$info['extra'])->first();
        TechnicalReportHour::create([
            'hour_id' => $hour_id,
            'nightEU' => $info['night'] === 'eu',
            'nightXEU' => $info['night'] === 'xeu',
            'technical_report_id' => $technical_report->id
        ]);
    }
}
