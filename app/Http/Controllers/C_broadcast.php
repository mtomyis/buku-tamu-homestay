<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\M_broadcast;
use App\M_subscribe;

class C_broadcast extends Controller
{
    public function index(){
        $data_broadcast = M_broadcast::all();
        $data_subscribe = M_subscribe::all();

        return view('admin/broadcast')->with(compact('data_broadcast', 'data_subscribe'));
    }

    public function kirimBroadcast(Request $request){

        $pesan = $request->pesan;

        $post = new M_broadcast();
        $post->judul = $request->judul;
        $post->pesan = $pesan;
        $post->save();

        $data_no = M_subscribe::all();

        $i=1;
        foreach ($data_no as $no) {

            $curl[$i] = curl_init();
            $data[$i] = [
                "message" => "${pesan}",
                "jid" => $no->no."@s.whatsapp.net",
                "apikey"=> "V9TyqnGIoQQO"
            ];
            $payload[$i] = json_encode($data[$i]);
            $ch[$i] = curl_init("https://whatsva.com/api/sendMessageText");
            curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $payload[$i]);
            curl_setopt($ch[$i], CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
            $result[$i] = curl_exec($ch[$i]);
            curl_close($ch[$i]);

            $i++;
        }

        return back();
    }

    public function EditNomor(Request $request){

        // dd($request);
        M_subscribe::where('id_subscribe',$request->id)
        ->update([
           'no' => $request->no
         ]);
        return redirect()->back();

    }

    public function deleteBroadcast($id)
    {
        M_broadcast::where('id_broadcast',$id)->delete();
        return redirect()->back();
    }
    public function deleteNo($id)
    {
        M_subscribe::where('id_subscribe',$id)->delete();
        return redirect()->back();
    }
}
