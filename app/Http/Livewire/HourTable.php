<?php

namespace App\Http\Livewire;

use App\Models\Hour;
use App\Models\Order;
use App\Models\OrderHour;
use App\Models\TechnicalReportHour;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class HourTable extends Component
{

    public $order_hours;
    public $technical_report_hours;
    public $other_hours;
    public $hour_id,$count,$date,$description,$hour_type,$user_id;
    public $technical_report_hour_id,$night_eu,$night_xeu,$technical_report_id;
    public $order_hour_id,$signed,$order_id,$job_type;
    public $start,$end;

    protected function getRules(): array
    {
        return [
            'other_hours.*.count' => 'nullable',
            'count' => ['required','numeric']
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.hours.hour-table');
    }

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->start = Carbon::parse(request('month','now'))->firstOfMonth()->format('Y-m-d');
        $this->end = Carbon::parse(request('month','now'))->lastOfMonth()->format('Y-m-d');
        $data = Hour::filter(request(['user','month']))->get();
        $this->order_hours = OrderHour::with(['order','order.customer','hour'])->whereIn('hour_id',$data->where('hour_type_id',1)->map(function ($item){ return $item->id; }))->get();
        $this->other_hours = $data->whereNotIn('hour_type_id',[1,2]);
        $this->technical_report_hours = TechnicalReportHour::with(['technical_report','technical_report.customer','hour'])->whereIn('hour_id',$data->where('hour_type_id',2)->map(function ($item){ return $item->id; }))->get();
    }

    public function selectHour(Hour $hour)
    {
        $this->hour_id = $hour->id;
        $this->date = $hour->date;
        $this->description = $hour->description;
        $this->user_id = $hour->user_id;
    }

    public function saveHour()
    {
        $hour = Hour::find($this->hour_id);
        if($this->other_hours->find($hour)->count == ''){
            $hour->delete();
            $this->emit('hourDeleted');
        }else{
            $hour->update([
                'count' => $this->other_hours->find($hour)->count
            ]);
            $this->emit('hourUpdated');
        }
        $this->refreshFields();
    }

    public function selectEmptyHour($user_id, $date,$hour_type)
    {
        $this->user_id = $user_id;
        $this->date = $date;
        $this->hour_type = $hour_type;
    }

    public function storeHour($index)
    {
        //dd($this->count,$this->user_id,$this->description,$this->date,$this->hour_type);
        $this->validateOnly('count');
        Hour::create([
            'count' => $this->count[$index],
            'user_id' => $this->user_id,
            'description' => $this->description,
            'date' => $this->date,
            'hour_type_id' => $this->hour_type
        ]);
        $this->emit('hourAdded');
        $this->refreshFields();
        $this->refresh();
    }

    public function refreshFields()
    {
        $this->hour_id = '';
        $this->count = '';
        $this->date = '';
        $this->description = '';
        $this->user_id = '';
    }
}
