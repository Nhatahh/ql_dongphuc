<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    public function cart() {
        return view('user.orders.cart');
    }

    public function payment() {
        return view('user.orders.payment');
    }
}
