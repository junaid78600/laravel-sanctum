<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CommonController extends Controller
{
   public function index(Request $request)
   {
        $data = Country::all();
        $response = [
            'data' => $data,
            'message' => 'Fetch Succesfully'
        ];
    
         return response($response, 201);

   }
}
