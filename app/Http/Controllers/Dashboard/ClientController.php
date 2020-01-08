<?php

namespace App\Http\Controllers\Dashboard;

use App\Dashboard\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::when($request->search, function($q) use ($request){

            return $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:99',
            'phone' => 'required|array',
            'phone.0' => 'required',
            'address' => 'required|min:2|max:500',
        ]);

        $data['phone'] = array_filter($data['phone']);

        Client::create($data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:99',
            'phone' => 'required|array',
            'phone.0' => 'required',
            'address' => 'required|min:2|max:500',
        ]);

        $data['phone'] = array_filter($data['phone']);

        $client->update($data);

        session()->flash('success', __('site.updaded_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.clients.index');
    }
}
