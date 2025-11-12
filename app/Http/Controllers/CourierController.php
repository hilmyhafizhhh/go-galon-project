<?php

namespace App\Http\Controllers;

class CourierController extends Controller
{
    public function index()
    {
        return view('admin.couriers.index');
    }
}
