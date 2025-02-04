<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Pinjam;
use App\Aduan;
use App\Pembekal;
use App\IventoriIct;

class HomeControllerA extends Controller
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

    public function check(Request $request)
    {
        $user = Auth::User();
        //dd($user);

        if($user->id_status == '7')
        {
        $text = "Sila rujuk <b> Pegawai Bahagian Pengurusan Maklumat</b>";

        Toastr::error($text, 'Akaun anda tidak aktif!', [
            "positionClass" => "toast-top-center",
            "closeButton" => "true",
            ]);
        //dd($user);
        Auth::logout();
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     // public function home()
     // {
     //   return view('welcome');
     // }

    public function index()
    {

      if(Auth::user()->id_status == '7')
      {
        Auth::logout();
        return redirect('login');
      }

      else
      {
      $user = Auth::user();

      $countPembekal = Pembekal::all();
      $countPeralatanICTBayurini = IventoriIct::all()->where('id_pembekal','=','2');
      $countPeralatanICTNE = IventoriIct::all()->where('id_pembekal','=','1');

      $countPermohonan = Pinjam::all();
      $countPermohonanBaru = Pinjam::where('id_status','=','1');
      $countPermohonanLulus = Pinjam::where('id_status','=','2');
      $countPermohonanGagal = Pinjam::where('id_status','=','3');
      $countPermohonanSelesai = Pinjam::where('id_status','=','4');

      $countPinjamanPeralatanSidangVideo = Pinjam::where('jenis_perkhidmatan','=','Pinjaman Peralatan + Sidang Video');

      $countAduan = Aduan::all();
      $countAduanBaru = Aduan::where('id_status','=','1');
      $countAduanSelesai = Aduan::where('id_status','=','4');
      $countAduanDipanjangkan = Aduan::where('id_status','=','12');
      $countAduanDiagihkan = Aduan::where('id_status','=','11');

      return view('home', compact('user','countPembekal','countPeralatanICTBayurini','countPeralatanICTNE','countAduan','countAduanBaru','countAduanSelesai','countAduanTindakan','countPermohonan', 'countPermohonanBaru', 'countPermohonanLulus', 'countPermohonanGagal', 'countPermohonanSelesai' ));
    }

  }
}
