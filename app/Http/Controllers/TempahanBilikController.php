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
use App\Penumpang;
use App\RLkpNegeri;
use App\User;
use Illuminate\Http\Request;
use Carbon;
use DB;
use PDF;
use Auth;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\LkpJawatankuasaRisi;
use App\LkpJenisHidangan;
use App\LkpKaterer;
use App\MenuMakan;
use App\PermohonanBilik;
use App\TempahMakan;
use Carbon\Carbon as CarbonCarbon;
use DateTime;

class TempahanBilikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$optTujuan = LkpTujuan::where('id_tujuan', '!=', '6') 
								->where('id_tujuan', '!=', '7')			
								->get();
		$optStatus = LkpStatus::whereIn('id_status',['1','2','3','4'])->get();	
		
		// if(Auth::User()->id_access == 2){
		// 	$nama = Auth::User()->nama;
		// 	$Srhfield = ['kod_permohonan'=>'','tujuan'=>'', 'status'=>'', 'tkh_mula'=>'', 'tkh_hingga'=>'' ];

		// 	//bilik info
		// 	$permohonanBiliks = PermohonanBilik ::join('pemohon', 'permohonan_bilik.id_pemohon', '=', 'pemohon.id_pemohon')
		// 											->where('pemohon.nama','LIKE', "%{$nama}%")
		// 											->orderBy('permohonan_bilik.created_at','desc')
		// 											->get();
		// }else{

			$permohonanBiliks = PermohonanBilik::orderBy('created_at','desc')->get();

			$Srhfield = ['kod_permohonan'=>'','tujuan'=>'', 'status'=>'', 'tkh_mula'=>'', 'tkh_hingga'=>'' ];

			if(isset($_POST['tapis']))
			{
					 
			  $data = $request->input();
	
			 if(strlen($data['kod_permohonan']) > 0) { $permohonanBiliks = $permohonanBiliks->where('kod_permohonan', $data['kod_permohonan']); $Srhfield['kod_permohonan']=$data['kod_permohonan']; }
			//  if(strlen($data['created_by']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('created_by',$data['created_by']); $Srhfield['created_by']=$data['created_by'];}
			 if(strlen($data['tujuan']) > 0) { $permohonanBiliks = $permohonanBiliks->where('id_tujuan',$data['tujuan']); $Srhfield['tujuan']=$data['tujuan'];}
			 if(strlen($data['status']) > 0) { $permohonanBiliks = $permohonanBiliks->where('id_status',$data['status']); $Srhfield['status']=$data['status']; }
			 if(strlen($data['tkh_mula']) > 0) { $permohonanBiliks = $permohonanBiliks->where('created_at','>=',$data['tkh_mula'].' 00:00:00'); $Srhfield['tkh_mula']=$data['tkh_mula']; }
			 if(strlen($data['tkh_hingga']) > 0) { $permohonanBiliks = $permohonanBiliks->where('created_at','<=', $data['tkh_hingga'].' 23:59:59'); $Srhfield['tkh_hingga']=$data['tkh_hingga']; }
			  }
		// }

		
        return view('tempahanbilik.senarai',compact('permohonanBiliks','optTujuan','Srhfield','optStatus'));
    }

	public function cariBilik (Request $request) {
		$aras = $request->input('aras');
     	$data = LkpBilik::where('aras',$aras)
                          ->orderBy('id_bilik')
                          ->get();

      	return response()->json($data);

	}
	public function jadual(Request $request) //function jadual admin page
	{
		$data = $request->input();

		//calendar
		$calendar = array();
		//$events = PermohonanBilik::where('id_pemohon', $pemohon->id_pemohon)->get();
		$events = PermohonanBilik ::get();

		if(isset($_POST["tapis"])) { //if tapis

			$request->session()->flash('tapis', "tidak perlu display tatacara");

			foreach ($events as $event) {
				$tarikh_mula = Carbon\Carbon::parse($event->tkh_mula)->format('Y-m-d');
				$masa_mula = Carbon\Carbon::parse($event->masa_mula)->format('H:i');
				$start = $tarikh_mula . " " . $masa_mula;
				$tarikh_tamat = Carbon\Carbon::parse($event->tkh_hingga)->format('Y-m-d');
				$masa_tamat = Carbon\Carbon::parse($event->masa_hingga)->format('H:i');
				$end = $tarikh_tamat . " " . $masa_tamat;
				$title = $masa_mula . ' - ' . $masa_tamat; //if nak display masa kat kalendar
				$bilik = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
									->where('id_bilik',$event->id_bilik)
									->first();
				if( $bilik == null) {
					$bilikNama = null;
					$bilikBahagian = null;
					$bilikAras = null;
				}
				else {
					$bilikNama = $bilik->bilik;
					$bilikBahagian = $bilik->bahagian;
					$bilikAras = $bilik->aras;
				}
				//UBAH CARI PERSONEL
				$cariUser = Pemohon::where('id_pemohon', $event->id_pemohon)->first();
				$user = PPersonel::where('nokp', $cariUser->mykad)->first();

				$status = LkpStatus::where('id_status', $event->id_status)->first();
				$color = null; 
					//if for color kat calendar
					if($status->id_status == 3){
						$color = '#007E33'; //hijau
					}
					elseif($status->id_status == 1){
						$color = '#4285F4'; //biru
					}
					elseif($status->id_status == 2){ //dalam proses
						$color = '#DC4C64'; //merah 
					}
					elseif($status->id_status == 5){ //semak semula
						$color = '#DC4C64'; //merah 
					}
					else{
						$color = '000000'; //black
					}

				
				if( isset($data['cariAras']) && isset($data['cariBilik']) ) { //if tapis kalendar jika aras & bilik 
					//if jika batal x yah display & tuk cari bilik & aras filter
					if ($data['cariAras'] == $bilikAras && $data['cariBilik'] == $bilik->id_bilik && $status->id_status != 6 && $status->id_status != 4) {
						$calendar[] = [
							'id' => $event->id_permohonan_bilik,
							'id_tempahan' => $event->kod_permohonan,
							//'title' => $event->nama_tujuan,                           
							'title' => $title,                           
							'start' => $start,
							'end' => $end,
							'start_date' => $tarikh_mula,
							'start_time' => $masa_mula,
							'end_date' => $tarikh_tamat,
							'end_time' => $masa_tamat,
							'pemohon' => optional($user)->name ?? '-', // Handle if $user is null
							// 'pemohon' => $user->nama, 
							'pemohon_id' => optional($user)->nokp ?? '-', // Handle if $user is null
							// 'pemohon_id' => $user->mykad,
							'bahagian' => optional(\App\PLkpBahagian::find(optional($user)->bahagian_id))->bahagian ?? '-', // Handle null $user and null bahagian
							// 'bahagian' => $user->bahagian,
							// 'namabilik' => $bilik->bilik,
							'namabilik' => $bilikNama,
							// 'bahagianbilik' => $bilik->bahagian,
							'bahagianbilik' => $bilikBahagian,
							// 'arasbilik' => $bilik->aras,
							'arasbilik' => $bilikAras,
							'status' => $status->status,
							'color' => $color,
						];
					}
				}
				else if (isset($data['cariAras'])) { //if tapis kalendar jika aras sahaja
					//if jika batal x yah display & tuk cari aras filter
					if ($data['cariAras'] == $bilikAras && $status->id_status != 6 && $status->id_status != 4) {
						$calendar[] = [
							'id' => $event->id_permohonan_bilik,
							'id_tempahan' => $event->kod_permohonan,
							'title' => $event->nama_tujuan,
							'title' => $title,
							'start' => $start,
							'end' => $end,
							'start_date' => $tarikh_mula,
							'start_time' => $masa_mula,
							'end_date' => $tarikh_tamat,
							'end_time' => $masa_tamat,
							'pemohon' => optional($user)->name ?? '-', // Handle if $user is null
							// 'pemohon' => $user->nama, 
							'pemohon_id' => optional($user)->nokp ?? '-', // Handle if $user is null
							// 'pemohon_id' => $user->mykad,
							'bahagian' => optional(\App\PLkpBahagian::find(optional($user)->bahagian_id))->bahagian ?? '-', // Handle null $user and null bahagian
							// 'bahagian' => $user->bahagian,
							// 'namabilik' => $bilik->bilik,
							'namabilik' => $bilikNama,
							// 'bahagianbilik' => $bilik->bahagian,
							'bahagianbilik' => $bilikBahagian,
							// 'arasbilik' => $bilik->aras,
							'arasbilik' => $bilikAras,
							'status' => $status->status,
							'color' => $color,
						];
					}
				}
				
			}

		}
		else { //if tak ditapis

			foreach ($events as $event) {
				$tarikh_mula = Carbon\Carbon::parse($event->tkh_mula)->format('Y-m-d');
				$masa_mula = Carbon\Carbon::parse($event->masa_mula)->format('H:i');
				$start = $tarikh_mula . " " . $masa_mula;
				$tarikh_tamat = Carbon\Carbon::parse($event->tkh_hingga)->format('Y-m-d');
				$masa_tamat = Carbon\Carbon::parse($event->masa_hingga)->format('H:i');
				$end = $tarikh_tamat . " " . $masa_tamat;
				$title = $masa_mula . ' - ' . $masa_tamat; //if nak display masa kat kalendar
				$bilik = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
									->where('id_bilik',$event->id_bilik)
									->first();
				if( $bilik == null) {
					$bilikNama = null;
					$bilikBahagian = null;
					$bilikAras = null;
				}
				else {
					$bilikNama = $bilik->bilik;
					$bilikBahagian = $bilik->bahagian;
					$bilikAras = $bilik->aras;
				}
				//UBAH CARI PERSONEL
				$cariUser = Pemohon::where('id_pemohon', $event->id_pemohon)->first();
				$user = PPersonel::where('nokp', $cariUser->mykad)->first();

				$status = LkpStatus::where('id_status', $event->id_status)->first();
				$color = null; 
				//if for color kat calendar
				if($status->id_status == 3){ //lulus
					$color = '#007E33'; //hijau
				}
				elseif($status->id_status == 1){ //baru
					$color = '#4285F4'; //biru
				}
				elseif($status->id_status == 2){ //dalam proses
					$color = '#DC4C64'; //merah 
				}
				elseif($status->id_status == 5){ //semak semula
					$color = '#DC4C64'; //merah 
				}
				else{
					$color = '000000'; //black
				}
				//if jika batal x yah display
				if ($status->id_status != 6 && $status->id_status != 4){
					$calendar[] = [
						'id' => $event->id_permohonan_bilik,
						'id_tempahan' => $event->kod_permohonan,
						//'title' => $event->nama_tujuan, if nak tunjuk nama mesyuarat
						'title' => $title, //if nk display masa je 
						'start' => $start,
						'end' => $end,
						'start_date' => $tarikh_mula,
						'start_time' => $masa_mula,
						'end_date' => $tarikh_tamat,
						'end_time' => $masa_tamat,
						'pemohon' => optional($user)->name ?? '-', // Handle if $user is null
						// 'pemohon' => $user->nama, 
						'pemohon_id' => optional($user)->nokp ?? '-', // Handle if $user is null
						// 'pemohon_id' => $user->mykad,
						'bahagian' => optional(\App\PLkpBahagian::find(optional($user)->bahagian_id))->bahagian ?? '-', // Handle null $user and null bahagian
						// 'bahagian' => $user->bahagian,
						// 'namabilik' => $bilik->bilik,
						'namabilik' => $bilikNama,
						// 'bahagianbilik' => $bilik->bahagian,
						'bahagianbilik' => $bilikBahagian,
						// 'arasbilik' => $bilik->aras,
						'arasbilik' => $bilikAras,
						'status' => $status->status,
						'color' => $color,
					];
				}	
			}

		}
		

		//   dd($result);
		$optJenisPerjalanans = LkpJenisPerjalanan::get();
		$optTujuans = LkpTujuan::where('id_tujuan', '!=', '6') 
								->where('id_tujuan', '!=', '7')			
								->get();
		$optBahagians = PLkpBahagian::orderBy('bahagian')->get();
		$optNegeris = RLkpNegeri::orderBy('negeri')->get();
		//$optBiliks = LkpBilik::orderBy('id_bilik', 'asc')->get();
		$optBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
				->get();

		if ($request->input() != null ) {
			session()->flashInput($request->input());
		}
		
		return view('tempahanbilik.jadual', compact( 'calendar', 'optBiliks'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		
		$result = PPersonel::where('nokp', Auth::user()->mykad)->first();
		$personels = PPersonel::get();
		$pemohon = Pemohon:: where('mykad', Auth::user()->mykad)->first();
		$pengerusi = PPersonel:: where('gred', 'LIKE', '%' . "41" . '%')
								->where('stat_pegawai', '!=', 0)
								->orWhere('gred', 'LIKE', '%' . "44" . '%')
								->orWhere('gred', 'LIKE', '%' . "48" . '%')
								->orWhere('gred', 'LIKE', '%' . "52" . '%')
								->orWhere('gred', 'LIKE', '%' . "54" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS II" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS III" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "Menteri" . '%')
								->orWhere('gred', 'LIKE', '%' . "MENTERI" . '%')
								->orderBy('name', 'asc')
								->get();


		$optJenisHidangans = LkpJenisHidangan::get();
		$optJenisPerjalanans = LkpJenisPerjalanan::get();
		$optTujuans = LkpTujuan::where('id_tujuan', '!=', '6') 
								->where('id_tujuan', '!=', '7')			
								->get();
		$optBahagians = PLkpBahagian::orderBy('bahagian')->get();
		$OptBilik = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
				->get();
		
		
		return view('tempahanbilik.tambah', compact('OptBilik','result','pengerusi' , 'optJenisPerjalanans', 'optTujuans', 'optBahagians', 'optJenisHidangans', 'pemohon', 'personels'));
    }

	public function searchPegawais (Request $request)
    {
    //   $id = $request->input('id');
    //   $data = PPersonel::where('bahagian_id', $id)
	// 					// ->whereIn('agensi_id',[1,2])
	//  					->orderBy('name')
	// 					->get();

	$nama = $request->input('nama');
    $data = PPersonel::where('id', $nama)
						->first();

      return response()->json($data);
    }

	public function searchDetailPegawais (Request $request)
    {
      $name = $request->input('name');
      $data1 = PPersonel::where('name', $name)
						->first();

      return response()->json($data1);
    }
	
    public function simpan_tambah(Request $request)
    {
		$data = $request->input();
		// $result = PPersonel::where('nokp', Auth::user()->mykad)->first();
		// $nokp = $result->nokp;

		//cari nama user
		if(isset($_POST['cari_nama'])) {
			
			// $users=Users::where(['mykad'=>$data['mykad']])->first();
			
			$nama=$data['Carinama'];
			// $personel=PPersonel::where('id','LIKE', "%{$nama}%")
			// 					->first();
			$personel=PPersonel::where('id', $nama)
								->first();
				
				if(strlen($personel)==0) {
					$request->session()->flash('failed', 'Nama pegawai tiada dalam pangkalan data');
					return redirect('tempahanbilik/tambah')->withInput();
				} else {
					
					//$xemel = explode('@',$personel['emel']);
					$newdata = array(
						'nama'=>$personel->name,
						'bahagian' => optional(PLkpBahagian::find($personel['bahagian_id']))->bahagian ?? '-', 
						// 'bahagian'=>$personel->bahagian,
						'jawatan'=>$personel['jawatan'],
						'gred'=>$personel['gred'],
						'emel'=>$personel['email'],
						'telefon'=>$personel['tel'],
						'tel_bimbit'=>$personel['tel_bimbit'],
						'nokp'=>$personel->nokp,
						//'mykad'=>PPersonel::find($personel['nokp'])->nokp,
					);
					$data = array_replace($data,$newdata);
					// dd($data);
					
					return redirect('tempahanbilik/tambah')->withInput($data);
				}
		
			
		}


		//validate input

		if( isset($data['hidangan-radio']) == null && $data['id_tujuan'] != 1 && $data['id_tujuan'] != 8 ) {
			$data['hidangan-radio'] = 2;
		}
		else {
			$rules = [
				'hidangan-radio' => 'required'
			];			

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) { //check if hidangan radio check or not
				$request->session()->flash('failed', "Sila pilih tempah makanan.");
				//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
				return redirect('/tempahanbilik/tambah/')->withInput();
			}
			else {
				if ($data['hidangan-radio'] == '1') { //check if check tempah makan tapi waktu makan tak check
					$rules = [
						'checkbox_makan' => 'required'
					];

					$validator = Validator::make($request->all(), $rules);

					if ($validator->fails()) {
						$request->session()->flash('failed', "Sila pilih waktu makan.");
						$request->session()->flash('failMakan', "Display input waktu makanan.");
						//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
						return redirect('/tempahanbilik/tambah/')->withInput();
					}
				}
			}
		}
			
			
		//Algorithm check bilik ditaken atau tidak
		
		//date input
		$Inputdate1 =  new DateTime($data['tkh_mula']);
		$Inputdate2 =  new DateTime($data['tkh_hingga']);

		//time input
		$Inputmasa1 = CarbonCarbon::createFromTimeString($data['masa_mula']);
		$masa1Convert = date('h:i a', strtotime($Inputmasa1));
		$Inputmasa2 = CarbonCarbon::createFromTimeString($data['masa_hingga']);
		$masa2Convert = date('h:i a', strtotime($Inputmasa2));

		//ambik dalam database
		$checkBilikS = DB::select('select * from permohonan_bilik');
		//check jumlah tempahan bilik
		$noBilik = PermohonanBilik:: max('id_permohonan_bilik');
		
		//variable tuk verify bili diguna atau tidak
		$validateEnd = null;
		$notAvailable = null;

		$dateCurrent= date_create(Carbon\Carbon::now()->format('Y-m-d'));
		$dateDipohon=date_create($data['tkh_mula']);
		$diff=date_diff($dateCurrent,$dateDipohon);
		//$diff->format("%R%a");
		//return $diff->format("%a");

				
		// if ( $diff->format("%a") >= 1 ) { //if pemohon mohon 1hari atau lebih sebelum tarikh booking

			if( $data['hidangan-radio'] == '1') {

				//if ( $diff->format("%a") >= 2 ) { //if pemohon mohon 2 hari atau lebih sebelum tarikh booking
					if ( $checkBilikS ) { //check if data ada atau kosong
						foreach ($checkBilikS as $checkBilik) {
							$tkh_mula = new DateTime($checkBilik->tkh_mula); //mula
							$tkh_hingga = new DateTime($checkBilik->tkh_hingga); //hingga
				
							if ($checkBilik->id_bilik == $data['id_bilik'] && $checkBilik->id_status != '6' && $checkBilik->id_status != '4' ) { //cari bilik
								if ( ($Inputdate1 >= $tkh_mula && $Inputdate1 <= $tkh_hingga ) ) { //check if tarikh mula dalam tarikh mula & hingga dalam database
									$masa_mula = CarbonCarbon::createFromTimeString($checkBilik->masa_mula);
									$masa_hingga = CarbonCarbon::createFromTimeString($checkBilik->masa_hingga);
				
									if ($Inputmasa1->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									else {
										$notAvailable = 'bilik_tidak_diguna';
										if ($checkBilik->id_permohonan_bilik == $noBilik) {
											$validateEnd = 'End';
										}
										else {
											$validateEnd = 'notEnd';
										}
									}
								}
								if (  ($Inputdate2 >= $tkh_mula && $Inputdate2 <= $tkh_hingga) ) { //check if tarikh mula dalam tarikh mula & hingga dalam database
									$masa_mula = CarbonCarbon::createFromTimeString($checkBilik->masa_mula);
									$masa_hingga = CarbonCarbon::createFromTimeString($checkBilik->masa_hingga);
									
									if ($Inputmasa1->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
										return redirect('/tempahanbilik/tambah/')->withInput();
									}
									else {
										$notAvailable = 'bilik_tidak_diguna';
										if ($checkBilik->id_permohonan_bilik == $noBilik) {
											$validateEnd = 'End';
										}
										else {
											$validateEnd = 'notEnd';
										}
									}
								}
								else {
									$notAvailable = 'bilik_tidak_diguna';
									if ($checkBilik->id_permohonan_bilik == $noBilik) {
										$validateEnd = 'End';
									}
									else {
										$validateEnd = 'notEnd';
									}
								}
							}
							else {
								$notAvailable = 'bilik_tidak_diguna';
								if ($checkBilik->id_permohonan_bilik == $noBilik) {
									$validateEnd = 'End';
								}
								else {
									$validateEnd = 'notEnd';
								}
							}
							
						}
					}
					else { //if dalam data first time insert
						$notAvailable = 'bilik_tidak_diguna';
						$validateEnd = 'End';		
					}
				//}
				// else {
				// 	$request->session()->flash('failed', 'Permohonan tempah makanan perlu ditempah 48 jam sebelum hari mesyuarat.');
				// 	$request->session()->flash('failMakan', "Display input waktu makanan.");
				// 	return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
				// }
			}
			else { //boleh tempah
				if ( $checkBilikS ) { //check if data ada atau kosong
					foreach ($checkBilikS as $checkBilik) {
						$tkh_mula = new DateTime($checkBilik->tkh_mula); //mula
						$tkh_hingga = new DateTime($checkBilik->tkh_hingga); //hingga
			
						if ($checkBilik->id_bilik == $data['id_bilik'] && $checkBilik->id_status != '6' && $checkBilik->id_status != '4' ) { //cari bilik
							if ( ($Inputdate1 >= $tkh_mula && $Inputdate1 <= $tkh_hingga ) ) { //check if tarikh mula dalam tarikh mula & hingga dalam database
								$masa_mula = CarbonCarbon::createFromTimeString($checkBilik->masa_mula);
								$masa_hingga = CarbonCarbon::createFromTimeString($checkBilik->masa_hingga);
			
								if ($Inputmasa1->between($masa_mula, $masa_hingga)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								else {
									$notAvailable = 'bilik_tidak_diguna';
									if ($checkBilik->id_permohonan_bilik == $noBilik) {
										$validateEnd = 'End';
									}
									else {
										$validateEnd = 'notEnd';
									}
								}
							}
							if (  ($Inputdate2 >= $tkh_mula && $Inputdate2 <= $tkh_hingga) ) { //check if tarikh mula dalam tarikh mula & hingga dalam database
								$masa_mula = CarbonCarbon::createFromTimeString($checkBilik->masa_mula);
								$masa_hingga = CarbonCarbon::createFromTimeString($checkBilik->masa_hingga);
								
								if ($Inputmasa1->between($masa_mula, $masa_hingga)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									//return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
									return redirect('/tempahanbilik/tambah/')->withInput();
								}
								else {
									$notAvailable = 'bilik_tidak_diguna';
									if ($checkBilik->id_permohonan_bilik == $noBilik) {
										$validateEnd = 'End';
									}
									else {
										$validateEnd = 'notEnd';
									}
								}
							}
							else {
								$notAvailable = 'bilik_tidak_diguna';
								if ($checkBilik->id_permohonan_bilik == $noBilik) {
									$validateEnd = 'End';
								}
								else {
									$validateEnd = 'notEnd';
								}
							}
						}
						else {
							$notAvailable = 'bilik_tidak_diguna';
							if ($checkBilik->id_permohonan_bilik == $noBilik) {
								$validateEnd = 'End';
							}
							else {
								$validateEnd = 'notEnd';
							}
						}
						
					}
				}
				else { //if dalam data first time insert
					$notAvailable = 'bilik_tidak_diguna';
					$validateEnd = 'End';		
				}
			}

		//}
		// else {
		// 	$request->session()->flash('failed', 'Permohonan perlu ditempah 24 jam sebelum hari mesyuarat.');
		// 	if ($data['hidangan-radio'] == '1') {
		// 		$request->session()->flash('failMakan', "Display input waktu makanan");
		// 	}
		// 	else {
		// 		$request->session()->flash('noMakanan', "Disable input waktu makanan");
		// 	}
		// 	return redirect('/tempahanbilik/tambah/' . $nokp)->withInput();
		// }

		
		
		//If Bilik Tidak Diguna
		if ($validateEnd == 'End' && $notAvailable == 'bilik_tidak_diguna') {
			// kod V2021/00001
			// $jumlah = PermohonanKenderaan::max('id_maklumat_permohonan');	
			$jumlah = PermohonanBilik::whereYear('created_at', '=', Carbon\Carbon::now()->format('Y'))->max('id_permohonan_bilik');
			$jumPK = str_pad($jumlah + 1, 5, '0', STR_PAD_LEFT);
			$kod_permohonand = 'B' . Carbon\Carbon::now()->format('Y') . '/' . $jumPK;

			$nokp = $data['nokp']; //try
			$pemohon = Pemohon::where('mykad', $nokp)->first();
					
					//Check if pengguna dah ada dalam table pemohon
					if ($pemohon == '') {
						$pemohon = new Pemohon;
						//$users->id_pengguna = $data['id_pengguna'];
						$pemohon->mykad = $nokp;
						$pemohon->nama = $data['nama'];
						// $pemohon->pohon_bagi = $data['pohon_bagi'];
						$pemohon->bahagian = $data['bahagian'];
						$pemohon->emel = $data['emel'];
						$pemohon->telefon = $data['telefon'];
						$pemohon->tel_bimbit = $data['tel_bimbit'];
						$pemohon->jawatan = $data['jawatan'];
						$pemohon->gred = $data['gred'];
						$pemohon->updated_by = Carbon\Carbon::now();
						$pemohon->created_by = Carbon\Carbon::now();
						$pemohon->save();
					} else {

						if (isset($data['emel'])) {
							$emel = $data['emel'];
						} else {
							$emel = '';
						}
						// if ($emel == '') {
						// 	$emel = $pemohon->emel;
						// }
						if (isset($data['telefon'])) {
							$telefon = $data['telefon'];
						} else {
							$telefon = '';
						}
						if ($telefon == '') {
							$telefon = $pemohon->telefon;
						}
						if (isset($data['tel_bimbit'])) {
							$tel_bimbit = $data['tel_bimbit'];
						} else {
							$tel_bimbit = '';
						}
						if ($tel_bimbit == '') {
							$tel_bimbit = $pemohon->tel_bimbit;
						}

						$pemohon->update([
							'bahagian' => $data['bahagian'],
							'jawatan' => $data['jawatan'],
							'gred' => $data['gred'],
							'emel' => $emel,
							'telefon' => $telefon,
							'tel_bimbit' => $tel_bimbit,
							'updated_by' => Carbon\Carbon::now(),
						]);
					}

					PPersonel::where('nokp', $nokp)->update([
						'email' => $data['emel'],
						'tel' => $data['telefon'],
						'tel_bimbit' => $data['tel_bimbit'],
						'updated_at' => Carbon\Carbon::now(),
					]);


			$morning = 0;
			$lunch = 0;
			$evening = 0;
			$night = 0;
			

			$pemohon = Pemohon::where('mykad', $nokp)->first();
			$bilik = new PermohonanBilik();
			$bilik->id_pemohon = $pemohon->id_pemohon;
			// $bilik->id_bahagian = $data['bahagian'];
			$bilik->id_bahagian = optional(\App\PLkpBahagian::where('bahagian', $data['bahagian'])->first())->id;
			$bilik->kod_permohonan = $kod_permohonand;
			$bilik->id_tujuan = $data["id_tujuan"];
			$bilik->nama_pengerusi = $data["nama_pengerusi"];
			$bilik->id_bilik = $data["id_bilik"];
			$bilik->bil_peserta = $data["jumlah_pegawai"];
			$bilik->tkh_mula = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
			$bilik->tkh_hingga = Carbon\Carbon::parse($data['tkh_hingga'])->format('Y-m-d');
			$bilik->masa_mula = $data["masa_mula"];
			$bilik->masa_hingga = $data["masa_hingga"];
			$bilik->nama_tujuan = $data["nama_tujuan"];
			$bilik->tempah_makan = $data["hidangan-radio"];		
			$bilik->created_at = Carbon\Carbon::now();
			$bilik->id_status = 1; //status Permohonan Baru
			$bilik->save();

			if($bilik->tempah_makan == 1){
				//check makan pagi, tengahari or petang
				for($i=0;$i<sizeof($data['checkbox_makan']);$i++)
				{
					if($data['checkbox_makan'][$i]=="1") {$morning = 1;}
					elseif($data['checkbox_makan'][$i]=="2") {$lunch = 1;}
					elseif($data['checkbox_makan'][$i]=="3") {$evening = 1;}
					else {$night = 1;}
				}
				$tempahmakan = new TempahMakan();
				$idmakanbilik = $bilik->max('id_permohonan_bilik');
				$tempahmakan->id_permohonan_bilik = $idmakanbilik;
				$tempahmakan->makan_pagi = $morning;
				$tempahmakan->makan_tghari = $lunch;
				$tempahmakan->minum_petang = $evening;
				$tempahmakan->makan_malam = $night;
				$tempahmakan->created_at = Carbon\Carbon::now();
				$tempahmakan->save();

				$cari = TempahMakan::orderBy('id_tempah_makan', 'desc')->first();
				$id = $cari->id_tempah_makan;

				return redirect('/tempahanbilik/kemaskini/makanan/'.$id);		
			}
			else {
				//tempah makanan
				$tempahmakan = new TempahMakan();
				$idmakanbilik = $bilik->max('id_permohonan_bilik');
				$tempahmakan->id_permohonan_bilik = $idmakanbilik;
				$tempahmakan->makan_pagi = 0;
				$tempahmakan->makan_tghari = 0;
				$tempahmakan->minum_petang = 0;
				$tempahmakan->makan_malam = 0;
				$tempahmakan->created_at = Carbon\Carbon::now();
				$tempahmakan->save();

				//tindakan
				$id_permohonan = $bilik->max('id_permohonan_bilik');

				$tindakan = new Tindakan;
				$tindakan->id_permohonan = $id_permohonan;
				$tindakan->id_status_tempah = 1;
				$tindakan->id_status_makan = 1;
				$tindakan->peg_penyelia = $pemohon->mykad;
				$tindakan->updated_by = Carbon\Carbon::now();
				$tindakan->created_by = Carbon\Carbon::now();
				$tindakan->save();

				//EMEL
				$bilik = new PermohonanBilik();
				$id_permohonan = $bilik->max('id_permohonan_bilik');
				$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
											->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
											->where('permohonan_bilik.id_permohonan_bilik', $id_permohonan)
											->first();
				//return $contentEmel;
				//dd($contentEmel);
				$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
				// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem
		
				//HANTAR EMEL KEPADA PEMOHON
				// Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				// {
				// 	$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
				// 	//$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
				// 	$header->to('azhim@perpaduan.gov.my', 'azhim');
				// 	// foreach($pentadbirs as $pentadbir)
				// 	// {
				// 	// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
				// 	// }
		
				// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 	$header->subject('PERKARA: Notifikasi Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
				// });


				//Pass id tuk checking if current user boleh kemaskini
				$id = $bilik->id_permohonan_bilik;
				
				//$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
				$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar.');
				//return redirect('/tempahanbilik/butiran/' . $id);			
				return redirect('/tempahanbilik/');			
			}
		}
		
		
    }
	
    public function butiran($id)
    {
	
        $permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
        $permohonanBilik  = PermohonanBilik::where(['id_permohonan_bilik'=>$id])->first();
		// dd($permohonanKenderaan);
		// $id_pemohon = $permohonanKenderaan->id_pemohon;
		$id_pemohon = $permohonanBilik->id_pemohon;
		
		//UBAH CARI PERSONEL
		$cariPemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$OptBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
					->where('id_bilik',$permohonanBilik->id_bilik)
					->first();
		$optStatuss = LkpStatus::whereIn('id_status', ['3', '4', '5'])->get();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$menuMakans  = MenuMakan::where(['id_tempah_makan' => $tempahMakans->id_tempah_makan])->get();
		$katerers = LkpKaterer:: get();

		//Kire total kalori pagi, tengahari & petang
		$Kpagi = 0;
		$Ktengahari = 0;
		$Kpetang = 0;
		$Kmalam = 0;

		foreach($menuMakans as $menuMakan){ 
			if($menuMakan->id_tempah_makan == $tempahMakans->id_tempah_makan){
				if($menuMakan->jenis_makan == '1'){
					$Kpagi=$Kpagi + intval($menuMakan->kalori);
				}
				else if($menuMakan->jenis_makan == '2'){
					$Ktengahari=$Ktengahari + intval($menuMakan->kalori);
				}
				else if($menuMakan->jenis_makan == '3'){
					$Kpetang=$Kpetang + intval($menuMakan->kalori);
				}
				else if($menuMakan->jenis_makan == '4'){
					$Kmalam=$Kmalam + intval($menuMakan->kalori);
				}
			}
		};

		TempahMakan::where('id_permohonan_bilik', $id)->update([
			'kalori_pagi' => $Kpagi,
			'kalori_tengahari' => $Ktengahari,
			'kalori_petang' => $Kpetang,
			'kalori_malam' => $Kmalam,
		]);

		//bila admin view first time change to Dalam proses
		$tindakanFirst =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->latest('created_by')->first();
		//return $tindakanFirst;	
		if ( isset($tindakanFirst) ) {
			if ($tindakanFirst->id_status_tempah != 2 && $tindakanFirst->id_status_tempah != 3 && $tindakanFirst->id_status_tempah != 6 && $tindakanFirst->id_status_tempah != 4
		      && $tindakanFirst->id_status_tempah != 5 && Auth::User()->id_access != 4) {

			PermohonanBilik::where('id_permohonan_bilik', $id)->update([
				'id_status' => 2, //status dalam proses
				'updated_at' => Carbon\Carbon::now()
			]);

			//search nama pegawai
			$pegawaiSah = PPersonel:: where('name', Auth::User()->nama)->first();

			$tindakan = new Tindakan;
			$tindakan->id_permohonan = $id;
			$tindakan->id_status_tempah = 2; //dalam proses
			$tindakan->id_status_makan = 2; // dalam proses
			$tindakan->peg_penyelia = $pegawaiSah->nokp;
			$tindakan->updated_by = Carbon\Carbon::now();
			$tindakan->created_by = Carbon\Carbon::now();
			$tindakan->save();
		} 
		}
		 
				

		$personels = PPersonel:: get();
		$tindakans =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by')->get();
		$tindakanStatus =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by', 'desc')->first();

		return view('tempahanbilik.butiran', compact('permohonanKenderaan','katerers','personels', 'permohonanBilik','pemohon', 'OptBiliks', 'tempahMakans', 'menuMakans', 'tindakans', 'tindakanStatus'));
    }
	
    public function kemaskini($id)
    {
		// $optTujuans = LkpTujuan::get();
        // $permohonanKenderaan = PermohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// $id_pemohon = $permohonanKenderaan->id_pemohon;
		// $pemohon = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();
		// $optBahagians = PLkpBahagian::orderBy('bahagian')->get();
		// $penumpangs = Penumpang::where(['id_tempahan'=>$id])->get();
		// $maklumat_penumpang='';
		// return view('tempahankenderaan.kemaskini', compact('permohonanKenderaan','pemohon','optNegeris','optJenisPerjalanans','optTujuans','optBahagians','maklumat_penumpang'));


		$optTujuans = LkpTujuan::where('id_tujuan', '!=', '6') 
								->where('id_tujuan', '!=', '7')			
								->get();
		$pengerusi = PPersonel:: where('gred', 'LIKE', '%' . "41" . '%')
								->where('stat_pegawai', '!=', 0)
								->orWhere('gred', 'LIKE', '%' . "44" . '%')
								->orWhere('gred', 'LIKE', '%' . "48" . '%')
								->orWhere('gred', 'LIKE', '%' . "52" . '%')
								->orWhere('gred', 'LIKE', '%' . "54" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS II" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS III" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "Menteri" . '%')
								->orWhere('gred', 'LIKE', '%' . "MENTERI" . '%')
								->orderBy('name', 'asc')
								->get();

		$permohonanBiliks = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		$id_pemohon = $permohonanBiliks->id_pemohon;
		//UBAH CARI PERSONEL
		$cariPemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$optBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
				->get();
		$tempahMakans = TempahMakan::where(['id_permohonan_bilik' => $id])->first();

		return view('tempahanbilik.kemaskini', compact('permohonanBiliks','pengerusi' , 'pemohon', 'optTujuans', 'optBiliks', 'tempahMakans'));				
    }
	
    public function simpan_kemaskini(Request $request, $id)
    {
		$data = $request->input();

		//validate input
		
		if( isset($data['hidangan-radio']) == null && $data['id_tujuan'] != 1 && $data['id_tujuan'] != 8 ) {
			$data['hidangan-radio'] = 2;
		}
		else {
			$rules = [
				'hidangan-radio' => 'required'
			];			

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) { //check if hidangan radio check or not
				$request->session()->flash('failed', "Sila pilih tempah makanan.");
				$request->session()->flash('noMakanan', "Disable input waktu makanan");
				return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
			}
			else {
				if ($data['hidangan-radio'] == '1') { //check if check tempah makan tapi waktu makan tak check
					$rules = [
						'checkbox_makan' => 'required'
					];

					$validator = Validator::make($request->all(), $rules);

					if ($validator->fails()) {
						$request->session()->flash('failed', "Sila pilih waktu makan.");
						$request->session()->flash('failMakan', "Display input waktu makanan.");
						$request->session()->flash('noMakanan', "Disable input waktu makanan");
						return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
					}
				}
			}
		}
		

		//Algorithm check bilik ditaken atau tidak	
		//date input
		$Inputdate1 =  new DateTime($data['tkh_mula']);
		$Inputdate2 =  new DateTime($data['tkh_hingga']);

		//time input
		$Inputmasa1 = CarbonCarbon::createFromTimeString($data['masa_mula']);
		$masa1Convert = date('h:i a', strtotime($Inputmasa1));
		$Inputmasa2 = CarbonCarbon::createFromTimeString($data['masa_hingga']);
		$masa2Convert = date('h:i a', strtotime($Inputmasa2));

		//ambik dalam database
		$checkBilikS = PermohonanBilik::get();
		//check jumlah tempahan bilik
		$noBilik = PermohonanBilik:: max('id_permohonan_bilik');

		//variable tuk verify bili diguna atau tidak
		$validateEnd = null;
		$notAvailable = null;

		foreach ($checkBilikS as $checkBilik) {
			$tkh_mula = new DateTime($checkBilik->tkh_mula); //mula
			$tkh_hingga = new DateTime($checkBilik->tkh_hingga); //hingga

			if ($checkBilik->id_permohonan_bilik != $id) { //check supaya tak check id sendiri
				if ($checkBilik->id_bilik == $data['id_bilik']) { //cari bilik
					if ( ($Inputdate1 >= $tkh_mula && $Inputdate1 <= $tkh_hingga ) ) { //check if tarikh mula dalam tarikh mula & hingga dalam database
						$masa_mula = CarbonCarbon::createFromTimeString($checkBilik->masa_mula);
						$masa_hingga = CarbonCarbon::createFromTimeString($checkBilik->masa_hingga);
	
						if ($Inputmasa1->between($masa_mula, $masa_hingga)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						else {
							$notAvailable = 'bilik_tidak_diguna';
							if ($checkBilik->id_permohonan_bilik == $noBilik) {
								$validateEnd = 'End';
							}
							else {
								$validateEnd = 'notEnd';
							}
						}
					}
					if (  ($Inputdate2 >= $tkh_mula && $Inputdate2 <= $tkh_hingga) ) { //check if tarikh mula dalam tarikh mula & hingga dalam database
						$masa_mula = CarbonCarbon::createFromTimeString($checkBilik->masa_mula);
						$masa_hingga = CarbonCarbon::createFromTimeString($checkBilik->masa_hingga);
						
						if ($Inputmasa1->between($masa_mula, $masa_hingga)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
							$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
							$request->session()->flash('noMakanan', "Disable input waktu makanan");
							return redirect('/tempahanbilik/kemaskini/' . $id)->withInput();
						}
						else {
							$notAvailable = 'bilik_tidak_diguna';
							if ($checkBilik->id_permohonan_bilik == $noBilik) {
								$validateEnd = 'End';
							}
							else {
								$validateEnd = 'notEnd';
							}
						}
					}
					else {
						$notAvailable = 'bilik_tidak_diguna';
						if ($checkBilik->id_permohonan_bilik == $noBilik) {
							$validateEnd = 'End';
						}
						else {
							$validateEnd = 'notEnd';
						}
					}
				}
				else {
					$notAvailable = 'bilik_tidak_diguna';
					if ($checkBilik->id_permohonan_bilik == $noBilik) {
						$validateEnd = 'End';
					}
					else {
						$validateEnd = 'notEnd';
					}
				}
				
			}
			else {
				$notAvailable = 'bilik_tidak_diguna';
				if ($checkBilik->id_permohonan_bilik == $noBilik) {
					$validateEnd = 'End';
				}
				else {
					$validateEnd = 'notEnd';
				}
			}
		}


		//If Bilik Tidak Diguna
		if ($validateEnd == 'End' && $notAvailable == 'bilik_tidak_diguna') {
			$morning = 0;
			$lunch = 0;
			$evening = 0;
			$night = 0;

			$idSearch = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
			$idPemohon = $idSearch->id_pemohon;

			$pemohon = Pemohon::where('id_pemohon', $idPemohon)->first();

					$pemohon->update([
						'telefon' => $data['telefon'],
						'tel_bimbit' => $data['tel_bimbit'],
						'updated_by' => Carbon\Carbon::now(),
					]);

					PPersonel::where('nokp', $pemohon->mykad)->update([
						// 'email' => $emel,
						'tel' => $data['telefon'],
						'tel_bimbit' =>  $data['tel_bimbit'],
						'updated_at' => Carbon\Carbon::now(),
					]);

			PermohonanBilik::where('id_permohonan_bilik', $id)->update([
				'id_tujuan' => $data['id_tujuan'],
				'nama_tujuan' => $data['nama_tujuan'],
				'tkh_mula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
				'tkh_hingga' => Carbon\Carbon::parse($data['tkh_hingga'])->format('Y-m-d'),
				'masa_mula' => Carbon\Carbon::parse($data['masa_mula'])->format('H:i:s'),
				'masa_hingga' => Carbon\Carbon::parse($data['masa_hingga'])->format('H:i:s'),
				'id_bilik' => $data['id_bilik'],
				'tempah_makan' => $data['hidangan-radio'],
				'bil_peserta' =>  $data['jumlah_pegawai'],
				'nama_pengerusi' => $data['nama_pengerusi'],
				'tempah_makan' => $data['hidangan-radio'],
				// 'id_status' => 2, //status kemaskini
				'updated_at' => Carbon\Carbon::now()
			]);

			if ($data['hidangan-radio'] == 1){
				//check makan pagi, tengahari or petang
				for($i=0;$i<sizeof($data['checkbox_makan']);$i++)
				{
					if($data['checkbox_makan'][$i]=="1") {$morning = 1;}
					elseif($data['checkbox_makan'][$i]=="2") {$lunch = 1;}
					elseif($data['checkbox_makan'][$i]=="3") {$evening = 1;}
					else {$night = 1;}
				}
					//PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
					TempahMakan::where('id_permohonan_bilik', $id)->update([
					'makan_pagi' => $morning,
					'makan_tghari' => $lunch,
					'minum_petang' => $evening,
					'makan_malam' => $night,
					'updated_at' => Carbon\Carbon::now()
				]);

				
				return redirect('/tempahanbilik/kemaskini/makanan/'.$id);		

			} else {
					PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
					TempahMakan::where('id_permohonan_bilik', $id)->update([
					'makan_pagi' => 0,
					'makan_tghari' => 0,
					'minum_petang' => 0,
					'makan_malam' => 0,
					'updated_at' => Carbon\Carbon::now()
				]);

				$checkTindakan = Tindakan:: where('id_permohonan', $id)
										->where('id_status_makan', '!=', null)
										->first();
				if($checkTindakan) {
					//kemaskini tindakan 
					// $tindakan = new Tindakan; 
					// $tindakan->id_permohonan = $id;
					// $tindakan->id_status_tempah = 2;
					// $tindakan->id_status_makan = 2;
					// $tindakan->peg_penyelia = $idpemohon->mykad;
					// $tindakan->updated_by = Carbon\Carbon::now();
					// $tindakan->created_by = Carbon\Carbon::now();
					// $tindakan->save();

					//EMEL
					$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
												->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
												->where('permohonan_bilik.id_permohonan_bilik', $id)
												->first();
					//return $contentEmel;
					//dd($contentEmel);
					$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
					// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem

					//HANTAR EMEL KEPADA PEMOHON
					// Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
					// {
					// 	$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
					// 	//$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
					// 	$header->to('azhim@perpaduan.gov.my', 'azhim');
					// 	// foreach($pentadbirs as $pentadbir)
					// 	// {
					// 	// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					// 	// }

					// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
					// 	$header->subject('PERKARA: Notifikasi Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
					// });

					$request->session()->flash('status', 'Maklumat Tempahan berjaya disimpan.');
					return redirect('tempahanbilik/butiran/' . $id);
				}
				else {
					//permohonan baru tindakan
					$permohonanBilik = PermohonanBilik:: where('id_permohonan_bilik', $id)->first();
					$pemohon = Pemohon:: where('id_pemohon', $permohonanBilik->id_pemohon)->first();

					$tindakan = new Tindakan; 
					$tindakan->id_permohonan = $id;
					$tindakan->id_status_tempah = 1;
					$tindakan->id_status_makan = 1;
					$tindakan->peg_penyelia = $pemohon->mykad;
					$tindakan->updated_by = Carbon\Carbon::now();
					$tindakan->created_by = Carbon\Carbon::now();
					$tindakan->save();

					$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
					return redirect('/tempahanbilik/');
				}


				// $request->session()->flash('status', 'Maklumat Tempahan berjaya disimpan.');
				// return redirect('tempahanbilik/butiran/' . $id );
			}
		}

    }

	public function makanan(Request $request, $id) {
		$optJenisHidangans = LkpJenisHidangan ::get();
		$tempahmakan = TempahMakan::where('id_tempah_makan', $id)->first();
		$menumakan = MenuMakan::where('id_tempah_makan', $id)->get();

		return view('tempahanbilik.kemaskini_makanan', compact('menumakan', 'tempahmakan', 'optJenisHidangans'));
	}

	public function simpan_makanan(Request $request, $id) {
		$data = $request->input();
		
		//$tempahMakan = TempahMakan::where('id_tempah_makan', $id);
		$menumakan = new MenuMakan();

		if(isset($_POST['makanpagi'])){

			$rules = [
				'input_pagi' => 'required',
				'kalori_pagi' => 'required|int',
				'id_jenis_hidangan1' => 'required',
			];
	
			$validator = Validator::make($request->all(), $rules);
	
			if ($validator->fails()) {
				$request->session()->flash('failed', "Sila pastikan anda masukkan menu makan pagi dengan betul.");
				return redirect('/tempahanbilik/kemaskini/makanan/' . $id)->withInput();
			} else {
					//save menu makan
				$menumakan->id_tempah_makan = $id;
				$menumakan->menu = $data['input_pagi'];
				$menumakan->kalori = $data['kalori_pagi'];
				$menumakan->jenis_makan = $data['jenis_makan1'];
				$menumakan->save();

				//save jenis hidangan makan pagi
				TempahMakan::where('id_tempah_makan', $id)->update([
					'id_jenis_hidangan1' => $data['id_jenis_hidangan1'],
				]);
				
				return redirect('/tempahanbilik/kemaskini/makanan/'.$id);
			}

		}
		else if(isset($_POST['makantengahari'])){

			$rules = [
				'input_tengahari' => 'required',
				'kalori_tengahari' => 'required|int',
				'id_jenis_hidangan2' => 'required',
			];
	
			$validator = Validator::make($request->all(), $rules);
	
			if ($validator->fails()) {
				$request->session()->flash('failed', "Sila pastikan anda masukkan menu makan tengahari dengan betul.");
				return redirect('/tempahanbilik/kemaskini/makanan/' . $id)->withInput();
			} else {
				$menumakan->id_tempah_makan = $id;
				$menumakan->menu = $data['input_tengahari'];
				$menumakan->kalori = $data['kalori_tengahari'];
				$menumakan->jenis_makan = $data['jenis_makan2'];
				$menumakan->save();

				//save jenis hidangan makan pagi
				TempahMakan::where('id_tempah_makan', $id)->update([
					'id_jenis_hidangan2' => $data['id_jenis_hidangan2'],
				]);
				
				return redirect('/tempahanbilik/kemaskini/makanan/'.$id);
			}

		}
		else if(isset($_POST['makanpetang'])){

			
			$rules = [
				'input_petang' => 'required',
				'kalori_petang' => 'required|int',
				'id_jenis_hidangan3' => 'required',
			];
	
			$validator = Validator::make($request->all(), $rules);
	
			if ($validator->fails()) {
				$request->session()->flash('failed', "Sila pastikan anda masukkan menu minum petang dengan betul.");
				return redirect('/tempahanbilik/kemaskini/makanan/' . $id)->withInput();
			} else {
				$menumakan->id_tempah_makan = $id;
				$menumakan->menu = $data['input_petang'];
				$menumakan->kalori = $data['kalori_petang'];
				$menumakan->jenis_makan = $data['jenis_makan3'];
				$menumakan->save();
				
				//save jenis hidangan makan pagi
				TempahMakan::where('id_tempah_makan', $id)->update([
					'id_jenis_hidangan3' => $data['id_jenis_hidangan3'],
				]);
				
				return redirect('/tempahanbilik/kemaskini/makanan/'.$id);
			}

		}
		else if(isset($_POST['makanmalam'])){
			//return $data['id_jenis_hidangan4'];
			$rules = [
				'input_malam' => 'required',
				'kalori_malam' => 'required|int',
				'id_jenis_hidangan4' => 'required',
			];
	
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				$request->session()->flash('failed', "Sila pastikan anda masukkan menu makan malam dengan betul.");
				return redirect('/tempahanbilik/kemaskini/makanan/' . $id)->withInput();
			} else {
				//return "fail";
				$menumakan->id_tempah_makan = $id;
				$menumakan->menu = $data['input_malam'];
				$menumakan->kalori = $data['kalori_malam'];
				$menumakan->jenis_makan = $data['jenis_makan4'];
				$menumakan->save();
				
				//save jenis hidangan makan malam
				TempahMakan::where('id_tempah_makan', $id)->update([
					'id_jenis_hidangan4' => $data['id_jenis_hidangan4'],
				]);
				
				return redirect('/tempahanbilik/kemaskini/makanan/'.$id);
			}

		}
		else if( isset($_POST['edit_makanan']) ){
			// return $menuMakan = MenuMakan::find($data['id_menu_makan']);

			MenuMakan::where('id_menu_makan', $data['id_menu_makan'])->update([
				'menu' => $data['menu_baru'],
				'kalori' =>  $data['kalori_baru'],
			]);

			return redirect('/tempahanbilik/kemaskini/makanan/'.$id);

		}
		else if(isset($_POST['hantar'])) {

			//to pass id pemohon back to screen calendar
			$idtempah = TempahMakan::where('id_tempah_makan', $id)->first();
			$idbilik = PermohonanBilik::where('id_permohonan_bilik', $idtempah->id_permohonan_bilik)->first();
			$idpemohon = Pemohon::where('id_pemohon', $idbilik->id_pemohon)->first();
	
			$id = $idbilik->id_permohonan_bilik;
			$idPemohon = $idbilik->id_pemohon;

			//check if permohonan baru atau tidak
			$checkTindakan = Tindakan:: where('id_permohonan', $idbilik->id_permohonan_bilik)
										->where('id_status_makan', '!=', null)
										->first();
			if($checkTindakan) {
				//update tindakan 
				// $tindakan = new Tindakan; 
				// $tindakan->id_permohonan = $id;
				// $tindakan->id_status_tempah = 2;
				// $tindakan->id_status_makan = 2;
				// $tindakan->peg_penyelia = $idpemohon->mykad;
				// $tindakan->updated_by = Carbon\Carbon::now();
				// $tindakan->created_by = Carbon\Carbon::now();
				// $tindakan->save();

				$request->session()->flash('status', 'Maklumat Tempahan berjaya disimpan.');
				return redirect('tempahanbilik/butiran/' . $id);
				//$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar.');
				//return redirect('/tempahanbilik/');	
			}
			else {
				//permohonan baru tindakan
				$tindakan = new Tindakan; 
				$tindakan->id_permohonan = $id;
				$tindakan->id_status_tempah = 1;
				$tindakan->id_status_makan = 1;
				$tindakan->peg_penyelia = $idpemohon->mykad;
				$tindakan->updated_by = Carbon\Carbon::now();
				$tindakan->created_by = Carbon\Carbon::now();
				$tindakan->save();

				//EMEL
				$bilik = new PermohonanBilik();
				$id_permohonan = $bilik->max('id_permohonan_bilik');
				$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
											->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
											->where('permohonan_bilik.id_permohonan_bilik', $id_permohonan)
											->first();
				//return $contentEmel;
				//dd($contentEmel);
				$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
				// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem
		
				//HANTAR EMEL KEPADA PEMOHON
				// Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				// {
				// 	$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
				// 	//$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
				// 	$header->to('azhim@perpaduan.gov.my', 'azhim');
				// 	// foreach($pentadbirs as $pentadbir)
				// 	// {
				// 	// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
				// 	// }
		
				// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 	$header->subject('PERKARA: Notifikasi Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
				// });

				//$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
				//return redirect('tempahanbilik/butiran/' . $id);
				$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar.');
				return redirect('/tempahanbilik/');	
			}
			
		}
		
	}

	function hapus_makanan($id){
		$menuMakans = MenuMakan::where('id_menu_makan', $id)->first(); 
		$tempahmakan = TempahMakan::where('id_tempah_makan', $menuMakans->id_tempah_makan)->first();
		$hapusMenu = MenuMakan::where('id_menu_makan', $id)->delete();
		$menumakan =MenuMakan::where('id_tempah_makan', $tempahmakan->id_tempah_makan)->get();
		$optJenisHidangans = LkpJenisHidangan:: get();
		

		return view('tempahanbilik.kemaskini_makanan', compact('menumakan', 'tempahmakan', 'optJenisHidangans'));
	}

	public function batal($id)
    {
		$permohonanBilik  = PermohonanBilik::where(['id_permohonan_bilik'=>$id])->first();
		// dd($permohonanKenderaan);
		$id_pemohon = $permohonanBilik->id_pemohon;
		
		//UBAH CARI PERSONEL
		$cariPemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$OptBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
					->where('id_bilik',$permohonanBilik->id_bilik)
					->first();
		$optStatuss = LkpStatus::whereIn('id_status', ['3', '4', '5'])->get();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$menuMakans  = MenuMakan::where(['id_tempah_makan' => $tempahMakans->id_tempah_makan])->get();
		$personels = PPersonel::get();

		return view('tempahanbilik.batal', compact('pemohon','personels', 'permohonanBilik','OptBiliks', 'optStatuss', 'tempahMakans', 'menuMakans'));
    }
	
    public function simpan_batal(Request $request, $id)
    {
		try {			

			$data = $request->input();
			$rules = [
				'catatanBatal' => 'required'
			];

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				$request->session()->flash('failed', "Sila berikan alasan pembatalan.");
				return redirect('/tempahanbilik/batal/' . $id)->withInput();
			}
			

			// dd($id);
			// Permohonan::where('id_permohonan', $id)->delete();
			PermohonanBilik::where('id_permohonan_bilik', $id)->update([
				'id_status' => 6,
				'updated_at' => Carbon\Carbon::now(),
			]);

			$tindakan = new Tindakan;
			$tindakan->id_permohonan = $id;
			$tindakan->id_status_tempah = 6;
			$tindakan->id_status_makan = 6;
			$tindakan->catatan = $data['catatanBatal']; //catatan alasan batal
			$tindakan->peg_penyelia = Auth::User()->mykad;
			$tindakan->updated_by = Carbon\Carbon::now();
			$tindakan->created_by = Carbon\Carbon::now();
			$tindakan->save();

			//EMEL
			$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
										->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
										->where('permohonan_bilik.id_permohonan_bilik', $id)
										->first();
			//return $contentEmel;
			//dd($contentEmel);
			$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
			// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem
	
			//HANTAR EMEL KEPADA PEMOHON
			// Mail::send('emailbilik/statusPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
			// {
			// 	$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
			// 	//$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
			// 	$header->to('azhim@perpaduan.gov.my', 'azhim');
			// 	// foreach($pentadbirs as $pentadbir)
			// 	// {
			// 	// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
			// 	// }
	
			// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
			// 	$header->subject('PERKARA: Notifikasi Status Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
			// });
			
			$request->session()->flash('status', 'Permohonan berjaya dibatalkan.');
			return redirect('tempahanbilik');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Permohonan tidak berjaya dibatalkan.');
			return redirect('tempahanbilik/batal/'.$id);
		}
    }

	public function old_tindakan($id)
    {
		$permohonanBilik = PermohonanBilik::where(['id_permohonan_bilik'=>$id])->first();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])
									->OrderBy('created_at', 'asc')
									->get();
						
		//$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		if ( count($tempahMakans) > 1 ) {
			$tempahMakans1 = $tempahMakans[0]; //lama
			$tempahMakans2 = $tempahMakans[1]; // baru

			$menuMakans1 = MenuMakan::where(['id_tempah_makan' => $tempahMakans1->id_tempah_makan])->get();
			$menuMakans2 = MenuMakan::where(['id_tempah_makan' => $tempahMakans2->id_tempah_makan])->get();
		}					
		else {
			$tempahMakans1 = $tempahMakans[0];
			$menuMakans1  = MenuMakan::where(['id_tempah_makan' => $tempahMakans1->id_tempah_makan])->get();

			$tempahMakans2 = null;
			$menuMakans2 = null;
		}
		
		$katerers = LkpKaterer::get();

		$optStatuss = LkpStatus::whereIn('id_status',['3','4','5'])->get();
		
						
		// return view('tempahanbilik.tindakan', compact('optStatuss', 'permohonanBilik' , 'tempahMakans', 'menuMakans', 'katerers'));
		return view('tempahanbilik.tindakan', compact('optStatuss', 'permohonanBilik' , 'tempahMakans1', 'tempahMakans2', 'menuMakans1', 'menuMakans2', 'katerers'));
    }

	public function tindakan($id)
    {
		$permohonanBilik = PermohonanBilik::where(['id_permohonan_bilik'=>$id])->first();
						
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$menuMakans = MenuMakan::where('id_tempah_makan', $tempahMakans->id_tempah_makan)->get();
		
		$katerers = LkpKaterer::get();

		$optStatuss = LkpStatus::whereIn('id_status',['3','4','5'])->get();
						
		return view('tempahanbilik.tindakan', compact('optStatuss', 'permohonanBilik' , 'tempahMakans', 'menuMakans', 'katerers'));
    }

	public function ubahsuai_makanan($id) {


		$tempahMakans =  TempahMakan::where('id_permohonan_bilik', $id)
											->orderBy('updated_at', 'desc')
											->first();

		$menuMakans =  MenuMakan::where('id_tempah_makan', $tempahMakans->id_tempah_makan)->get();

			
			// return view('tempahanbilik.tindakan_ubahMakan', compact('makanUbah'));
			return view('tempahanbilik.tindakan_ubahMakan', compact('tempahMakans', 'menuMakans'));
	}

	public function simpan_ubahsuai_makanan (Request $request, $id) {
		$data = $request->input();
		 MenuMakan ::where('id_menu_makan', $id)
									->update([
										'menu' => $data['menu_baru'],
										'kalori' => $data['kalori_baru'],
									]);

		$menuMakanDiubah = MenuMakan:: where('id_menu_makan', $id)->first();
		$idTempahMakan = TempahMakan::where('id_tempah_makan', $menuMakanDiubah->id_tempah_makan)
										->orderBy('updated_at', 'desc')
										->first();
		$idBilik = $idTempahMakan->id_permohonan_bilik;

		return redirect('/tempahanbilik/tindakan/ubahsuai_makanan/'.$idBilik);
	}

	// public function takjadi_ubahsuai_makanan($id) {
	// 		$makanDipohon = TempahMakan::  where(['id_permohonan_bilik' => $id])->get(); //cari tempah makan yang dipohon user

	// 		$bil_makanDipohon = count($makanDipohon); //kire kalo ade 1 atau 2

	// 		$menuLama = MenuMakan:: where(['id_tempah_makan' => $makanDipohon[0]->id_tempah_makan])->get(); //letak jdi menu lama

	// 		if($bil_makanDipohon == 1 ) { //kalo takde data diubah buat masuk satu baru untuk diubah
	// 			//Tempah Makan Yang Baru Diubah
	// 			//set Temporary Menu Baru ,isi yng lame before diubah -> TempahMakan
	// 			$makanUbah = new TempahMakan();
	// 			$makanUbah->id_permohonan_bilik = $id;
	// 			$makanUbah->makan_pagi = $makanDipohon[0]->makan_pagi;
	// 			$makanUbah->makan_tghari = $makanDipohon[0]->makan_tghari;
	// 			$makanUbah->minum_petang = $makanDipohon[0]->minum_petang;

	// 			$makanUbah->kalori_pagi = $makanDipohon[0]->kalori_pagi;
	// 			$makanUbah->kalori_tengahari = $makanDipohon[0]->kalori_tengahari;
	// 			$makanUbah->kalori_petang = $makanDipohon[0]->kalori_petang;

	// 			$makanUbah->id_jenis_hidangan1 = $makanDipohon[0]->id_jenis_hidangan1; 
	// 			$makanUbah->id_jenis_hidangan2 = $makanDipohon[0]->id_jenis_hidangan2; 
	// 			$makanUbah->id_jenis_hidangan3 = $makanDipohon[0]->id_jenis_hidangan3; 

	// 			$makanUbah->kadar_harga = $makanDipohon[0]->kadar_harga; 
	// 			$makanUbah->pembekal = $makanDipohon[0]->pembekal; 

	// 			$makanUbah->updated_at = Carbon\Carbon::now();
	// 			$makanUbah->created_at = Carbon\Carbon::now();
	// 			$makanUbah->save();

	// 			//Menu Makan Yang Akan Diubah
	// 			foreach($menuLama as $menuLamas) { 
	// 				//letak temp menu baru set menu lama -> MenuMakan
	// 				$menuBaru = new MenuMakan();
	// 				$menuBaru->id_tempah_makan = $makanUbah->id_tempah_makan;
	// 				$menuBaru->menu = $menuLamas->menu;
	// 				$menuBaru->kalori = $menuLamas->kalori;
	// 				$menuBaru->jenis_makan = $menuLamas->jenis_makan;
	// 				$menuBaru->save();
	// 			}

	// 			//untuk display ke page
	// 			//ambik yng latest which is the 2nd yang tuk diubah
	// 			$tempahMakans =  TempahMakan::where('id_permohonan_bilik', $id)
	// 										->orderBy('updated_at', 'desc')
	// 										->first();
				

	// 			$menuMakans =  MenuMakan::where('id_tempah_makan', $tempahMakans->id_tempah_makan)->get();

	// 		}
	// 		else if ($bil_makanDipohon > 1){
	// 			//untuk display ke page
	// 			$tempahMakans =  TempahMakan::where('id_permohonan_bilik', $id)
	// 										->orderBy('updated_at', 'desc')
	// 										->first();

	// 			$menuMakans =  MenuMakan::where('id_tempah_makan', $tempahMakans->id_tempah_makan)->get();

	// 		}
			
	// 		// return view('tempahanbilik.tindakan_ubahMakan', compact('makanUbah'));
	// 		return view('tempahanbilik.tindakan_ubahMakan', compact('tempahMakans', 'menuMakans'));
	// }

	// public function takjadi_simpan_ubahsuai_makanan (Request $request, $id) {
	// 	$data = $request->input();
	// 	$menuMakanUbah = MenuMakan ::where('id_menu_makan', $id)
	// 								->update([
	// 									'menu' => $data['menu_baru'],
	// 									'kalori' => $data['kalori_baru'],
	// 								]);

	// 	$menuMakanDiubah = MenuMakan:: where('id_menu_makan', $id)->first();
	// 	$idTempahMakan = TempahMakan::where('id_tempah_makan', $menuMakanDiubah->id_tempah_makan)
	// 									->orderBy('updated_at', 'desc')
	// 									->first();
	// 	$idBilik = $idTempahMakan->id_permohonan_bilik;

	// 	return redirect('/tempahanbilik/tindakan/ubahsuai_makanan/'.$idBilik);
	// }

	public function searchKenderaan (Request $request)
    {
      $id = $request->input('id_kenderaan');
      $data = Kenderaan::join('emanagement.lkp_jenis_kenderaan', 'emanagement.kenderaan.id_jenis', '=', 'emanagement.lkp_jenis_kenderaan.id_jenis_kenderaan')
						->join('emanagement.lkp_model', 'emanagement.kenderaan.id_model', '=', 'emanagement.lkp_model.id_model')
						->join('emanagement.lkp_pemandu', 'emanagement.kenderaan.pemandu', '=', 'emanagement.lkp_pemandu.mykad')
						->where('id_kenderaan', $id)
						->first();


      return response()->json($data);
    }
	
    public function simpan_tindakan(Request $request, $id)
    {
		$data = $request->input();

		// dd($data);
		$permohonanBilik = PermohonanBilik ::where('id_permohonan_bilik', $id)->first();
		
		if ($permohonanBilik->tempah_makan == 1) {
			$rules = [
				// 'tajuk' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
				// 'hp_pemandu_pergi' => 'required_if:status,3',
				'statusTempah' => 'required',
				'statusMakan' => 'required',
				'harga' => 'numeric',
				//'pembekal' => 'required',
			];
		}
		else {
			$rules = [
				// 'tajuk' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
				// 'hp_pemandu_pergi' => 'required_if:status,3',
				'statusTempah' => 'required',
			];
		}
				
			$validator = Validator::make($request->all(),$rules);
			
			if ($validator->fails()) {
				
				$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
				return redirect('tempahanbilik/tindakan/'.$id)->withInput();
				
			} else {
				
				try {

					//CHECK TINDAKAN IF PEGAWAI LAIN SUDAH BUAT TINDAKAN
					$checkTindakan = Tindakan::where('id_permohonan', $id)
									->orderBy('created_by', 'desc')				
									->first();
					if($checkTindakan->id_status_tempah == 3 || $checkTindakan->id_status_tempah == 4) {

						$request->session()->flash('failed',"Tindakan telah dibuat oleh pegawai lain.");
						return redirect('tempahanbilik/butiran/'.$id)->withInput();
					}
					else {
						$tindakan = new Tindakan; 
						//$users->id_pengguna = $data['id_pengguna'];
						$tindakan->id_permohonan = $id;
						$tindakan->catatan = $data['catatan'];
						$tindakan->id_status_tempah = $data['statusTempah'];
						if ($permohonanBilik->tempah_makan == 1) {
							$tindakan->id_status_makan = $data['statusMakan'];
						}	
						else {
							$tindakan->id_status_makan = 0;
						}			
						$tindakan->peg_penyelia = Auth::User()->mykad;
						$tindakan->updated_by = Carbon\Carbon::now();
						$tindakan->created_by = Carbon\Carbon::now();
						$tindakan->save();
						
						if ($permohonanBilik->tempah_makan == 1) {
							PermohonanBilik ::where('id_permohonan_bilik', $id)
									->update([
										'id_status' => $data['statusTempah'],
										'updated_at' => Carbon\Carbon::now(),
									]);

							TempahMakan ::where('id_permohonan_bilik', $id)
									->update([
										'kadar_harga' => $data['harga'],
										'pembekal' => $data['pembekal'],
										'updated_at' => Carbon\Carbon::now(),
									]);
						}
						else {
							PermohonanBilik ::where('id_permohonan_bilik', $id)
									->update([
										'id_status' => $data['statusTempah'],
										'updated_at' => Carbon\Carbon::now(),
									]);
						}	
					}

					
					
					//EMEL
					$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
												->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
												->where('permohonan_bilik.id_permohonan_bilik', $id)
												->first();
					//return $contentEmel;
					//dd($contentEmel);
					$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
					// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem
			
					// HANTAR EMEL KEPADA PEMOHON
					// Mail::send('emailbilik/statusPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
					// {
					// 	$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
					// 	//$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
					// 	$header->to('azhim@perpaduan.gov.my', 'azhim');
					// 	$header->bcc('ariefazhim@gmail.com', 'ajim');
					// 	// foreach($pentadbirs as $pentadbir)
					// 	// {
					// 	// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					// 	// }
			
					// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
					// 	$header->subject('Test Dev: Notifikasi Status Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
					// });
					
					$request->session()->flash('status', 'Maklumat tindakan berjaya disimpan.');
					return redirect('tempahanbilik/butiran/'.$id);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Maklumat tindakan tidak berjaya disimpan.');
					return redirect('tempahanbilik/tindakan/'.$id)->withInput();
				}
			}
				
    }

	public function kemaskini_tindakan($id)
    {
		$tindakan  = Tindakan::where(['id_tindakan'=>$id])
								->first();
		$permohonanBilik  = PermohonanBilik::where(['id_permohonan_bilik'=>$tindakan->id_permohonan])->first();
		$optStatuss = LkpStatus::whereIn('id_status', ['3', '4', '5'])->get();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $tindakan->id_permohonan])->first();
		$katerers = LkpKaterer :: get();
		
		$menuMakans = MenuMakan::where('id_tempah_makan', $tempahMakans->id_tempah_makan)->get();
						
		return view('tempahanbilik.kemaskini_tindakan', compact('tindakan', 'optStatuss', 'tempahMakans', 'katerers', 'menuMakans', 'permohonanBilik'));
    }
	
    public function simpan_kemaskini_tindakan(Request $request, $id)
    {
		$data = $request->input();

		$id_tindakan = Tindakan:: where('id_tindakan', $id)->first();
		$permohonanBilik = PermohonanBilik ::where('id_permohonan_bilik', $id_tindakan->id_permohonan)->first();
		
		if ($permohonanBilik->tempah_makan == 1) {
			$rules = [
				// 'tajuk' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
				// 'hp_pemandu_pergi' => 'required_if:status,3',
				'statusTempah' => 'required',
				'statusMakan' => 'required',
				'harga' => 'required|int',
				'pembekal' => 'required',
			];
		}
		else {
			$rules = [
				// 'tajuk' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
				// 'hp_pemandu_pergi' => 'required_if:status,3',
				'statusTempah' => 'required',
			];
		}
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('tempahanbilik/kemaskini_tindakan/'.$id)->withInput();
			
		} 
		else {
			
			try {

				Tindakan ::where('id_tindakan', $id_tindakan->id_tindakan)
								->update([
									'catatan' => $data['catatan'],
									'id_status_tempah' => $data['statusTempah'],
									'id_status_makan' => $data['statusMakan'],
									'updated_by' => Carbon\Carbon::now(),
								]);
				
					if ($permohonanBilik->tempah_makan == 1) {
						PermohonanBilik ::where('id_permohonan_bilik', $id_tindakan->id_permohonan)
								->update([
									'id_status' => $data['statusTempah'],
									'updated_at' => Carbon\Carbon::now(),
								]);

						TempahMakan ::where('id_permohonan_bilik', $id_tindakan->id_permohonan)
								->update([
									'kadar_harga' => $data['harga'],
									'pembekal' => $data['pembekal'],
									'updated_at' => Carbon\Carbon::now(),
								]);
					}
					else {
						PermohonanBilik ::where('id_permohonan_bilik', $id_tindakan->id_permohonan)
								->update([
									'id_status' => $data['statusTempah'],
									'updated_at' => Carbon\Carbon::now(),
								]);
					}
				
				// dd($contentEmel);
				$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
				// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem

				//HANTAR EMEL KEPADA PEMOHON
				// Mail::send('email/statusPemohonKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				// {
				// 	$header->from('no_reply@perpaduan.gov.my', '[DEV] Sistem eTempahan');
				// 	$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
				// 	// foreach($pentadbirs as $pentadbir)
				// 	// {
				// 	// 	$header->cc($pentadbir->email,$pentadbir->nama);	
				// 	// }
					
				// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 	$header->subject('PERKARA: [Kemaskini] Notifikasi Status Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara');
				// });

                // if ($tindakan->id_status_tempah==3){

				// 	//HANTAR EMEL KEPADA PEMANDU
				// 	// jika pemandu pergi sahaja (perjalanan pergi sahaja)
				// 	if($contentEmel->id_jenis_perjalanan==1){

				// 		$pemandu=LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
				// 							->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
				// 							->first();

				// 		Mail::send('email/statusPemanduKenderaanPergi', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemandu)
				// 		{
				// 			$header->from('no_reply@perpaduan.gov.my', '[DEV] Sistem eTempahan');
				// 			$header->to('asnidamj@perpaduan.gov.my', $pemandu->email); //test
				// 			// foreach($pemandus as $pemandu)
				// 			// {
				// 			// 	$header->to($pemandu->email,$pemandu->nama_pemandu);	
				// 			// }
							
				// 			// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 			$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
				// 		});
				// 	}else{
				// 		if($tindakan->kenderaan_pergi==$tindakan->kenderaan_balik){

				// 			$pemandus = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
				// 						->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
				// 						->orwhere('kenderaan.id_kenderaan',$tindakan->kenderaan_balik)
				// 						->get();

				// 			// jika pemandu pergi=pemandu balik
				// 			Mail::send('email/statusPemanduKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemandus)
				// 			{
				// 				$header->from('no_reply@perpaduan.gov.my', '[DEV] Sistem eTempahan');
				// 				// $header->to('asnidamj@perpaduan.gov.my', 'pemandu'); 
				// 				foreach($pemandus as $pemandu)
				// 				{
				// 					$header->to('asnidamj@perpaduan.gov.my',$pemandu->nama_pemandu);	
				// 				}
								
				// 				// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 				$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
				// 			});	
				// 		}else{
				// 			// jika pemandu pergi != pemandu balik
				// 			$pemanduP = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
				// 						->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
				// 						->first();

				// 			$pemanduB = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
				// 						->where('kenderaan.id_kenderaan',$tindakan->kenderaan_balik)
				// 						->first();

				// 				// emel pemandu pergi
				// 			Mail::send('email/statusPemanduKenderaanPergi', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemanduP)
				// 			{
				// 				$header->from('no_reply@perpaduan.gov.my', '[DEV] Sistem eTempahan');
				// 				$header->to('asnidamj@perpaduan.gov.my', $pemanduP->email); //test
								
				// 				// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 				$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
				// 			});
							
				// 				//emel pemandu balik
				// 				Mail::send('email/statusPemanduKenderaanBalik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemanduB)
				// 			{
				// 				$header->from('no_reply@perpaduan.gov.my', '[DEV] Sistem eTempahan');
				// 				$header->to('asnidamj@perpaduan.gov.my', $pemanduB->email); //test
								
				// 				// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 				$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
				// 			});
							
				// 		}
				// 	}
				// }
			
				
				$request->session()->flash('status', 'Maklumat tindakan berjaya disimpan.');
				return redirect('tempahanbilik/butiran/'.$id_tindakan->id_permohonan);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat tindakan tidak berjaya disimpan.');
				return redirect('tempahanbilik/kemaskini_tindakan/'.$id);
			}
			
		}

    }

	public function butiran_tindakan($id)
    {
        // $permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// // dd($permohonanKenderaan);
		// $id_pemohon = $permohonanKenderaan->id_pemohon;
		// $pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();

		$personels = PPersonel:: get();
		$tindakan  = Tindakan::where(['id_tindakan'=>$id])
								->first();
		$katerers = LkpKaterer::get();
		$tempahMakans = TempahMakan::where ('id_tempah_makan', $tindakan->id_permohonan)->first();
						
		return view('tempahanbilik.butiran_tindakan', compact('tindakan', 'personels', 'tempahMakans', 'katerers'));
    }

	public function cetak_butiran($id) {

		$permohonanBiliks = PermohonanBilik::where('id_permohonan_bilik', $id)->first();

		// $pemohon = Pemohon::where('id_pemohon', $permohonanBiliks->id_pemohon)->first();
		//UBAH CARI PERSONEL
		$cariPemohon = Pemohon::where('id_pemohon', $permohonanBiliks->id_pemohon)->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$OptBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
					->where('id_bilik',$permohonanBiliks->id_bilik)
					->first();
		$optStatuss = LkpStatus::whereIn('id_status', ['3', '4', '5'])->get();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$menuMakans  = MenuMakan::where(['id_tempah_makan' => $tempahMakans->id_tempah_makan])->get();
		$katerers = LkpKaterer:: get();
		$personels = PPersonel:: get();
		$tindakanStatus =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by', 'desc')->first();

		return view('tempahanbilik.cetakButiran', compact('permohonanBiliks', 'pemohon', 'OptBiliks', 'tempahMakans', 'menuMakans', 'personels', 'tindakanStatus', 'katerers'));
	}

	public function cetak($id){

        $permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// dd($permohonanKenderaan);
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();

		$tindakan  = Tindakan::where(['id_permohonan'=>$id])
								->whereIn('id_status_tempah', [3, 4, 5]) //lulus
								->orderBy('created_by', 'desc')
								->first();

		if(isset($tindakan)) {
			$kenderaanPergi = Kenderaan::join ('emanagement.lkp_jenis_kenderaan', 'emanagement.kenderaan.id_jenis', '=', 'emanagement.lkp_jenis_kenderaan.id_jenis_kenderaan')
								->join('emanagement.lkp_model','emanagement.kenderaan.id_model','=','emanagement.lkp_model.id_model')
								->join('emanagement.lkp_pemandu','emanagement.kenderaan.pemandu','=','emanagement.lkp_pemandu.mykad')
								->where('id_kenderaan',$tindakan->kenderaan_pergi)
								->first();

			$kenderaanBalik = Kenderaan::join ('emanagement.lkp_jenis_kenderaan', 'emanagement.kenderaan.id_jenis', '=', 'emanagement.lkp_jenis_kenderaan.id_jenis_kenderaan')
								->join('emanagement.lkp_model','emanagement.kenderaan.id_model','=','emanagement.lkp_model.id_model')
								->join('emanagement.lkp_pemandu','emanagement.kenderaan.pemandu','=','emanagement.lkp_pemandu.mykad')
								->where('id_kenderaan',$tindakan->kenderaan_balik)
								->first();

		} else {

			$kenderaanPergi = [];
			$kenderaanBalik = [];
			$tindakan  = Tindakan::where(['id_permohonan'=>$id])
								->where('id_status_tempah', 5) //semak semula
								->first();
		}

		// dd($tindakan)

		$tindakans =  Tindakan::where(['id_permohonan'=>$id])->orderBy('created_by')->get();

        $pdf = PDF::loadView('tempahankenderaan.pdf', compact('permohonanKenderaan','pemohon','tindakan','kenderaanPergi','kenderaanBalik','tindakans'));

        return $pdf->stream($permohonanKenderaan->kod_permohonan.".pdf");
    }
}
