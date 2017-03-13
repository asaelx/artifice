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
use Auth;
use Config;

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
        $estimates = Estimate::latest()->paginate(5);
        $settings = Setting::first();
        return view('cotizaciones.index', compact('estimates', 'settings'));
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
        $request->merge(['expiration' => ($request->has('expiration') && $request->input('expiration') != '') ? $request->input('expiration') : Carbon::today()->addDays(5)->format('Y-m-d')]);

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
            $discount = (isset($item_estimate_detail['discount'])) ? $item_estimate_detail['discount'] : 0;
            $show_dimensions = (isset($item_estimate_detail['show_dimensions'])) ? $item_estimate_detail['show_dimensions'] : 0;
            $estimate->estimate_details()->create([
                'quantity' => $item_estimate_detail['qty'],
                'discount' => $discount,
                'total' => $item_estimate_detail['total'],
                'show_dimensions' => $show_dimensions,
                'product_id' => $item_estimate_detail['product_id']
            ]);
        }

        session()->flash('flash_message', 'Se ha generado la cotización: '.$estimate->folio);

        return redirect('cotizaciones');
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
        $header = $this->pdfHeader($estimate);
        $footer = $this->pdfFooter($estimate);
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $pdf->setOption('header-html', $header)->setOption('margin-top', 60);
        $pdf->setOption('footer-html', $footer)->setOption('margin-bottom', 90);
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
        $header = $this->pdfHeader($estimate);
        $footer = $this->pdfFooter($estimate);
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $pdf->setOption('header-html', $header)->setOption('margin-top', 60);
        $pdf->setOption('footer-html', $footer)->setOption('margin-bottom', 90);
        $filename = $setting->title.' - Cotización para '.$estimate->client->name.'['.Carbon::now().'].pdf';
        return $pdf->stream($filename);
        // return view('cotizaciones.pdf', compact('estimate'));
    }

    private function pdfHeader($estimate)
    {
        $settings = Setting::latest()->first();
        return view('cotizaciones.header', compact('estimate', 'settings'));
    }

    private function pdfFooter($estimate)
    {
        $settings = Setting::latest()->first();
        return view('cotizaciones.footer', compact('estimate', 'settings'));
    }

    /**
     * Get a json object of the discount code.
     *
     * @return \Illuminate\Http\Response
     */
    public function unlockDiscount(Request $request, $id)
    {
        $discount = Setting::where('discount_code', $request->input('discount_code'))->first();
        if($discount)
            return ['discount' => true, 'product_id' => $id];
        return ['discount' => false];
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
        $header = $this->pdfHeader($estimate);
        $footer = $this->pdfFooter($estimate);
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $pdf->setOption('header-html', $header)->setOption('margin-top', 60);
        $pdf->setOption('footer-html', $footer)->setOption('margin-bottom', 90);
        $filename = $setting->title.'_Cotización_para_'.$estimate->client->name.'-'.Carbon::now();
        $slug = str_slug($filename);
        $path = 'storage/cotizaciones/'.$slug.'.pdf';
        $pdf->save($path);
        $request->merge(['pdf' => $path]);

        Config::set('mail.username', Auth::user()->email);
        Config::set('mail.password', Auth::user()->email_password);
        Config::set('mail.from', ['address' => Auth::user()->email, 'name' => Auth::user()->name]);

        Mail::to($request->input('email'))->send(new EstimateGenerated($estimate, $request));
        unlink($path);
        $estimate->emails()->create([
            'to' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message')
        ]);
        session()->flash('flash_message', 'Se ha enviado la cotización '.$estimate->folio.' al correo: '.$request->input('email'));
        return redirect('cotizaciones');
        // return view('emails.estimate', compact('estimate', 'request'));
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
        // dd($request->all());
        $request->merge(['expiration' => ($request->has('expiration')) ? $request->input('expiration') : Carbon::today()->addDays(5)->format('Y-m-d')]);
        foreach ($estimate->estimate_details as $estimate_detail) {
            EstimateDetail::find($estimate_detail->id)->delete();
        }
        if(!is_numeric($request->input('client_id'))){
            $request->merge(['name' => $request->input('client_id')]);
            $client = Client::create($request->all());
            $request->merge(['client_id' => $client->id]);
        }
        $estimate->update($request->all());
        foreach ($request->input('estimate_details') as $item_estimate_detail) {
            $discount = (isset($item_estimate_detail['discount'])) ? $item_estimate_detail['discount'] : 0;
            $show_dimensions = (isset($item_estimate_detail['show_dimensions'])) ? $item_estimate_detail['show_dimensions'] : 0;
            $estimate->estimate_details()->create([
                'quantity' => $item_estimate_detail['qty'],
                'discount' => $discount,
                'total' => $item_estimate_detail['total'],
                'show_dimensions' => $show_dimensions,
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
