<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estimate;
use App\Client;
use App\Product;
use App\Brand;
use App\Category;
use App\User;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimates = Estimate::all();
        $clients = Client::all();
        $products = Product::all();
        $brands = Brand::all();
        $categories = Category::all();
        $users = User::all();
        return view('dashboard', compact('estimates', 'clients', 'products', 'brands', 'categories', 'users'));
    }
}
