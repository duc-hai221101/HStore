<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->get();
        $categories = Category::where('parent_id',0)->get();
        $products = Product::latest()->take(6)->get();
        $recommendView = Product::orderBy('views_count', 'desc')->take(12)->get();
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();

        return view('home.home',compact('sliders','categories','products','recommendView','categoriesLimit'));
    }
}
