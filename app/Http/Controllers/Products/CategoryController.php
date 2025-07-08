<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::select("id", "name")->latest()->get();
    }

    public function store(Request $request)
    {
        //
    }
}
