<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CurrencyRequest;
use App\Currency;

class CurrencyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::latest()->paginate(5);
        return view('monedas.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('monedas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CurrencyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request)
    {
        $currency = Currency::create($request->all());
        session()->flash('flash_message', 'Se ha agregado la moneda: '.$currency->title);
        return redirect('monedas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('monedas.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CurrencyRequest  $request
     * @param  Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->all());
        session()->flash('flash_message', 'Se ha actualizado la moneda: '.$currency->title);
        return redirect('monedas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        // TODO: Delete all?
        $currency->delete();
        session()->flash('flash_message', 'Se ha eliminado la moneda');
        return redirect('monedas');
    }
}
