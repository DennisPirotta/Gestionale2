<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use JsonException;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function index(): Response
    {
         return response()->view('dashboard',[
             'eur_chf' => $this->requireData('EUR/CHF'),
             'eur_usd' => $this->requireData('EUR/USD'),
             'usd_chf' => $this->requireData('USD/CHF'),
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function requireData($symbol): array
    {
        $exchanges = Exchange::where('symbol',$symbol)->orderBy('datetime')->take(1000)->get();
        $data = [];
        foreach ($exchanges as $exchange) {
            $data[] = [
                'x' => $exchange->datetime,
                'y' => $exchange->value,
            ];
        }
        return $data;
    }
}
