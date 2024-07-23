<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{   
    public function index()
    {
       try {
          $categories = Category::paginate(10);
          return response()->json($categories);
       } catch (\Throwable $th) {
           $response['status'] = false;
           $response['message'] = 'Categories Not found!.';
           return response()->json($response);
       }
    }
}
