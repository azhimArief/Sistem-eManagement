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
use App\LkpBilik;
use App\LkpKaterer;
use App\Penumpang;
use App\PermohonanBilik;
use App\RLkpNegeri;
Use DB;
use Illuminate\Http\Request;
use Carbon;
use Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class LaporanBilikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function laporanKeseluruhan(Request $request)
     {
        $bil = 1;
        $search = ['tujuan'=>'','status'=>'','tkh_mula'=>'','tkh_hingga'=>'' ];

        $permohonanBiliks = PermohonanBilik::join('pemohon', 'pemohon.id_pemohon', '=', 'permohonan_bilik.id_pemohon')
                                            ->join('tempah_makan', 'tempah_makan.id_permohonan_bilik', '=', 'permohonan_bilik.id_permohonan_bilik')                                    
                                            ->get();
                      
        $optStatus = LkpStatus::whereIn('id_status',['1','3','4','6','11'])->get();	
        $optTujuans = LkpTujuan::where('id_tujuan', '!=', '6') 
                                ->where('id_tujuan', '!=', '7')			
                                ->get();
        $optKaterer = LkpKaterer::get();
        $optBilik = LkpBilik::get();
        $personels = PPersonel::get();
     
        if(isset($_POST['search_laporan'])){
         $data = $request->input();
         
         if(strlen($data['status']) > 0) { 

              if($data['status']==1){
                  $permohonanBiliks = $permohonanBiliks->whereIn('id_status',[1,2]);
                  $search['status']=$data['status'] ;
              } else{
                  $permohonanBiliks = $permohonanBiliks->where('id_status',$data['status']);
                  $search['status']=$data['status'] ;
              }
          }
          if(strlen($data['id_tujuan']) > 0) {  $permohonanBiliks = $permohonanBiliks->where('id_tujuan',$data['id_tujuan']); $search['tujuan']=$data['id_tujuan'] ;  }
          if(strlen($data['tkh_mula']) > 0) {  $permohonanBiliks = $permohonanBiliks->where('tkh_mula', '>=',$data['tkh_mula']); $search['tkh_mula']=$data['tkh_mula'] ;  }
          if(strlen($data['tkh_hingga']) > 0) {  $permohonanBiliks = $permohonanBiliks->where('tkh_hingga', '<=',$data['tkh_hingga']); $search['tkh_hingga']=$data['tkh_hingga'] ;  }
        }
       return view('laporanbilik.keseluruhan_Bilik',compact('optTujuans','optStatus','search','bil', 'optKaterer', 'optBilik', 'permohonanBiliks', 'personels'));
    }

    public function laporanKaterer(Request $request)
    {
     $bil = 1;
     $search = ['katerer'=>'','tkh_mula'=>'', 'tkh_hingga'=>'' ];
     $katerers = LkpKaterer::get();
     $permohonanBiliks = PermohonanBilik::join('pemohon', 'pemohon.id_pemohon', '=', 'permohonan_bilik.id_pemohon')
                                          ->join('tempah_makan', 'tempah_makan.id_permohonan_bilik', '=', 'permohonan_bilik.id_permohonan_bilik')  
                                          ->where('pembekal', '!=', null)                                  
                                          ->get();

      if(isset($_POST['search_laporan'])) {
        $data = $request->input();
           
        if(strlen($data['katerer']) > 0) {
          $permohonanBiliks = $permohonanBiliks->where('pembekal',$data['katerer']); 
          $search['katerer']=$data['katerer'] ;
        }
        if(strlen($data['tkh_mula']) > 0) {
          $permohonanBiliks = $permohonanBiliks->where('tkh_mula', '>=',$data['tkh_mula']); 
          $search['tkh_mula']=$data['tkh_mula'] ;
        }
        if(strlen($data['tkh_hingga']) > 0) { 
          $permohonanBiliks = $permohonanBiliks->where('tkh_hingga', '<=',$data['tkh_hingga']); 
          $search['tkh_hingga']=$data['tkh_hingga'] ;
        }
      }
      return view('laporanbilik.katerer',compact('search','bil', 'katerers', 'permohonanBiliks'));

    }

   public function laporanKatererBulanan(Request $request)
    {
      $bil = 1;
      // $search = ['katerer'=>'','tkh_mula'=>'', 'tkh_hingga'=>'', 'bulan'=>'' ];
      $search = ['katerer'=>'', 'bulan'=>'', 'bahagian'=>'' ];
      $namaKaterer = null;
      $namaBahagian = null;
      $monthName = null;
      $katerers = LkpKaterer::get();
      $bahagians = PLkpBahagian::where('status_bahagian', 1)->get();
      $permohonanBiliks = PermohonanBilik::join('pemohon', 'pemohon.id_pemohon', '=', 'permohonan_bilik.id_pemohon')
                                            ->join('tempah_makan', 'tempah_makan.id_permohonan_bilik', '=', 'permohonan_bilik.id_permohonan_bilik')  
                                            ->where('pembekal', '!=', null)                                  
                                            ->where('tempah_makan', 1)                                    
                                            ->where('id_status', 3)                                    
                                            ->orderBy('tkh_mula', 'asc') 
                                            ->get();
      // dd($permohonanBiliks);
      // return $permohonanBiliks;

        if(isset($_POST['search_laporan'])) {
          $data = $request->input();
            
          if(strlen($data['katerer']) > 0) {
              $permohonanBiliks = $permohonanBiliks->where('pembekal',$data['katerer']); 
              $namaKaterer = optional(\App\LkpKaterer::find($data['katerer']))->nama_katerer;
              $search['katerer']=$data['katerer'] ;
          }
          if(strlen($data['bulan']) > 0) {
              $year = date('Y', strtotime($data['bulan']));
              $month = date('m', strtotime($data['bulan']));

              // Map the month number to the Malay month name
              $monthNames = [
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MAC',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUN',
                '07' => 'JULAI',
                '08' => 'OGOS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DISEMBER',
              ];

              // Assign the corresponding month name
              $monthName = $monthNames[$month];
              
              $permohonanBiliks = $permohonanBiliks->filter(function ($item) use ($year, $month) {
                  return date('Y', strtotime($item->tkh_mula)) == $year && date('m', strtotime($item->tkh_mula)) == $month;
              });
              
              $search['bulan']=$data['bulan'] ;
          }
          if(strlen($data['bahagian']) > 0) {
              $idBahagian = optional(\App\PLkpBahagian::where('bahagian', $data['bahagian'])->first())->id;
              // $permohonanBiliks = $permohonanBiliks->where('bahagian',$data['bahagian']); 

              // Filter $permohonanBiliks based on id_bahagian or bahagian
              $permohonanBiliks = $permohonanBiliks->filter(function ($item) use ($idBahagian, $data) {
                  // If id_bahagian is present, check if it matches $idBahagian
                  if ($item->id_bahagian) {
                      return $item->id_bahagian == $idBahagian;
                  }
                  // If id_bahagian is null, fall back to checking bahagian
                  return $item->bahagian == $data['bahagian'];
              });
              // $permohonanBiliks = $permohonanBiliks->where('id_bahagian',$idBahagian); 

              $namaBahagian = optional(\App\PLkpBahagian::where('bahagian', $data['bahagian'])->first())->bahagian;
              $search['bahagian']=$data['bahagian'] ;
          }
          // return $permohonanBiliks;
        }
        return view('laporanbilik.katerer_bulanan',compact('search','bil', 'katerers', 'permohonanBiliks', 'namaKaterer', 'monthName', 'bahagians', 'namaBahagian'));
    }

    public function penilaian(Request $request)
    {
     $bil = 1;
     $search = ['mykad'=>''];
     $optPemandus = LkpPemandu::get();	
     $optJenisPerjalanans = LkpJenisPerjalanan::get();

    //  $ratings = DB::select('select avg(n.skala1) as s1, avg(n.skala2) as s2,avg(n.skala3) as s3, avg(n.skala4) as s4, avg(n.skala5) as s5, k.pemandu
    //                       from penilaian n, tindakan t, kenderaan k
    //                       WHERE n.id_maklumat_permohonan=t.id_permohonan 
    //                       and t.kenderaan_pergi=k.id_kenderaan
    //                       and t.id_status_tempah in (3,11) 
    //                       and mykad_penumpang is not null 
    //                       group by k.pemandu');

    $ratings = DB::select('select avg(n.skala1) as s1, avg(n.skala2) as s2,avg(n.skala3) as s3, avg(n.skala4) as s4, avg(n.skala5) as s5, k.pemandu
                          from penilaian n
                          join tindakan t on n.id_maklumat_permohonan=t.id_permohonan
                          and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = n.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
                          left join kenderaan k on (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
                          and mykad_penumpang is not null 
                          group by k.pemandu');

      $penilaians = collect($ratings);
                  //  dd( $ratings);
    
     
      return view('laporan.penilaian',compact('optPemandus','penilaians','search','bil','ratings'));

   }

    public function ulasanPemandu(Request $request)
    {
     $bil = 1;
     $search = ['mykad'=>'', 'id_tempahan'=>''];
     $optPemandus = LkpPemandu::get();	
     $optJenisPerjalanans = LkpJenisPerjalanan::get();

      $catatans = DB::select('SELECT pk.kod_permohonan,pk.id_maklumat_permohonan, pk.tkh_pergi, pk.id_tujuan, pk.id_pemohon, t.kenderaan_pergi, t.kenderaan_balik, k.id_kenderaan, k.pemandu, n.komen_pemandu
                from permohonan_kenderaan pk, tindakan t, kenderaan k, penilaian n
                where pk.id_maklumat_permohonan=t.id_permohonan
                and n.id_maklumat_permohonan = pk.id_maklumat_permohonan
                and (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
                and t.id_status_tempah=11
                and n.mykad_pemandu is not null');

      $catatans = DB::select('SELECT pk.kod_permohonan,pk.id_maklumat_permohonan, pk.tkh_pergi, pk.id_tujuan, pk.id_pemohon, t.kenderaan_pergi, t.kenderaan_balik, k.id_kenderaan, k.pemandu, n.komen_pemandu
                from permohonan_kenderaan pk
                join tindakan t on pk.id_maklumat_permohonan=t.id_permohonan
                          and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = pk.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
                left join kenderaan k on (k.id_kenderaan=t.kenderaan_pergi OR k.id_kenderaan = t.kenderaan_balik)
                left join penilaian n on  n.id_maklumat_permohonan = pk.id_maklumat_permohonan
                where n.mykad_pemandu is not null');

     $komens = collect($catatans);
                   // dd( $programs);
    
      if(isset($_POST['search_laporan']))
      {
        $data = $request->input();
        
      
        if(strlen($data['mykad']) > 0) { $komens = $komens->where('pemandu',$data['mykad']); $search['mykad']=$data['mykad']; }
        if(strlen($data['id_tempahan']) > 0) { $komens = $komens->where('kod_permohonan', $data['id_tempahan']); $search['id_tempahan']=$data['id_tempahan']; }
        // if(strlen($data['id_tempahan']) > 0) { $komens = $komens->where('kod_permohonan', 'like', '%'. $data['id_tempahan'] .'%'); $search['id_tempahan']=$data['id_tempahan']; }
      //  if(strlen($data['id_jenis_perjalanan']) > 0) { $pemanduKenderaans = $pemanduKenderaans->where('id_jenis_perjalanan',$data['id_jenis_perjalanan']); $search['jenis_perjalanan']=$data['id_jenis_perjalanan']; }
       //  dd( $programs);
      }
      return view('laporan.ulasanpemandu',compact('optPemandus','optJenisPerjalanans','search','bil','komens'));

   }


}
