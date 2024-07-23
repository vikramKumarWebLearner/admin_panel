<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    
      public function index()
      {
         try {
            $products = Product::paginate(10);
            return response()->json($products);
         } catch (\Throwable $th) {
             $response['status'] = false;
             $response['message'] = 'Products Not found!.';
             return response()->json($response);
         }
      }
}
