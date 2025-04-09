<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UniformController extends Controller
{
    public function store() {
        return view('user.uniforms.store');
    }

    public function show_detail($id) {
        return view('user.uniforms.show_detail');
    }
}
