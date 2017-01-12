<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EstimateRequest;
use App\Http\Requests\EstimateEmailRequest;
use Carbon\Carbon;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Estimate;
use App\EstimateDetail;
use App\Product;
use App\Client;
use App\Currency;
use App\User;
use App\Setting;
use Mail;
use App\Mail\EstimateGenerated;

class EstimateController extends Controller
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
        $emails = Client::pluck('email', 'email');
        $emails = ['' => ''] + $emails->toArray();
        $estimates = Estimate::latest()->paginate(5);
        return view('cotizaciones.index', compact('estimates', 'emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::pluck('name', 'id');
        $clients = [''=>''] + $clients->toArray();
        $currencies = Currency::pluck('title', 'id');
        $users = User::pluck('name', 'id');
        return view('cotizaciones.create', compact('clients', 'currencies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EstimateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstimateRequest $request)
    {
        $latest = Estimate::latest()->first();
        $folio = (is_null($latest)) ? sprintf('%05d', 1) : sprintf('%05d', $latest->folio + 1);
        $request->merge(['folio' => $folio]);
        if(!is_numeric($request->input('client_id'))){
            $request->merge(['name' => $request->input('client_id')]);
            $client = Client::create($request->all());
            $request->merge(['client_id' => $client->id]);
        }
        $estimate = Estimate::create($request->all());
        foreach ($request->input('estimate_details') as $item_estimate_detail) {
            $estimate->estimate_details()->create([
                'quantity' => $item_estimate_detail['qty'],
                'discount' => $item_estimate_detail['discount'],
                'product_id' => $item_estimate_detail['product_id']
            ]);
        }
        return redirect('cotizaciones');
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
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estimate $estimate)
    {
        $clients = Client::pluck('name', 'id');
        $clients = [''=>''] + $clients->toArray();
        $currencies = Currency::pluck('title', 'id');
        $users = User::pluck('name', 'id');
        return view('cotizaciones.edit', compact('estimate', 'clients', 'currencies', 'users'));
    }

    /**
     * Show the pdf of the specified resource.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function download(Estimate $estimate)
    {
        $setting = Setting::latest()->first();
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $filename = $setting->title.' - Cotización para '.$estimate->client->name.'['.Carbon::now().'].pdf';
        return $pdf->download($filename);
    }

    /**
     * Show the pdf of the specified resource.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function pdf(Estimate $estimate)
    {
        $setting = Setting::latest()->first();
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $filename = $setting->title.' - Cotización para '.$estimate->client->name.'['.Carbon::now().'].pdf';
        return $pdf->stream($filename);
    }

    /**
     * Show the pdf of the specified resource.
     *
     * @param  \App\Http\Requests\EstimateEmailRequest  $request
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function email(EstimateEmailRequest $request, Estimate $estimate)
    {
        // Email
        $setting = Setting::latest()->first();
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $filename = $setting->title.'_Cotización_para_'.$estimate->client->name.'-'.Carbon::now();
        $slug = str_slug($filename);
        $path = 'storage/cotizaciones/'.$slug.'.pdf';
        $pdf->save($path);
        $request->merge(['pdf' => $path]);
        Mail::to($request->input('email'))->send(new EstimateGenerated($estimate, $request));
        unlink($path);
        return redirect('cotizaciones');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Estimate  $request
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function update(EstimateRequest $request, Estimate $estimate)
    {
        foreach ($request->input('estimate_details') as $estimate_detail) {
             EstimateDetail::find($estimate_detail['id'])->delete();
        }
        if(!is_numeric($request->input('client_id'))){
            $request->merge(['name' => $request->input('client_id')]);
            $client = Client::create($request->all());
            $request->merge(['client_id' => $client->id]);
        }
        $estimate->update($request->all());
        foreach ($request->input('estimate_details') as $item_estimate_detail) {
            $estimate->estimate_details()->create([
                'quantity' => $item_estimate_detail['qty'],
                'discount' => $item_estimate_detail['discount'],
                'product_id' => $item_estimate_detail['product_id']
            ]);
        }
        session()->flash('flash_message', 'Se ha actualizado la cotización: '.$estimate->folio);
        return redirect('cotizaciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estimate $estimate)
    {
        $estimate->delete();
        session()->flash('flash_message', 'Se ha eliminado la cotización');
        return redirect('cotizaciones');
    }
}