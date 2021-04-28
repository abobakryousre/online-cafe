<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function __construct(){
        $this->middleware("auth:sanctum");

    }

    function index()
    {
        $categories = Category::all();
        return $categories;
    }



    public function show(Category $category)
    {
        return $category;
    }




    function store(Request $request)
    {
        $add = Category::create($request->all());
        if ($add) {
            return response()->json(["message" => "New Category added successfully"]);
        } else {
            return response()->json(["message" => "New Category not added successfully"]);
        }
    }



    public function update(Request $request, Category $category)
    {
        $update = $category->update($request->all());
        if ($update) {
            return response()->json(["message" => "New Category updated successfully"]);
        } else {
            return response()->json(["message" => "New Category not updated successfully"]);
        }
    }


    public function destroy(Category $category)
    {

        $delete = $category->delete();
        if ($delete) {
            return response()->json(["message" => "New Category deleted successfully"]);
        } else {
            return response()->json(["message" => "New Category not deleted successfully"]);
        }
    }
}
