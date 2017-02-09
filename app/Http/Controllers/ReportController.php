<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\EstimateDetail;
use Excel;

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

    public function exportMostEstimatedDetails()
    {
        $most_estimated_details = EstimateDetail::groupBy('product_id')
            ->select('product_id', \DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->get();

        $array = [];

        foreach ($most_estimated_details as $most_estimated_detail) {
            $product = $most_estimated_detail->product;

            $array[] = [
                'Código' => $product->code,
                'Producto' => $product->title,
                'Descripción' => $product->description,
                'Marca' => ($product->brand) ? $product->brand->title : 'Sin marca',
                'Categoría' => ($product->category) ? $product->category->title : 'Sin categoría',
                'Dimensiones' => ($product->dimensions) ? $product->dimensions : 'Sin dimensiones',
                'Cotizaciones' => $most_estimated_detail->total
            ];
        }

        return $this->exportExcel('Productos más cotizados', $array);
    }

    public function exportMostEstimatedCategories()
    {
        $most_estimated_categories = EstimateDetail::groupBy('category_id')
            ->leftJoin('products', 'products.id', 'estimate_details.product_id')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->where('products.category_id', '!=', 'null')
            ->select('category_id', \DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->get();

        $array = [];

        foreach ($most_estimated_categories as $most_estimated_category) {
            $category = Category::find($most_estimated_category->category_id);
            $array[] = [
                'Categoría' => $category->title,
                'Descripción' => $category->description,
                'Cotizaciones' => $most_estimated_category->total
            ];
        }

        return $this->exportExcel('Categorías más cotizadas', $array);
    }

    public function exportEstimatesByUser()
    {
        $users = User::all();

        $array = [];

        foreach ($users as $user) {
            $pending = $user->estimates()->where('status', 'Pendiente')->count();
            $accepted = $user->estimates()->where('status', 'Aceptada')->count();
            $rejected = $user->estimates()->where('status', 'Rechazada')->count();
            $array[] = [
                'Vendedor' => $user->name,
                'Pendientes' => ($pending > 0) ? $pending : '0',
                'Aceptadas' => ($accepted > 0) ? $accepted : '0',
                'Rechazadas' => ($rejected > 0) ? $rejected : '0'
            ];
        }

        return $this->exportExcel('Cotizaciones por vendedor', $array);
    }

    private function exportExcel($title = 'Reporte', $array = [])
    {
        $xls = Excel::create($title, function($excel) use ($title, $array) {
            $excel->setTitle($title);
            $excel->sheet($title, function($sheet) use ($array) {
                $sheet->fromArray($array);
            });
        });
        return $xls->download('xls');
    }
}
