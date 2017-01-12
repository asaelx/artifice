<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Brand;
use App\Category;
use App\Picture;

class ProductController extends Controller
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
        $products = Product::latest()->paginate(5);
        $brands = Brand::pluck('title', 'id');
        $categories = Category::pluck('title', 'id');
        return view('productos.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Get a json object of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts(Request $request)
    {
        $products = Product::latest()
            ->where('title', 'like', '%'.$request->input('q').'%')
            ->orWhere('code', $request->input('q'))
            ->with('pictures', 'brand', 'category')->get();
        $data = ['items' => [], 'total_count' => $products->count()];
        foreach ($products as $product) {
            $push = [
                'id' => $product->id,
                'text' => $product->title,
                'title' => $product->title,
                'description' => $product->description,
                'code' => $product->code,
                'stock' => $product->stock,
                'regular_price' => $product->regular_price,
                'sale_price' => $product->sale_price,
                'brand' => $product->brand->title,
                'category' => $product->category->title,
                'picture' => url('storage/'.$product->pictures[0]->url)
            ];
            array_push($data['items'], $push);
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::pluck('title', 'id');
        $brands = [''=>''] + $brands->toArray();
        $categories = Category::pluck('title', 'id');
        $categories = [''=>''] + $categories->toArray();
        return view('productos.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if(!is_numeric($request->input('brand_id')) && $request->input('brand_id') != ''){
            $brand = Brand::create(['title' => $request->input('brand_id'), 'description' => $request->input('brand_id')]);
            $request->merge(['brand_id' => $brand->id]);
        }
        if(!is_numeric($request->input('category_id')) && $request->input('category_id') != ''){
            $category = Category::create(['title' => $request->input('category_id'), 'description' => $request->input('category_id')]);
            $request->merge(['category_id' => $category->id]);
        }
        $product = Product::create($request->all());
        if($request->hasFile('photos')){
            foreach ($request->file('photos') as $photo) {
                $url = $photo->store('public/products');
                $picture = Picture::create([
                    'original_name' => $photo->getClientOriginalName(),
                    'url' => str_replace('public/', '', $url)
                ]);
                $product->pictures()->sync([$picture->id]);
            }
        }
        session()->flash('flash_message', 'Se ha agregado el producto: '.$product->title);
        return redirect('productos');
    }

    /**
     * Get the json of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductById($id)
    {
        $product = Product::with('pictures', 'brand', 'category')
            ->find($id);
        $product->picture = url('storage/'.$product->pictures[0]->url);
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::pluck('title', 'id');
        $categories = Category::pluck('title', 'id');
        return view('productos.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());
        session()->flash('flash_message', 'Se ha actualizado el producto: '.$product->title);
        return redirect('productos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('flash_message', 'Se ha eliminado el producto');
        return redirect('productos');
    }
}