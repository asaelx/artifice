<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EstimateDetail;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $estimate_details = EstimateDetail::all();
        $most_estimated_details = EstimateDetail::groupBy('product_id')
            ->select('product_id', \DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->get();
        $most_estimated_categories = EstimateDetail::groupBy('category_id')
            ->leftJoin('products', 'products.id', 'estimate_details.product_id')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->where('products.category_id', '!=', 'null')
            ->select('category_id', \DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->get();

        return view('reportes.index', compact(
                    'users',
                    'estimates',
                    'estimate_details',
                    'most_estimated_details',
                    'most_estimated_categories'
                ));
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
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
