<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function check(Request $request)
    {
        $user = Auth::User();
        // dd($user);

        if($user->status_akaun == '10')
        {
        $text = "Sila rujuk <b> Pegawai Bahagian Pengurusan Maklumat</b>";

        Toastr::error($text, 'Akaun anda tidak aktif!', [
            "positionClass" => "toast-top-center",
            "closeButton" => "true",
            ]);
        // dd($user);
        Auth::logout();

        // $request->flash('failed',"Sila rujuk Pegawai Bahagian Pengurusan Maklumat.");
        return redirect('login');
        }

        else
        {
        //dd('berdaftar');
        $user = Auth::user();
            Toastr::success('Selamat Datang <br> ' .$user->nama, 'Berjaya Log Masuk!', [
            "positionClass" => "toast-top-center",
            "closeButton" => "true",
        ]);

        return redirect()->route('home');
        }
    }

    public function index()
    {
        return view('home');
    }
}
