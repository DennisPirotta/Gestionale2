<?php

namespace App\Http\Controllers;

use App\Models\TechnicalReportHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TechnicalReportHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nightEU' => ['required','boolean'],
            'nightXEU' => ['required','boolean'],
            'hour_id' => ['required','numeric'],
            'technical_report_id' => ['required','numeric'],
        ]);
        TechnicalReportHour::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param TechnicalReportHour $technicalReportHour
     * @return Response
     */
    public function show(TechnicalReportHour $technicalReportHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TechnicalReportHour $technicalReportHour
     * @return Response
     */
    public function edit(TechnicalReportHour $technicalReportHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TechnicalReportHour $technicalReportHour
     * @return RedirectResponse
     */
    public function update(Request $request, TechnicalReportHour $technicalReportHour)
    {
        $request->validate([
            'night_eu' => ['required','bool'],
            'night_xeu' => ['required','bool']
        ]);

        $technicalReportHour->update([
            'nightEU' => $request->get('night_eu'),
            'nightXEU' => $request->get('night_xeu')
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TechnicalReportHour $technicalReportHour
     * @return Response
     */
    public function destroy(TechnicalReportHour $technicalReportHour)
    {
        //
    }
}
