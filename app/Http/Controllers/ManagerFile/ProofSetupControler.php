<?php

namespace App\Http\Controllers\ManagerFile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;




use Exception;


use function PHPUnit\Framework\countOf;

class ProofSetupControler extends Controller

{
    public function index(){
        return view('mangerfile.proof_setup.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

}
