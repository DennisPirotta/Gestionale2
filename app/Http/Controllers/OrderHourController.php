<?php

namespace App\Http\Controllers;

use App\Models\OrderHour;
use Illuminate\Http\Request;

class OrderHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'signed' => ['required','boolean'],
            'order_id' => ['required','numeric'],
            'hour_id' => ['required','numeric'],
            'job_type_id' => ['required','numeric'],
        ]);
        OrderHour::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderHour  $orderHour
     * @return \Illuminate\Http\Response
     */
    public function show(OrderHour $orderHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderHour  $orderHour
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderHour $orderHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderHour  $orderHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderHour $orderHour)
    {
        $request->validate([
            'job_type_id' => ['required','numeric']
        ]);
        $orderHour->update([
            'job_type_id' => $request->get('job_type_id')
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderHour  $orderHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderHour $orderHour)
    {
        //
    }
}
