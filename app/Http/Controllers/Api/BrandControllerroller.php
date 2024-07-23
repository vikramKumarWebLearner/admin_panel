<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
class BrandControllerroller extends Controller
{
    public function index()
    {
       try {
          $brands = Brand::paginate(10);
          return response()->json($categories);
       } catch (\Throwable $th) {
           $response['status'] = false;
           $response['message'] = 'Barnds Not found!.';
           return response()->json($response);
       }
    }
}
