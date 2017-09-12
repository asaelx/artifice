<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Category;
use Excel;

class CategoryController extends Controller
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
        $categories = Category::latest()->paginate(5);
        return view('categorias.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        session()->flash('flash_message', 'Se ha agregado la categoría: '.$category->title);
        return redirect('categorias');
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
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categorias.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        session()->flash('flash_message', 'Se ha actualizado la categoría: '.$category->title);
        return redirect('categorias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // TODO: Delete products?
        $category->delete();
        session()->flash('flash_message', 'Se ha eliminado la categoría');
        return redirect('categorias');
    }

    public function exportProducts(Category $category)
    {
        $products = $category->products;
        $array = [];
        $title = 'Productos';

        foreach ($products as $product) {
            $array[] = [
                'Producto' => $product->title,
                'Descripción' => $product->description,
                'Dimensiones' => ($product->dimensions) ? $product->dimensions : 'Sin dimensiones',
                'Código' => ($product->code) ? $product->code : 'Sin código',
                'Precio Regular' => $product->regular_price,
                'Precio de oferta' => ($product->sale_price) ? $product->sale_price : 'Sin oferta',
                'Marca' => ($product->brand) ? $product->brand->title : 'Sin marca',
                'Categoría' => ($product->category) ? $product->category->title : 'Sin categoría'
            ];
        }

        $xls = Excel::create($title, function($excel) use ($title, $array) {
            $excel->setTitle($title);
            $excel->sheet($title, function($sheet) use ($array) {
                $sheet->fromArray($array);
            });
        });
        return $xls->download('xls');
    }
}
