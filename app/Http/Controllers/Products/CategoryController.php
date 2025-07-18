<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::select("id", "name")
        ->withCount("products")
        ->orderBy("products_count", "DESC")->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:100",
        ]);

        Gate::define("create", function(User $user){
            return $user->has_store && $user->isVerified();
        });

        if(Gate::denies('create')){
            return abort(403, "Unauthorized action");
        }

        $category = Category::create($validated);
        $success = boolval($category);

        return response()->json([
            "success" => $success,
            "category" => $category,
        ], $success ? 201 : 500);
    }
}
