<?php

namespace App\Http\Controllers;

use App\PermohonanKenderaan;
use App\PermohonanBilik;
use App\LkpBilik;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use DB;

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

        if( !is_null($user) ){
        // if($user){
            // $user = Auth::user();
            
            Toastr::success('Selamat Datang <br> ' .$user->nama, 'Berjaya Log Masuk!', [
                "positionClass" => "toast-top-center",
                "closeButton" => "true",
            ]);

            if($user->id_access == 3) { //if admin Bilik Mesyuarat
                return redirect()->route('homeBilikMeet'); 
            }
            else { //if admin Kenderaan
                return redirect()->route('home'); 
            }

            if($user->status_akaun == '10'){
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
        }
        else
        {
            // return 'not ok';
            Auth::logout();
            $request->session()->flash('failedLogin', "Kesalahan login.");
            return redirect('/login');
        }

    }

    public function index()
    {
        $countPermohonan = PermohonanKenderaan::get();
        $countPermohonanBaru = PermohonanKenderaan::whereIn('id_status',[1,2]);
        $countPermohonanLulus = PermohonanKenderaan::whereIn('id_status',['3','11']);
        $countPermohonanGagal = PermohonanKenderaan::whereIn('id_status',['4','6']);

        $countTujuan = DB::select('SELECT count(p.id_tujuan) as bil, t.tujuan
                        FROM permohonan_kenderaan p, lkp_tujuan t
                        where p.id_tujuan = t.id_tujuan
                        group by(t.tujuan)');

        $countBulan = DB::select('SELECT  DATE_FORMAT(p.created_by, "%M") AS bulan, count(p.id_maklumat_permohonan) as permohonan
                        FROM permohonan_kenderaan p
                        group by DATE_FORMAT(p.created_by, "%M")
                        order by p.created_by');


        // $pergerakans=DB::select('SELECT t.kenderaan_pergi, t.kenderaan_balik, pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi, pk.masa_balik, pk.id_jenis_perjalanan, pk.lokasi_tujuan, pk.id_tujuan, pk.id_negeri, pk.keterangan_lanjut, pk.kod_permohonan
        //                 from tindakan t
        //                 join permohonan_kenderaan pk on (pk.id_maklumat_permohonan=t.id_permohonan)
        //                 where t.id_status_tempah in (3,11)
        //                 and pk.tkh_pergi>=DATE(NOW())
        //                 order by pk.tkh_pergi asc
        //                 ');
        $pergerakans=DB::select('SELECT t.kenderaan_pergi, t.kenderaan_balik, pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi, pk.masa_balik, pk.id_jenis_perjalanan, pk.lokasi_tujuan, pk.id_tujuan, pk.id_negeri, pk.keterangan_lanjut, pk.kod_permohonan
                        from permohonan_kenderaan pk
                        join tindakan t on pk.id_maklumat_permohonan=t.id_permohonan
                          and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = pk.id_maklumat_permohonan and t1.id_status_tempah in (3,11))

                        where CONCAT(pk.tkh_pergi," ",pk.masa_pergi)>CURRENT_TIMESTAMP()
                        or CONCAT(pk.tkh_balik," ",pk.masa_balik)>CURRENT_TIMESTAMP()
                        order by pk.tkh_pergi
                        limit 5');
        // dd($pergerakans);

        return view('home',  compact('countPermohonan','countPermohonanBaru','countPermohonanLulus','countPermohonanGagal','countTujuan','countBulan','pergerakans'));
    }

    public function home()
    {
        $countPermohonan = PermohonanBilik::get();
        $countPermohonanBaru = PermohonanBilik::whereIn('id_status',[1,2]);
        $countPermohonanLulus = PermohonanBilik::whereIn('id_status',['3','11']);
        $countPermohonanGagal = PermohonanBilik::whereIn('id_status',['4','6']);

        $countTujuan = DB::select('SELECT count(p.id_tujuan) as bil, t.tujuan
                        FROM permohonan_bilik p, lkp_tujuan t
                        where p.id_tujuan = t.id_tujuan
                        group by(t.tujuan)');

        $countBulan = DB::select('SELECT  DATE_FORMAT(p.created_at, "%M") AS bulan, count(p.id_permohonan_bilik) as permohonan
                        FROM permohonan_bilik p
                        group by DATE_FORMAT(p.created_at, "%M")
                        order by "%M" DESC');

        $countKaterers = DB::select('SELECT lkp_katerer.nama_katerer, y.bilkaterer, y.jumlah
                          from(SELECT tempah_makan.pembekal, COUNT(tempah_makan.id_tempah_makan) as bilkaterer, sum(kadar_harga) as jumlah
                          FROM tempah_makan
                          GROUP BY tempah_makan.pembekal) as y
                          JOIN lkp_katerer on (lkp_katerer.id_katerer=y.pembekal)');

        $biliks = DB::select('SELECT c.singkatan,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=1 and p.bahagian=c.bahagian) as BilikMesyuaratPerpaduan3A5,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=2 and p.bahagian=c.bahagian) as BilikBincang1A5,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=3 and p.bahagian=c.bahagian) as BilikMesyuaratUtamaA5,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=4 and p.bahagian=c.bahagian) as BilikBincang1A52,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=5 and p.bahagian=c.bahagian) as BilikBincang2A5,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=6 and p.bahagian=c.bahagian) as warRoomA6,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=7 and p.bahagian=c.bahagian) as BilikBincang1A6,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=8 and p.bahagian=c.bahagian) as BilikBincang2A6,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=9 and p.bahagian=c.bahagian) as BilikBincangA6,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=10 and p.bahagian=c.bahagian) as BilikMesyuaratA7,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=11 and p.bahagian=c.bahagian) as BilikBincangA7,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=12 and p.bahagian=c.bahagian) as BilikLatihanKomputer1A7,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=13 and p.bahagian=c.bahagian) as BilikLatihanKomputer2A7,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=14 and p.bahagian=c.bahagian) as BilikMesyuaratPerpaduan2A8,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=15 and p.bahagian=c.bahagian) as BilikBincangA8,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=16 and p.bahagian=c.bahagian) as BilikBincang1A8,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=17 and p.bahagian=c.bahagian) as BilikBincang2A8,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=18 and p.bahagian=c.bahagian) as BilikBincangA9,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=19 and p.bahagian=c.bahagian) as BilikMesyuaratA9,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=20 and p.bahagian=c.bahagian) as BilikBincang2A9,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=21 and p.bahagian=c.bahagian) as BilikMesyuaratPerpaduanA10,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=22 and p.bahagian=c.bahagian) as BilikBincang1A10,

        (SELECT count(b.id_bilik)
        FROM emanagement.pemohon p
        LEFT JOIN emanagement.permohonan_bilik b
        ON p.id_pemohon=b.id_pemohon
        AND b.id_permohonan_bilik = (SELECT MAX(m1.id_permohonan_bilik) FROM emanagement.permohonan_bilik m1 WHERE m1.id_pemohon = p.id_pemohon)
        where b.id_bilik=23 and p.bahagian=c.bahagian) as BilikBincang2A10

        from personel.bahagian c
        where c.agensi_id in (1,4)
        ORDER BY `c`.`singkatan` ASC');

        return view('homeBilikMeet', compact('countPermohonan','countKaterers','countPermohonanBaru','countPermohonanLulus','countPermohonanGagal','countBulan','countTujuan', 'biliks'));
    }

    public function clock(){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $data = date('d M Y H:i:s');
        // $data = Carbon\Carbon::now();

        return response()->json($data);
    }

    public function piechart ()
    {
        $countTujuan = DB::select('SELECT count(p.id_tujuan) as bil, t.tujuan
        FROM permohonan_kenderaan p, lkp_tujuan t
        where p.id_tujuan = t.id_tujuan
        group by(t.tujuan)');

        $data = array();
        foreach ($countTujuan as $row) {
            $data[] = $row;
        }

      return response()->json($data);
    }


}
