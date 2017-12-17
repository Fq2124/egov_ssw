<?php

namespace App\Http\Controllers\Admin\Tables;

use App\Contact;
use App\trPerizinanApotik;
use App\trPerizinanDepo;
use App\trPerizinanHama;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PerizinanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $now = Carbon::now();
        $tr_apotek = trPerizinanApotik::orderBy('created_at','desc')->get();
        $tr_hama = trPerizinanHama::orderBy('created_at','desc')->get();
        $tr_air = trPerizinanDepo::orderBy('created_at','desc')->get();
        $tr_subcribe = Contact::orderBy('created_at','desc')->get();
        $tr_user = User::orderBy('created_at','desc')->get();
        $dtapotek = array();
        $dthama = array();
        $dtair = array();
        $dtsub = array();
        $dtuser = array();
        foreach ($tr_apotek as $ap) {
            $compare = $now->copy()->subDay()->lte($ap->created_at);
            if ($compare == true) {
                $dtapotek [] = array(
                    'id' => $ap->id,
                    'id_admin' => $ap->id_admin,
                    'id_pemohon' => $ap->id_pemohon,
                    'id_pemilik' => $ap->id_pemilik,
                    'id_alat' => $ap->id_alat,
                    'id_apoteker' => $ap->id_apoteker,
                    'id_apotek' => $ap->id_apotek,
                    'user_id' => $ap->user_id,
                    'name' => $ap->name,
                    'no_Hygiene' => $ap->no_Hygiene,
                    'status' => $ap->status,
                    'file_berkas' => $ap->file_berkas,
                    'tgl_perizinan' => $ap->tgl_perizinan, 'tgl' => $ap->created_at);
            }
        }
        $c_apotik = count($dtapotek);

        foreach ($tr_hama as $ha) {
            $compare2 = $now->copy()->subDay()->lte($ha->created_at);
            if ($compare2 == true) {
                $dthama[] = array('id' => $ha->id,
                    'id_admin' => $ha->id_admin,
                    'id_pemohon' => $ha->id_pemohon,
                    'id_perusahaan' => $ha->id_perusahaan,
                    'user_id' => $ha->user_id,
                    'name' => $ha->name,
                    'status' => $ha->status,
                    'file_berkas' => $ha->file_berkas,
                    'tgl' => $ha->created_at);
            }
        }
        $c_hama = count($dthama);

        foreach ($tr_air as $air) {
            $compare2 = $now->copy()->subDay()->lte($air->created_at);
            if ($compare2 == true) {
                $dtair []= array(
                    'id' => $air->id,
                    'user_id' => $air->user_id,
                    'id_admin' => $air->id_admin,
                    'id_pemohon' => $air->id_pemohon,
                    'id_depo' => $air->id_depo,
                    'name' => $air->name,
                    'status' => $air->status,
                    'file_berkas' => $air->file_berkas,
                    'tgl_perizinan' => $air->tgl_perizinan,
                    'created_at' => $air->created_at);
            }
        }
        $c_air = count($dtair);
        foreach ($tr_subcribe as $subc) {
            $compare2 = $now->copy()->subDay()->lte($subc->created_at);
            if ($compare2 == true) {
                $dtsub[] = array(
                    'id' => $subc->id,
                    'name' => $subc->name,
                    'email' => $subc->email,
                    'subject' => $subc->subject,
                    'message' => $subc->message,
                    'created_at' => $subc->created_at,
                );
            }
        }
        $feedback_t = count($dtsub);
        $feedback = count($dtsub);
        foreach ($tr_user as $userr) {
            $compare2 = $now->copy()->subDay()->lte($userr->created_at);
            if ($compare2 == true) {
                $dtuser[] = array(
                    'id' => $userr->id,
                    'ava' => $userr->ava,
                    'name' => $userr->name,
                    'phone' => $userr->phone,
                    'alamat' => $userr->alamat,
                    'pekerjaan' => $userr->pekerjaan,
                    'email' => $userr->email,
                    'password' => $userr->password,
                    'status' => $userr->status,
                    'verifyToken' => $userr->verifyToken,
                    'remember_token' => $userr->remember_token,
                    'created_at' => $userr->created_at
                );
            }
        }
//        dd($dthama,count($dtair),$dtapotek);
        $awal=null;
        $akhir=null;

if (Auth::user()->lastname==2){
    $awal=1; $akhir=2;
}
if (Auth::user()->lastname==3){
    $awal=2; $akhir=3;
}
if (Auth::user()->lastname==4){
    $awal=3; $akhir=4;
}
if (Auth::user()->lastname==5){
    $awal=4; $akhir=5;
}
if (Auth::user()->lastname==6){
    $awal=5; $akhir=6;
}

        $member = count($dtuser);
        $notif = $c_apotik + $c_air + $c_hama + $feedback + $member;
        return view('admin.table_perizinan', compact('awal','akhir','dtapotek', 'dthama', 'dtair', 'dtsub', 'dtuser','c_apotik', 'c_air', 'c_hama', 'feedback', 'feedback_t', 'member', 'notif'));
    }

    public function aktif($id)
    {
        if (Auth::user()->lastname==2){
            trPerizinanApotik::findOrFail($id)->update(['status' => 2]);
        }
        if (Auth::user()->lastname==3){
            trPerizinanApotik::findOrFail($id)->update(['status' => 3]);
        }
        if (Auth::user()->lastname==4){
            trPerizinanApotik::findOrFail($id)->update(['status' => 4]);
        }
        if (Auth::user()->lastname==5){
            trPerizinanApotik::findOrFail($id)->update(['status' => 5]);
        }
        if (Auth::user()->lastname==6){
            trPerizinanApotik::findOrFail($id)->update(['status' => 6]);
        }
Session::flash('status','Approve is successful');
        return back();

    }public function aktifdepo($id)
    {
        if (Auth::user()->lastname==2){
            trPerizinanDepo::findOrFail($id)->update(['status' => 2]);
        }
        if (Auth::user()->lastname==3){
            trPerizinanDepo::findOrFail($id)->update(['status' => 3]);
        }
        if (Auth::user()->lastname==4){
            trPerizinanDepo::findOrFail($id)->update(['status' => 4]);
        }
        if (Auth::user()->lastname==5){
            trPerizinanDepo::findOrFail($id)->update(['status' => 5]);
        }
        if (Auth::user()->lastname==6){
            trPerizinanDepo::findOrFail($id)->update(['status' => 6]);
        }
Session::flash('status','Approve is successful');
        return back();

    }public function aktifhama($id)
    {
        if (Auth::user()->lastname==2){
            trPerizinanHama::findOrFail($id)->update(['status' => 2]);
        }
        if (Auth::user()->lastname==3){
            trPerizinanHama::findOrFail($id)->update(['status' => 3]);
        }
        if (Auth::user()->lastname==4){
            trPerizinanHama::findOrFail($id)->update(['status' => 4]);
        }
        if (Auth::user()->lastname==5){
            trPerizinanHama::findOrFail($id)->update(['status' => 5]);
        }
        if (Auth::user()->lastname==6){
            trPerizinanHama::findOrFail($id)->update(['status' => 6]);
        }
Session::flash('status','Approve is successful');
        return back();

    }
}

