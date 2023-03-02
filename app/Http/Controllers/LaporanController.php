<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->method() == 'POST')
        {
            // dd($request->all());
            $data = Pembayaran::where('tgl_bayar', '=', $request->tgl_bayar)->get();
            return view('laporan-pembayaran', ['data' => $data,'method'=>'POST','tgl_bayar'=>$request->tgl_bayar]);
        }


        return view('laporan-pembayaran',['method'=>'GET']);
    }

    public function cetakPdf(Request $request)
    {
        $data = DB::table('pembayaran')->where('tgl_awal', '>=', $request->tgl_mulai)->where('tgl_akhir', '<=', $request->tgl_akhir)->get();
        $pdf = PDF::loadView('laporan-pembayaran-pdf', ['data' => $data,'method'=>'POST','tgl_mulai'=>$request->tgl_mulai,'tgl_akhir'=>$request->tgl_akhir]);
        return $pdf->download('laporan-pembayaran.pdf');
    }
}
