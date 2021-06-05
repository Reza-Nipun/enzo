<?php

namespace App\Http\Controllers\Website;

use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $category_list = Category::with(['subcategories'])->get();

        return view('enzo_site.home', compact('category_list'));
    }
}
