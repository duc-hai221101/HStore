<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function show($id)
    {   
         $sliders = Slider::latest()->get();
        $categories = Category::where('parent_id', 0)->get();
        $products = Product::latest()->take(6)->get();
        $recommendView = Product::orderBy('views_count', 'desc')->take(12)->get();
        $categoriesLimit = Category::where('parent_id', 0)->take(3)->get();
        $product = Product::findOrFail($id);

        return view('product.show', compact('product','sliders', 'categories', 'products', 'recommendView', 'categoriesLimit'));
    }
    public function searchAutocomplete(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        $output = '<ul class="list-unstyled">';

        foreach ($products as $product) {
            $output .= '<li>' . $product->name . '</li>';
        }

        $output .= '</ul>';

        return response()->json($output);
    }
    public function search(Request $request)
    {
        $sliders = Slider::latest()->get();
        $categories = Category::where('parent_id', 0)->get();
        $products = Product::latest()->take(6)->get();
        $recommendView = Product::orderBy('views_count', 'desc')->take(12)->get();
        $categoriesLimit = Category::where('parent_id', 0)->take(3)->get();
        $query = $request->input('query');

        // Tìm kiếm sản phẩm theo tên
        $products = Product::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('content', 'LIKE', '%' . $query . '%')
            ->get();

        return view('search.results', compact('products', 'query', 'sliders', 'categories', 'products', 'recommendView', 'categoriesLimit'));
    }
    public function index()
    {
        $sliders = Slider::latest()->get();
        $categories = Category::where('parent_id', 0)->get();
        $products = Product::latest()->take(6)->get();
        $recommendView = Product::orderBy('views_count', 'desc')->take(12)->get();
        $categoriesLimit = Category::where('parent_id', 0)->take(3)->get();

        return view('home.home', compact('sliders', 'categories', 'products', 'recommendView', 'categoriesLimit'));
    }
}
