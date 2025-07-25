<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\User;

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
            ->addColumn('trangthai', function ($users) {
                $text = $users->trangThai ? $users->trangThai->ten : 'Không rõ';

                switch ($users->trangthai) {
                    case 4:
                        $class = 'text-success';
                        $icon = 'bi bi-check-circle';
                        break;
                    case 5:
                        $class = 'text-danger';
                        $icon = 'bi bi-x-circle';
                        break;
                    default:
                        $class = 'text-secondary';
                        $icon = 'bi bi-dash-circle';
                        break;
                }

                return "<span class=\"$class\"><i class=\"$icon\"></i> $text</span>";
            })
            ->addColumn('action', function ($user) {
                return '<a href="#" class="btn btn-sm btn-primary">Sửa</a> 
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>';
            })
            ->rawColumns(['action', 'trangthai'])
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
            ->addColumn('trangthai', function ($admin) {
                $text = $admin->trangThai ? $admin->trangThai->ten : 'Không rõ';

                switch ($admin->trangthai) {
                    case 4:
                        $class = 'text-success';
                        $icon = 'bi bi-check-circle';
                        break;
                    case 5:
                        $class = 'text-danger';
                        $icon = 'bi bi-x-circle';
                        break;
                    default:
                        $class = 'text-secondary';
                        $icon = 'bi bi-dash-circle';
                        break;
                }

                return "<span class=\"$class\"><i class=\"$icon\"></i> $text</span>";
            })
            ->editColumn('created_at', function ($admin) {
                return Carbon::parse($admin->created_at)->format('d-m-Y H:i:s');
            })
            ->addColumn('action', function ($admin) {
                return '<a href="#" class="btn btn-sm btn-primary">Sửa</a> 
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>';
            })
            ->rawColumns(['action', 'trangthai'])
            ->make(true);
    }

    // Add Admin
    public function adminAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:admin,username',
                'regex:/^[a-zA-Z0-9_]+$/', // Không cho phép ký tự đặc biệt
            ],
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản.',
            'username.unique' => 'Tên tài khoản đã tồn tại.',
            'username.regex' => 'Tên tài khoản chỉ được chứa chữ, số và dấu gạch dưới (_), không có ký tự đặc biệt.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Tìm admin_id lớn nhất hiện có và +1
        $maxAdminId = DB::table('admin')->max('admin_id');
        $newAdminId = $maxAdminId ? $maxAdminId + 1 : 1;

        // Tạo admin mới
        DB::table('admin')->insert([
            'admin_id' => $newAdminId,
            'username' => $request->username,
            'password' => bcrypt($request->password),            
            'created_at' => now(),
            'trangthai' => 4,
        ]);

        return response()->json(['success' => 'Thêm sản Admin thành công']);
    }

    // Xóa  Admin
    public function adminDel($admin_id)
    {
        // try{
            $size = Admin::where('admin_id', $admin_id)->firstOrFail();
            $size->delete();
            return response()->json(['success' => true]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Lỗi xóa size: ' . $e->getMessage()], 500);
        // }
    }
    // Xóa User
    public function userDel($user_id)
    {
        // try{
            $size = User::where('user_id', $user_id)->firstOrFail();
            $size->delete();
            return response()->json(['success' => true]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Lỗi xóa size: ' . $e->getMessage()], 500);
        // }
    }

    public function danhmuc() {
        return view('admin.danhmuc');
    }

    public function thongke() {
        return view('admin.thongke');
    }
}
