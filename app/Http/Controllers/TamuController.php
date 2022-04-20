<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_tamu;
use App\M_subscribe;
use App\Exports\TamuExport;
use Maatwebsite\Excel\Facades\Excel;

class TamuController extends Controller
{
    
    public function index(){
        $data_tamu = M_tamu::all();
        return view('admin.data-tamu',['alls'=>$data_tamu]);
    }

    public function kirim(Request $request){

        // dd($request);
        $post = new M_tamu();
        $post->nama = $request->nama;
        $post->check_in = $request->check_in;
        $post->check_out = $request->check_out;
        $post->pekerjaan = $request->pekerjaan;
        $post->alamat = $request->alamat;
        // $post->no_hp = $request->no_hp;

        $post->save();
        return view('tamu/success');
    }

    public function kirim_no(Request $request){

        // dd($request);
        $post = new M_subscribe();
        $post->no = $request->no;
        $post->save();
        return view('tamu/success');

    }

    public function filterTanggal(Request $request){

        // dd($request);

        $tanggal_awal = $request->tanggal1;
        $tanggal_akhir = $request->tanggal2;
        $data_tamu = M_tamu::whereDate('created_at','>=',$tanggal_awal)->whereDate('created_at','<=',$tanggal_akhir)->get();

        return view('admin.data-tamu',['alls'=>$data_tamu]);
        
    }

    public function indexAdmin(){
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );

        $tamu_hari_ini = M_tamu::whereDate('created_at', date('Y-m-d'))->get()->count();
        $tamu_kemarin = M_tamu::whereDate('created_at', $yesterday)->get()->count();
        $tamu_bulan_ini = M_tamu::whereMonth('created_at', date('m'))->get()->count();
        $tamu_total = M_tamu::all()->count();
        // dd($tamu_total);
        return view('admin/beranda')->with(compact('tamu_hari_ini', 'tamu_kemarin', 'tamu_bulan_ini', 'tamu_total'));
    }

    public function exportTamu(){
        return Excel::download(new TamuExport, 'List Tamu.xlsx');
    }

}
