<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function index(int $id){
        $products = Beasiswa::all();

        return view('products.index',compact('products'));
    }

    public function createStepOne(Request $request)
    {
        $product = $request->session()->get('product');

        return view('products.create-step-one',compact('product'));
    }
}
