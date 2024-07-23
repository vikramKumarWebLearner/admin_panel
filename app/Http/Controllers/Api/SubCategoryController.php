<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
class SubCategoryController extends Controller
{
    public function index()
    {
       try {
          $categories = SubCategory::paginate(10);
          return response()->json($categories);
       } catch (\Throwable $th) {
           $response['status'] = false;
           $response['message'] = 'SubCategories Not found!.';
           return response()->json($response);
       }
    }
}
