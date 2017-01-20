<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Brand;
use App\Category;
use App\Picture;
use Storage;
use Excel;

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
        $brands = [''=>''] + $brands->toArray();
        $categories = Category::pluck('title', 'id');
        $categories = [''=>''] + $categories->toArray();
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
            ->orWhere('code', 'like', '%'.$request->input('q').'%')
            ->with('pictures', 'brand', 'category')->get();
        $data = ['items' => [], 'total_count' => $products->count()];
        foreach ($products as $product) {
            $picture = (isset($product->pictures[0])) ? url('storage/'.$product->pictures[0]->url) : null;
            $push = [
                'id' => $product->id,
                'text' => $product->title,
                'title' => $product->title,
                'description' => $product->description,
                'code' => $product->code,
                'stock' => $product->stock,
                'regular_price' => $product->regular_price,
                'sale_price' => $product->sale_price,
                'brand' => ($product->brand) ? $product->brand->title : '',
                'category' => ($product->category) ? $product->category->title : '',
                'picture' => $picture
            ];
            array_push($data['items'], $push);
        }
        return $data;
    }

    /**
     * Import products from file.
     *
     * @return \Illuminate\Http\Response
     */
    public function importProducts(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            // Getting all results
            $results = $reader->get();

            foreach ($results as $result) {
                // TODO: Validate to avoid duplicates
                // $brand = Brand::where('title', $result->marca_producto)->first();
                // if($brand){
                //     $brand_id = $brand->id;
                // }else{
                //     $brand_id = Brand::create(['title' => $result->marca_producto, 'description' => $result->marca_producto])->id;
                // }
                //
                // $category = Category::where('title', $result->categoria_producto)->first();
                // if($category){
                //     $category_id = $category->id;
                // }else{
                //     $category_id = Brand::create(['title' => $result->categoria_producto, 'description' => $result->categoria_producto])->id;
                // }

                $exists = Product::where('title', $result->titulo_producto)->first();
                if(!$exists){
                    $photo_url = 'http://artificestore.mx/archivos/imagenes/'.$result->id_foto.'_image_'.$result->nombre_foto;
                    $file = @file_get_contents($photo_url);
                    $save = Storage::put('public/products/'.$result->nombre_foto, $file);
                    $picture = Picture::create([
                        'original_name' => $result->nombre_foto,
                        'url' => str_replace('/storage/', '', Storage::url('products/'.$result->nombre_foto))
                    ]);

                    $product = Product::create([
                        'title' => $result->titulo_producto,
                        'description' => $result->titulo_producto,
                        'code' => $result->sku_producto,
                        'stock' => 0,
                        'regular_price' => 0,
                        'sale_price' => null,
                        // 'brand_id' => $brand_id,
                        'brand_id' => null,
                        // 'category_id' => $category_id
                        'category_id' => null
                    ]);

                    $product->pictures()->sync([$picture->id]);
                }
            }

            session()->flash('flash_message', 'Se han importado '.$results->count().' productos');

        });
        return redirect('productos');
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
        $product->picture = (isset($product->pictures[0])) ? url('storage/'.$product->pictures[0]->url) : null;
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
