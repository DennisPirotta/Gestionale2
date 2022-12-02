<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $locations = User::find(request('user')) ? User::find(request('user'))->locations : $locations = Location::all();
        $events = [];
        foreach ($locations as $location) {
            $events[] = [
                'id' => $location->id,
                'start' => $location->date,
                'title' => $location->user->name.' - '.$location->description,
                'extendedProps' => [
                    'content' => $location->description,
                ],
            ];
        }

        return view('locations.index', [
            'locations' => Location::all(),
            'events' => $events,
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
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'location' => 'required',
            'date' => 'required',
        ]);
        Location::create([
            'description' => $validated['location'],
            'date' => $validated['date'],
            'user_id' => auth()->id(),
        ]);
        auth()->user()->flag('location');

        return back()->with('message', __('Location set correctly'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Location  $location
     * @return Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location  $location
     * @return Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Location  $location
     * @return RedirectResponse
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        $validated = $request->validate([
            'location' => 'required',
            'date' => 'required',
        ]);
        $location->update([
            'description' => $validated['location'],
            'date' => $validated['date'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('message', 'Posizione modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location  $location
     * @return RedirectResponse
     */
    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return back()->with('message', 'Posizione eliminata con successo');
    }
}
