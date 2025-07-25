<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminThongkeController extends Controller
{
        public function thongke(Request $request)
    {
        $query = DB::table('hoadon');

        // Lọc theo request
        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->month) {
            $query->whereMonth('created_at', $request->month);
        }

        // if ($request->from_date) {
        //     $query->whereDate('created_at', '>=', $request->from_date);
        // }

        // if ($request->to_date) {
        //     $query->whereDate('created_at', '<=', $request->to_date);
        // }

        // Tổng quan
        $tongDoanhThu = DB::table('hoadon')
        ->where('tt_id', 2)
        ->sum('tongtien');

        $tongDonHang = DB::table('hoadon')->count();

        $tongDonHuy = DB::table('hoadon')
        ->where('tt_id', 3)
        ->count('tt_id');
        
        $tongSanPhamDaBan = DB::table('chitiethoadon as cthd')
        ->leftJoin('hoadon', 'hoadon.hd_id' , '=', 'cthd.hd_id')
        ->where('tt_id', 2)
        ->sum('soluong');

        $nam = $request->year ?? now()->year;
        $thang = $request->month ?? null;

        // Biểu đồ doanh thu theo tháng (nếu chỉ chọn năm)
        if (!$thang) {
            $doanhThuThangDB = DB::table('hoadon')
                ->whereYear('created_at', $nam)
                ->where('tt_id', 2)
                ->selectRaw('MONTH(created_at) as thang, SUM(tongtien) as tong')
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('tong', 'thang');

            $chartLabels = ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"];
            $chartData = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartData[] = $doanhThuThangDB[$i] ?? 0;
            }
        } else {
            // Biểu đồ doanh thu theo ngày trong tháng nếu chọn tháng
            $doanhThuNgayDB = DB::table('hoadon')
                ->whereYear('created_at', $nam)
                ->whereMonth('created_at', $thang)
                ->where('tt_id', 2)
                ->selectRaw('DAY(created_at) as ngay, SUM(tongtien) as tong')
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('tong', 'ngay');

            $soNgay = Carbon::createFromDate($nam, $thang)->daysInMonth;
            $chartLabels = [];
            $chartData = [];

            for ($i = 1; $i <= $soNgay; $i++) {
                $chartLabels[] = "Ngày $i";
                $chartData[] = $doanhThuNgayDB[$i] ?? 0;
            }
        }

        return view('admin.thongke', compact(
            'tongDoanhThu',
            'tongDonHang',
            'tongDonHuy',
            'tongSanPhamDaBan',
            'chartLabels',
            'chartData',
            'nam',
            'thang'
        ));
    }
}
