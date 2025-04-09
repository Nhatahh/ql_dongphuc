<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function cart() {
        return view('user.orders.cart');
    }

    public function payment() {
        return view('user.order.payment');
    }
}
