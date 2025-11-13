<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // sementara tampilkan view kosong
        return view('customer.cart.index');
    }
}
