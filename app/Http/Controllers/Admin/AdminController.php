<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function donhang() {
        return view('admin.donhang'); 
    }
    public function indexAdmin() {
        return view('admin.taikhoan'); // view hiển thị danh sách account
    }
    public function getUserData(Request $request)
    {
        $users = User::with('trangThai')->select([
            'user_id',
            'username',
            'mssv',
            'email',
            'sdt',
            'hoten',
            'diachi',
            'trangthai'
        ]);

        return DataTables::of($users)
            ->addColumn('trangthai', function ($user) {
                return $user->trangThai ? $user->trangThai->ten : 'Không rõ';
            })
            ->addColumn('action', function ($user) {
                return '<a href="#" class="btn btn-sm btn-primary">Sửa</a> 
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getAdminData(Request $request)
    {
        $admins = Admin::with('trangThai')->select([
            'admin_id',
            'username',
            'password',
            'created_at',
            'trangthai'
        ]);

        return DataTables::of($admins)
            ->addColumn('trangthai', function ($user) {
                return $user->trangThai ? $user->trangThai->ten : 'Không rõ';
            })
            ->addColumn('action', function ($admin) {
                return '<a href="#" class="btn btn-sm btn-primary">Sửa</a> 
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function danhmuc() {
        return view('admin.danhmuc');
    }
    
    public function thongke() {
        return view('admin.thongke');
    }
}
