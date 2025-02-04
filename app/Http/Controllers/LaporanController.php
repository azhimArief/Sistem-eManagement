<?php

namespace App\Http\Controllers;
use App\LkpJenisKenderaan;
use App\LkpModel;
use App\LkpPemandu;
use App\LkpJenisPerjalanan;
use App\LkpTujuan;
use App\LkpStatus;
use App\PermohonanKenderaan;
use App\Pemohon;
use App\Kenderaan;
use App\Tindakan;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use App\LkpAccess;
use App\Penumpang;
use App\RLkpNegeri;
Use DB;
use Illuminate\Http\Request;
use Carbon;
use Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function laporanKeseluruhan(Request $request)
     {
      $bil = 1;
      $search = ['tujuan'=>'', 'jenis_perjalanan'=>'','status'=>'','tkh_dari'=>'', 'tkh_hingga'=>'' ];
      $tes = DB::select('SELECT p.id_maklumat_permohonan, p.id_pemohon,p.kod_permohonan,p.id_jenis_perjalanan, p.tkh_pergi, p.tkh_balik, p.id_tujuan,o.nama,p.lokasi_tujuan,
      p.id_status
      FROM permohonan_kenderaan p, pemohon o
      WHERE p.id_pemohon = o.id_pemohon 
      -- AND p.id_status IN (1,2,3,4,11)
      order by p.id_maklumat_permohonan');

      $permohonanKenderaans = collect($tes);
                    // dd( $programs);
                    
      $optStatus = LkpStatus::whereIn('id_status',['1','3','4','6','11'])->get();	
      $optTujuans = LkpTujuan::get();
      $optJenisPerjalanans = LkpJenisPerjalanan::get();
      //$optJenisOrgs = LkpJenisOrg::get();
     
        if(isset($_POST['search_laporan']))
       {
         $data = $request->input();
         
      //  dd($data);
         if(strlen($data['status']) > 0) { 
          if($data['status']==1){
            $permohonanKenderaans = $permohonanKenderaans->whereIn('id_status',[1,2]); $search['status']=$data['status'];
          }else{

            $permohonanKenderaans = $permohonanKenderaans->where('id_status',$data['status']); $search['status']=$data['status']; 
          }
        }
         if(strlen($data['id_tujuan']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('id_tujuan',$data['id_tujuan']); $search['tujuan']=$data['id_tujuan']; }
         if(strlen($data['id_jenis_perjalanan']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('id_jenis_perjalanan',$data['id_jenis_perjalanan']); $search['jenis_perjalanan']=$data['id_jenis_perjalanan']; }
         if(strlen($data['tkh_dari']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('tkh_pergi','>=', $data['tkh_dari']); $search['tkh_dari']=$data['tkh_dari']; }
         if(strlen($data['tkh_hingga']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('tkh_pergi','<=', $data['tkh_hingga']); $search['tkh_hingga']=$data['tkh_hingga']; }
        //  dd( $programs);
       }
       return view('laporan.keseluruhan',compact('optTujuans','optStatus','optJenisPerjalanans','search','bil','permohonanKenderaans'));

    }

    public function laporanPemandu(Request $request)
    {
     $bil = 1;
     $search = ['mykad'=>'','tkh_dari'=>'', 'tkh_hingga'=>'', 'no_kenderaan'=>'' ];
     $optPemandus = LkpPemandu::get();	
     $optKenderaans = Kenderaan::get();

      //  $pemandu = DB::select('SELECT pk.kod_permohonan,pk.id_maklumat_permohonan, pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi, pk.masa_balik, pk.id_tujuan, pk.lokasi_tujuan,t.kenderaan_pergi, t.kenderaan_balik, k.id_kenderaan, k.pemandu
      //                       from permohonan_kenderaan pk
      //                       join tindakan t on pk.id_maklumat_permohonan=t.id_permohonan
      //                       and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = pk.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
      //                       left join kenderaan k on (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
      //                     --   where t.id_status_tempah in (3,11)
      //                     join lkp_pemandu dr on k.pemandu = dr.mykad
      //                       order by pk.tkh_pergi desc');

            $pemandu = PermohonanKenderaan::select(
                'permohonan_kenderaan.kod_permohonan',
                'permohonan_kenderaan.id_maklumat_permohonan',
                'permohonan_kenderaan.tkh_pergi',
                'permohonan_kenderaan.tkh_balik',
                'permohonan_kenderaan.masa_pergi',
                'permohonan_kenderaan.masa_balik',
                'permohonan_kenderaan.id_tujuan',
                'permohonan_kenderaan.lokasi_tujuan',
                'tindakan.kenderaan_pergi',
                'tindakan.kenderaan_balik',
                'kenderaan.id_kenderaan',
                'kenderaan.pemandu'
                // 'penumpang.nama'  // Ambik nama penumpang
            )
            ->join('tindakan', function($join) {
                $join->on('permohonan_kenderaan.id_maklumat_permohonan', '=', 'tindakan.id_permohonan')
                    ->whereRaw('tindakan.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = tindakan.id_permohonan AND t1.id_status_tempah IN (3, 11))');
            })
            ->leftJoin('kenderaan', function($join) {
                $join->on('kenderaan.id_kenderaan', '=', 'tindakan.kenderaan_pergi')
                    ->orOn('kenderaan.id_kenderaan', '=', 'tindakan.kenderaan_balik');
            })
            ->join('lkp_pemandu', 'kenderaan.pemandu', '=', 'lkp_pemandu.mykad')
            // ->leftJoin('penumpang', 'penumpang.id_tempahan', '=', 'permohonan_kenderaan.id_maklumat_permohonan') // Join with penumpang
            ->orderBy('permohonan_kenderaan.tkh_pergi', 'desc')
            ->get();

            $penumpangs = Penumpang::get();
    
      $pemanduKenderaans = collect($pemandu);
        // $pemanduKenderaans = PermohonanKenderaan::join('tindakan','permohonan_kenderaan.id_maklumat_permohonan','=','tindakan.id_permohonan')
        //                                           ->leftjoin('kenderaan', function ($join) {
        //                                                 $join->on('kenderaan.id_kenderaan', '=', 'tindakan.kenderaan_pergi')
        //                                                       ->orOn('kenderaan.id_kenderaan', '=', 'tindakan.kenderaan_balik');
        //                                           })
        //                                           ->whereIn('tindakan.id_status_tempah',[3,11])
        //                                           ->groupBy(['permohonan_kenderaan.id_maklumat_permohonan','tindakan.id_permohonan','kenderaan.pemandu'])
        //                                           ->orderBy('permohonan_kenderaan.tkh_pergi','desc')
        //                                           ->get();

    
      // dd( $pemanduKenderaans);
      if(isset($_POST['search_laporan']))
      {
        $data = $request->input();
        
      
        if(strlen($data['mykad']) > 0) { $pemanduKenderaans = $pemanduKenderaans->where('pemandu',$data['mykad']); $search['mykad']=$data['mykad']; }
        if(strlen($data['no_kenderaan']) > 0) { $pemanduKenderaans = $pemanduKenderaans->where('id_kenderaan',$data['no_kenderaan']); $search['no_kenderaan']=$data['no_kenderaan']; }
        if(strlen($data['tkh_dari']) > 0) { $pemanduKenderaans = $pemanduKenderaans->where('tkh_pergi','>=', $data['tkh_dari']); $search['tkh_dari']=$data['tkh_dari']; }
        if(strlen($data['tkh_hingga']) > 0) { $pemanduKenderaans = $pemanduKenderaans->where('tkh_pergi','<=', $data['tkh_hingga']); $search['tkh_hingga']=$data['tkh_hingga']; }
       //  dd( $programs);
      }
      //  dd($pemanduKenderaans);  
      //  return $pemanduKenderaans;  

      return view('laporan.pemandu',compact('optPemandus','search','bil','pemanduKenderaans', 'optKenderaans', 'penumpangs'));

   }

    public function penilaian(Request $request)
    {
     $bil = 1;
     $search = ['mykad'=>''];
     $optPemandus = LkpPemandu::get();	

      //  $ratings = DB::select('select avg(n.skala1) as s1, avg(n.skala2) as s2,avg(n.skala3) as s3, avg(n.skala4) as s4, avg(n.skala5) as s5, k.pemandu
      //                       from penilaian n, tindakan t, kenderaan k
      //                       WHERE n.id_maklumat_permohonan=t.id_permohonan 
      //                       and t.kenderaan_pergi=k.id_kenderaan
      //                       and t.id_status_tempah in (3,11) 
      //                       and mykad_penumpang is not null 
      //                       group by k.pemandu');

      // $ratings = DB::select('select avg(n.skala1) as s1, avg(n.skala2) as s2,avg(n.skala3) as s3, avg(n.skala4) as s4, avg(n.skala5) as s5, k.pemandu
      //                       from penilaian n
      //                       join tindakan t on n.id_maklumat_permohonan=t.id_permohonan
      //                       and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = n.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
      //                       left join kenderaan k on (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
      //                       and mykad_penumpang is not null 
      //                       group by k.pemandu');

        $ratings = DB::select('select avg(n.skala1) as s1, avg(n.skala2) as s2,avg(n.skala3) as s3, avg(n.skala4) as s4, avg(n.skala5) as s5, k.pemandu
                          from penilaian n
                          join tindakan t on n.id_maklumat_permohonan=t.id_permohonan
                          and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = n.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
                          left join kenderaan k on (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
                          and mykad_penumpang is not null 
                          join lkp_pemandu dr on k.pemandu = dr.mykad
                          group by k.pemandu');

      //  $penilaians = collect($ratings);
                  //  dd( $ratings); 
    
     
      return view('laporan.penilaian',compact('optPemandus','search','bil','ratings'));

   }

    public function ulasanPemandu(Request $request)
    {
     $bil = 1;
      //  $search = ['mykad'=>'', 'id_tempahan'=>''];
      $search = ['mykad'=>'', 'id_tempahan'=>'', 'tkh_dari'=>'' , 'tkh_hingga'=>''];
      $optPemandus = LkpPemandu::get();	

      // $catatans = DB::select('SELECT pk.kod_permohonan,pk.id_maklumat_permohonan, pk.tkh_pergi, pk.id_tujuan, pk.id_pemohon, t.kenderaan_pergi, t.kenderaan_balik, k.id_kenderaan, k.pemandu, n.komen_pemandu
      //           from permohonan_kenderaan pk, tindakan t, kenderaan k, penilaian n
      //           where pk.id_maklumat_permohonan=t.id_permohonan
      //           and n.id_maklumat_permohonan = pk.id_maklumat_permohonan
      //           and (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
      //           and t.id_status_tempah=11
      //           and n.mykad_pemandu is not null');

      // $catatans = DB::select('SELECT pk.kod_permohonan,pk.id_maklumat_permohonan, pk.tkh_pergi, pk.id_tujuan, pk.id_pemohon, t.kenderaan_pergi, t.kenderaan_balik, k.id_kenderaan, k.pemandu, n.komen_pemandu, n.id_penilaian
      //           from permohonan_kenderaan pk
      //           join tindakan t on pk.id_maklumat_permohonan=t.id_permohonan
      //                     and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = pk.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
      //           left join kenderaan k on (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
      //           left join penilaian n on  (n.id_maklumat_permohonan = pk.id_maklumat_permohonan and n.mykad_pemandu=k.pemandu)
      //           where n.mykad_pemandu is not null');

      $subquery = Tindakan::select(DB::raw('MAX(id_tindakan) as max_id_tindakan'))
            ->whereColumn('id_permohonan', 'permohonan_kenderaan.id_maklumat_permohonan')
            ->whereIn('id_status_tempah', [3, 11])
            ->groupBy('id_permohonan');

        $catatans = PermohonanKenderaan::select(
                'permohonan_kenderaan.kod_permohonan',
                'permohonan_kenderaan.id_maklumat_permohonan',
                'permohonan_kenderaan.tkh_pergi',
                'permohonan_kenderaan.tkh_balik',
                'permohonan_kenderaan.id_tujuan',
                'permohonan_kenderaan.id_pemohon',
                'tindakan.kenderaan_pergi',
                'tindakan.kenderaan_balik',
                'kenderaan.id_kenderaan',
                'kenderaan.pemandu',
                'penilaian.komen_pemandu',
                'penilaian.ulasan',
                'penilaian.id_penilaian'
            )
            ->join('tindakan', function ($join) use ($subquery) {
                $join->on('permohonan_kenderaan.id_maklumat_permohonan', '=', 'tindakan.id_permohonan')
                    ->whereIn('tindakan.id_tindakan', $subquery);
            })
            ->leftJoin('kenderaan', function ($join) {
                $join->on('kenderaan.id_kenderaan', '=', 'tindakan.kenderaan_pergi')
                    ->orOn('kenderaan.id_kenderaan', '=', 'tindakan.kenderaan_balik');
            })
            ->leftJoin('penilaian', function ($join) {
                $join->on('penilaian.id_maklumat_permohonan', '=', 'permohonan_kenderaan.id_maklumat_permohonan');
                    // ->whereColumn('penilaian.mykad_pemandu', '=', 'kenderaan.pemandu');
            })
            // ->whereNotNull('penilaian.mykad_pemandu')
            ->orderBy('permohonan_kenderaan.tkh_pergi')
            ->get();

                  //  dd( $catatans);
     $komens = collect($catatans);
                   // dd( $programs);
    
      if(isset($_POST['search_laporan']))
      {
        $data = $request->input();
        
      
        if(strlen($data['mykad']) > 0) { $komens = $komens->where('pemandu',$data['mykad']); $search['mykad']=$data['mykad']; }
        if(strlen($data['id_tempahan']) > 0) { $komens = $komens->where('kod_permohonan', $data['id_tempahan']); $search['id_tempahan']=$data['id_tempahan']; }
        if(strlen($data['tkh_dari']) > 0) { $komens = $komens->where('tkh_pergi','>=', $data['tkh_dari']); $search['tkh_dari']=$data['tkh_dari']; }
        if(strlen($data['tkh_hingga']) > 0) { $komens = $komens->where('tkh_pergi','<=', $data['tkh_hingga']); $search['tkh_hingga']=$data['tkh_hingga']; }
        // if(strlen($data['id_tempahan']) > 0) { $komens = $komens->where('kod_permohonan', 'like', '%'. $data['id_tempahan'] .'%'); $search['id_tempahan']=$data['id_tempahan']; }
      //  if(strlen($data['id_jenis_perjalanan']) > 0) { $pemanduKenderaans = $pemanduKenderaans->where('id_jenis_perjalanan',$data['id_jenis_perjalanan']); $search['jenis_perjalanan']=$data['id_jenis_perjalanan']; }
       //  dd( $programs);
      }
      return view('laporan.ulasanpemandu',compact('optPemandus','search','bil','komens'));

   }


}
