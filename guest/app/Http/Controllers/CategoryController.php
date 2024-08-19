<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index($slug,$id){
        $categoriesLimit = Category::where('parent_id',0)->take(3)->get();
        $products = Product::where('category_id',$id)->paginate(3);
        $categories = Category::where('parent_id',0)->get();

        return view('product.category.list',compact('categoriesLimit','products','categories'));
    }
}
