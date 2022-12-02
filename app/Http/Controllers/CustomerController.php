<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $customers = Customer::all();

        return response()->view('customers.index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg,svg',
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $request->file('image')->storePublicly('public/images/customers');
            $image = $request->file('image')->hashName();
        }
        $new = Customer::factory()->create([
            'name' => $request->get('name'),
            'image' => $image,
        ]);
        session()->flash('target', $new);

        return redirect()->route('customers.index')->with('message', 'Cliente inserito con successo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('customers.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer  $customer
     * @return Response
     */
    public function edit(Customer $customer): Response
    {
        return response()->view('customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Customer  $customer
     * @return RedirectResponse
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg,svg',
        ]);
        if ($request->hasFile('image')) {
            $request->file('image')->storePublicly('public/images/customers');
            $customer->clearImage();
            $customer->update(['image' => $request->file('image')->hashName()]);
        } else {
            $customer->clearImage();
            $customer->update(['image' => null]);
        }
        $customer->update(['name' => $request->get('name')]);
        session()->flash('target', $customer);

        return redirect()->route('customers.index')->with('message', 'Cliente aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer  $customer
     * @return RedirectResponse
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        if ($customer->hasImage()) {
            $image = File::get('storage/images/customers/'.$customer->image);
            $type = File::mimeType('storage/images/customers/'.$customer->image);
            session()->flash('image', 'data:'.$type.';base64,'.base64_encode($image));
            $customer->deleteImage();
        }
        $customer->delete();
        session()->flash('target', $customer);

        return back()->with('message', 'Cliente eliminato con successo');
    }
}
