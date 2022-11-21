<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHourRequest;
use App\Http\Requests\UpdateHourRequest;
use App\Models\Hour;
use App\Models\HourType;
use App\Models\JobType;
use App\Models\Order;
use App\Models\OrderHour;
use App\Models\TechnicalReportHour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
            'period' => CarbonPeriod::create(Carbon::parse(request('month'))->firstOfMonth(),Carbon::parse(request('month'))->lastOfMonth())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHourRequest $request
     * @return Response|RedirectResponse|JsonResponse
     */
    public function store(StoreHourRequest $request): Response|RedirectResponse|JsonResponse
    {
        $validated = $request->validated();
        $additional = $request->only([
            'extra', 'job','hour'
        ]);
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();
        $validated['hour_type_id'] = HourType::where('description',$validated['hour_type_id'])->first()->id;
        $hour = Hour::create($validated);
        if ($validated['hour_type_id'] === 1){
            OrderHour::create([
                'signed' => false,
                'order_id' => Order::where('innerCode',$additional['extra'])->first()->id,
                'hour_id' => $hour->id,
                'job_type_id' => JobType::where('title',$additional['job'])->first()->id,
            ]);
        }
        else if ($validated['hour_type_id'] === 2){
            TechnicalReportHour::create([
                'nightEU' => false,
                'nightXEU' => false,
                'technical_report_id' => $additional['extra'],
                'hour_id' => $hour->id
            ]);
        }
        return back()->with('message','Ora Inserita Correttamente');
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
     * @return RedirectResponse
     */
    public function update(UpdateHourRequest $request, Hour $hour)
    {
        $validated = $request->validated();
        $additional = $request->only([
            'extra', 'job','hour'
        ]);
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();
        $validated['hour_type_id'] = HourType::where('description',$validated['hour_type_id'])->first()->id;
        $hour->update($validated);

        if ($validated['hour_type_id'] === 1){
            OrderHour::where('hour_id',$hour->id)->update([
                'signed' => false,
                'order_id' => Order::where('innerCode',$additional['extra'])->first()->id,
                'hour_id' => $hour->id,
                'job_type_id' => JobType::where('title',$additional['job'])->first()->id,
            ]);
        }
        else if ($validated['hour_type_id'] === 2){
            TechnicalReportHour::where('hour_id',$hour->id)->update([
                'nightEU' => false,
                'nightXEU' => false,
                'technical_report_id' => $additional['extra'],
                'hour_id' => $hour->id
            ]);
        }
        return back()->with('message','Ora Modificata Correttamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hour $hour
     * @return Response
     */
    public function destroy(Hour $hour)
    {
        //
    }
}
