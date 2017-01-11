<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Setting;
use App\Currency;
use App\Picture;

class SettingController extends Controller
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
        $setting = Setting::first();
        $currencies = Currency::pluck('title', 'id');
        return view('ajustes.index', compact('currencies', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SettingRequest  $request
     * @param  Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        if($request->hasFile('sidebar_logo')){
            $url = $request->file('sidebar_logo')->store('public/logo');
            $setting->sidebar_logo->update([
                'original_name' => $request->file('logo')->getClientOriginalName(),
                'url' => str_replace('public/', '', $url)
            ]);
        }
        if($request->hasFile('estimate_logo')){
            $url = $request->file('estimate_logo')->store('public/logo');
            $setting->estimate_logo->update([
                'original_name' => $request->file('logo')->getClientOriginalName(),
                'url' => str_replace('public/', '', $url)
            ]);
        }
        $setting->update($request->all());
        session()->flash('flash_message', 'Se han actualizado los ajustes');
        return redirect('ajustes');
    }
}
