<?php

namespace App\Http\Controllers;

use App\User;
use App\PPersonel;
use App\PLkpBahagian;
use App\LkpBilik;
use App\LkpJenisPerjalanan;
use App\LkpTujuan;
use App\LkpStatus;
use App\PermohonanKenderaan;
use App\Pemohon;
use App\LkpJenisHidangan;
use App\MenuMakan;
use App\Tindakan;
use App\PermohonanBilik;
use App\RLkpNegeri;
use App\TempahMakan;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Auth;
use Carbon\Carbon as CarbonCarbon;
use DateTime;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PemohonBilikController extends Controller
{

	public function cariBilik (Request $request) {
		$aras = $request->input('aras');
     	$data = LkpBilik::where('aras',$aras)
                          ->orderBy('id_bilik')
                          ->get();

      	return response()->json($data);

	}

	//TEMPAHAN BILIK FUNCTIONS
	public function tambah_tempahanbilik(Request $request, $search)
	{
		$data = $request->input();

		$result = PPersonel::select('pegawais.*')->where('nokp', $search)->first();
		$pemohon = Pemohon::where('mykad', $search)->first();
		//calendar
		$calendar = array();
		//$events = PermohonanBilik::where('id_pemohon', $pemohon->id_pemohon)->get();
		$events = PermohonanBilik::get();

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
					// if ($data['cariAras'] == $bilik->aras && $data['cariBilik'] == $bilik->id_bilik && $status->id_status != 6 && $status->id_status != 4) {
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
					// if ($data['cariAras'] == $bilik->aras && $status->id_status != 6 && $status->id_status != 4) {
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
		// $optBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
		// 		->get();
		$optBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
							->where('id_bilik', '!=', '27')
							->where('id_bilik', '!=', '28')
							->get();

		if ($request->input() != null ) {
			session()->flashInput($request->input());
		}

		return view('pemohonbilik.developing', compact('result', 'calendar', 'pemohon', 'optBiliks'));
	}

	public function tambah_bilik($id)
	{
		$result = PPersonel::where('nokp', $id)->first();
		$pemohon = Pemohon:: where('mykad', $id)->first();
		$pengerusi = PPersonel:: where('gred', 'LIKE', '%' . "41" . '%')
								->where('stat_pegawai', '!=', 0)
								->orWhere('gred', 'LIKE', '%' . "44" . '%')
								->orWhere('gred', 'LIKE', '%' . "48" . '%')
								->orWhere('gred', 'LIKE', '%' . "52" . '%')
								->orWhere('gred', 'LIKE', '%' . "54" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS I" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS II" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS III" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "Timbalan Menteri" . '%')
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
							->where('id_bilik', '!=', '27')
							->where('id_bilik', '!=', '28')
							->get();

		return view('pemohonbilik.tempahanbilik', compact('OptBilik','result','pengerusi' , 'optJenisPerjalanans', 'optTujuans', 'optBahagians', 'optJenisHidangans', 'pemohon'));
	}

	public function simpan_bilik(Request $request, $nokp)
	{
		$data = $request->input();
		$result = PPersonel::where('nokp', $nokp)->first();

		//validate input

		//Check tarikh: to make sure tarikh tamat tak kurang dari tarikh mula
		$datetime1 =  new DateTime($data['tkh_mula']);
		$datetime2 =  new DateTime($data['tkh_hingga']);
		if ($datetime1 > $datetime2 ) {
			$request->session()->flash('failed', "Sila pastikan tarikh telah dimasukkan dengan betul");
			$request->session()->flash('failMakan', "Display input waktu makanan");
			$request->session()->flash('tatacara', "No display input tatacara");
			return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
		}

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
				$request->session()->flash('tatacara', "No display input tatacara");
				return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
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
						$request->session()->flash('tatacara', "No display input tatacara");
						return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
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


		if ( $diff->format("%a") >= 1 ) { //if pemohon mohon 1hari atau lebih sebelum tarikh booking

			if( $data['hidangan-radio'] == '1') {

				if ( $diff->format("%a") >= 2 ) { //if pemohon mohon 2 hari atau lebih sebelum tarikh booking
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
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
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
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('failMakan', "Display input waktu makanan");
										$request->session()->flash('tatacara', "No display input tatacara");
										return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
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
				else {
					$request->session()->flash('failed', 'Permohonan tempah makanan perlu ditempah 48 jam sebelum hari mesyuarat.');
					$request->session()->flash('failMakan', "Display input waktu makanan.");
					$request->session()->flash('tatacara', "No display input tatacara");
					return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
				}
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
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
								}
								if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
								}
								if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
								}
								if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
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
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
								}
								if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
								}
								if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
								}
								if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
									$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
									$request->session()->flash('failMakan', "Display input waktu makanan");
									$request->session()->flash('tatacara', "No display input tatacara");
									return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
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

		}
		else {
			$request->session()->flash('failed', 'Permohonan perlu ditempah 24 jam sebelum hari mesyuarat.');
			$request->session()->flash('tatacara', "No display input tatacara");
			if ($data['hidangan-radio'] == '1') {
				$request->session()->flash('failMakan', "Display input waktu makanan");
			}
			else {
				$request->session()->flash('noMakanan', "Disable input waktu makanan");
			}
			return redirect('/pemohon/tempahanbilik/tambah_bilik/' . $nokp)->withInput();
		}



		//If Bilik Tidak Diguna
		if ($validateEnd == 'End' && $notAvailable == 'bilik_tidak_diguna') {
			// kod V2021/00001
			// $jumlah = PermohonanKenderaan::max('id_maklumat_permohonan');
			$jumlah = PermohonanBilik::whereYear('created_at', '=', Carbon\Carbon::now()->format('Y'))->max('id_permohonan_bilik');
			$jumPK = str_pad($jumlah + 1, 5, '0', STR_PAD_LEFT);
			$kod_permohonand = 'B' . Carbon\Carbon::now()->format('Y') . '/' . $jumPK;

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

				return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);
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
				$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
											->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
											->where('permohonan_bilik.id_permohonan_bilik', $id_permohonan)
											->first();
				//return $contentEmel;
				//dd($contentEmel);
				$pentadbirs=User::where('id_access', 3)
								->where('status_akaun', '!=', 10)
								->get(); //pentadbir sistem
				// $pentadbirs=User::where('mykad','810714035470') //Noraini  //pentadbir sistem
				// 				->Orwhere('mykad','881015115517') //Aiman
				// 				->Orwhere('mykad','860727565409') //Idham
				// 				->get();

				//HANTAR EMEL KEPADA PEMOHON
				Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				{
					$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
					$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
					// $header->to('azhim@perpaduan.gov.my', 'azhim');
					// $header->bcc('azhim@perpaduan.gov.my', 'azhim');
					foreach($pentadbirs as $pentadbir)
					{
						$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					}

					// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
					$header->subject('PERKARA: Notifikasi Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
				});

				//Pass id tuk checking if current user boleh kemaskini
				$id = $bilik->id_permohonan_bilik;
				$idPemohon = $bilik->id_pemohon;

				$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
				return redirect('/pemohon/tempahanbilik/butiran/' . $id .'/' .$idPemohon);
			}
		}

	}

	public function butiran_tempahanbilik($id, $id2)
	{
		// $id = id_permohonan_bilik ; $id2 = id_pemohon
		$idPemohon = $id2;

		$permohonanBiliks  = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		// dd($permohonanBilik);
		$id_pemohon = $permohonanBiliks->id_pemohon;

		// $pemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		//UBAH CARI PERSONEL
		$cariPemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$OptBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
					->where('id_bilik',$permohonanBiliks->id_bilik)
					->first();
		$optStatuss = LkpStatus::whereIn('id_status', ['3', '4', '5'])->get();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$menuMakans  = MenuMakan::where(['id_tempah_makan' => $tempahMakans->id_tempah_makan])->get();

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

		//tindakan for tempahan bilik
		$personels = PPersonel:: get();
		$tindakans =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by')->get();
		$tindakanStatus =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by', 'desc')->first();
		//return $tindakanStatus;

		return view('pemohonbilik.butirantempahbilik', compact('permohonanBiliks', 'personels', 'pemohon', 'cariPemohon', 'optStatuss', 'tempahMakans', 'menuMakans', 'OptBiliks', 'idPemohon', 'tindakans', 'tindakanStatus', 'cariPemohon'));
	}

	public function kemaskini_tempahanbilik($id)
	{
		$optTujuans = LkpTujuan::where('id_tujuan', '!=', '6')
								->where('id_tujuan', '!=', '7')
								->get();
		$permohonanBiliks = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		$pengerusi = PPersonel:: where('gred', 'LIKE', '%' . "41" . '%')
								->where('stat_pegawai', '!=', 0)
								->orWhere('gred', 'LIKE', '%' . "44" . '%')
								->orWhere('gred', 'LIKE', '%' . "48" . '%')
								->orWhere('gred', 'LIKE', '%' . "52" . '%')
								->orWhere('gred', 'LIKE', '%' . "54" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "JUSA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS I" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS II" . '%')
								->orWhere('gred', 'LIKE', '%' . "TURUS III" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA A" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA B" . '%')
								->orWhere('gred', 'LIKE', '%' . "UTAMA C" . '%')
								->orWhere('gred', 'LIKE', '%' . "Timbalan Menteri" . '%')
								->orWhere('gred', 'LIKE', '%' . "Menteri" . '%')
								->orWhere('gred', 'LIKE', '%' . "MENTERI" . '%')
								->orderBy('name', 'asc')
								->get();
		$id_pemohon = $permohonanBiliks->id_pemohon;

		// $pemohon = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		//UBAH CARI PERSONEL
		$cariPemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$optBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
							->where('id_bilik', '!=', '27')
							->where('id_bilik', '!=', '28')
							->get();
		$tempahMakans = TempahMakan::where(['id_permohonan_bilik' => $id])->first();

		return view('pemohonbilik.kemaskinitempahbilik', compact('permohonanBiliks', 'pemohon', 'optTujuans', 'optBiliks', 'tempahMakans', 'pengerusi', 'cariPemohon'));
	}

	public function simpanK_tempahanbilik(Request $request, $id)
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
				return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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
						return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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
		// $checkBilikS = PermohonanBilik::get();
		$checkBilikS = PermohonanBilik::where('id_status', '!=', 4)
		->where('id_status', '!=', 6)
		->get();
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

		if ( $diff->format("%a") >= 1 ) { //if pemohon mohon 1hari atau lebih sebelum tarikh booking
			if( $data['hidangan-radio'] == '1') {
				if ( $diff->format("%a") >= 2 ) { //if pemohon mohon 2 hari atau lebih sebelum tarikh booking
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
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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
				}
				else {
					$request->session()->flash('failed', 'Permohonan tempah makanan perlu ditempah 48 jam sebelum hari mesyuarat.');
					$request->session()->flash('failMakan', "Display input waktu makanan.");
					$request->session()->flash('noMakanan', "Disable input waktu makanan");
					return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
				}
			}
			else { //boleh kemaskini
				if ( $checkBilikS ) { //check if data ada atau kosong
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
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_mula'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($Inputmasa2->between($masa_mula, $masa_hingga)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_mula->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
									}
									if ($masa_hingga->between($Inputmasa1, $Inputmasa2)) {
										$request->session()->flash('failed', 'Bilik diguna pada tarikh '. $data['tkh_hingga'] . ' & masa '. $masa1Convert . ' hingga '.$masa2Convert);
										$request->session()->flash('noMakanan', "Disable input waktu makanan");
										return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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
				}
				else { //if dalam data first time insert
					$notAvailable = 'bilik_tidak_diguna';
					$validateEnd = 'End';
				}
			}
		}
		else {
			$request->session()->flash('failed', 'Permohonan perlu ditempah 24 jam sebelum hari mesyuarat.');
			if ($data['hidangan-radio'] == '1') {
				$request->session()->flash('failMakan', "Display input waktu makanan");
			}
			else {
				$request->session()->flash('noMakanan', "Disable input waktu makanan");
			}
			return redirect('/pemohon/tempahanbilik/kemaskini/' . $id)->withInput();
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

					//check radio button makanan ada or not
					// if (isset($data['hidangan-radio'])) {
					// 	$radio =  $data["hidangan-radio"];
					// }else {
					// 	$radio = '2';
					// }

			PermohonanBilik::where('id_permohonan_bilik', $id)->update([
				'id_tujuan' => $data['id_tujuan'],
				'nama_tujuan' => $data['nama_tujuan'],
				'tkh_mula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
				'tkh_hingga' => Carbon\Carbon::parse($data['tkh_hingga'])->format('Y-m-d'),
				'masa_mula' => Carbon\Carbon::parse($data['masa_mula'])->format('H:i:s'),
				'masa_hingga' => Carbon\Carbon::parse($data['masa_hingga'])->format('H:i:s'),
				'id_bilik' => $data['id_bilik'],
				'tempah_makan' => $data['hidangan-radio'],
				//'tempah_makan' => $radio,
				'bil_peserta' =>  $data['jumlah_pegawai'],
				'nama_pengerusi' => $data['nama_pengerusi'],
				'id_status' => 1, //status kemaskini
				'updated_at' => Carbon\Carbon::now()
			]);

			if (isset($data['hidangan-radio']) && $data['hidangan-radio'] == 1){
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

				return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);

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
					//update tindakan
					// $tindakan = new Tindakan;
					// $tindakan->id_permohonan = $id;
					// $tindakan->id_status_tempah = 2;
					// $tindakan->id_status_makan = 2;
					// $tindakan->peg_penyelia = $idpemohon->mykad;
					// $tindakan->updated_by = Carbon\Carbon::now();
					// $tindakan->created_by = Carbon\Carbon::now();
					// $tindakan->save();

					//EMEL KEMASKINI
					$contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
												->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
												->where('permohonan_bilik.id_permohonan_bilik', $id)
												->first();
					//return $contentEmel;
					//dd($contentEmel);
					$pentadbirs=User::where('id_access','1')->get(); //pentadbir sistem
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
					return redirect('/pemohon/tempahanbilik/butiran/' . $id .'/' .$idPemohon);
				}
				else {
					//permohonan baru tindakan
					$tindakan = new Tindakan;
					$tindakan->id_permohonan = $id;
					$tindakan->id_status_tempah = 1;
					$tindakan->id_status_makan = 1;
					$tindakan->peg_penyelia = $pemohon->mykad;
					$tindakan->updated_by = Carbon\Carbon::now();
					$tindakan->created_by = Carbon\Carbon::now();
					$tindakan->save();

					$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
					return redirect('/pemohon/tempahanbilik/butiran/' . $id .'/' .$idPemohon);
				}

				// $request->session()->flash('status', 'Maklumat Tempahan berjaya disimpan.');
				// return redirect('/pemohon/tempahanbilik/butiran/' . $id .'/' .$idPemohon);
			}
		}

	}

	public function batal_tempahanbilik($id)
	{
		// $permohonanBiliks  = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		// // dd($permohonanBilik);
		// $id_pemohon = $permohonanBiliks->id_pemohon;
		// $pemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		// $tempahMakan  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$personels = PPersonel::get();
		$permohonanBiliks  = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		// dd($permohonanBilik);
		$id_pemohon = $permohonanBiliks->id_pemohon;

		// $pemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		//UBAH CARI PERSONEL
		$cariPemohon  = Pemohon::where(['id_pemohon' => $id_pemohon])->first();
		$pemohon  = PPersonel::where('nokp',$cariPemohon->mykad)->first();

		$OptBiliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
					->where('id_bilik',$permohonanBiliks->id_bilik)
					->first();
		$optStatuss = LkpStatus::whereIn('id_status', ['3', '4', '5'])->get();
		$tempahMakans  = TempahMakan::where(['id_permohonan_bilik' => $id])->first();
		$menuMakans  = MenuMakan::where(['id_tempah_makan' => $tempahMakans->id_tempah_makan])->get();

		//Kire total kalori pagi, tengahari & petang
		$Kpagi = 0;
		$Ktengahari = 0;
		$Kpetang = 0;
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
			}
		};

		TempahMakan::where('id_permohonan_bilik', $id)->update([
			'kalori_pagi' => $Kpagi,
			'kalori_tengahari' => $Ktengahari,
			'kalori_petang' => $Kpetang,
		]);

		return view('pemohonbilik.bataltempahbilik', compact('permohonanBiliks','personels', 'pemohon', 'optStatuss', 'tempahMakans', 'menuMakans', 'OptBiliks'));
		//return view('pemohon.bataltempahbilik', compact('pemohon', 'permohonanBiliks', 'tempahMakan'));
	}

	public function simpanb_tempahanbilik(Request $request, $id)
	{
		$data = $request->input();
		$rules = [
			'catatanBatal' => 'required'
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			$request->session()->flash('failed', "Sila berikan alasan pembatalan.");
			return redirect('/pemohon/tempahanbilik/batal/' . $id)->withInput();
		}

		PermohonanBilik::where('id_permohonan_bilik', $id)->update([
			'id_status' => 6,
			'updated_at' => Carbon\Carbon::now(),
		]);

		$permohonanBilik = PermohonanBilik::where('id_permohonan_bilik', $id)->first();
		$pemohon = Pemohon::where('id_pemohon', $permohonanBilik->id_pemohon)->first();
		$personel = PPersonel::where('nokp', $pemohon->mykad)->first();

		if ($pemohon) {
			$id_pemohon = $pemohon->id_pemohon;
			$permohonanKenderaans = PermohonanKenderaan::where('id_pemohon', $id_pemohon)->orderBy('created_by', 'desc')->get();
		} else {
			$pemohon = PPersonel::where('nokp', $pemohon->mykad)->first();
			$permohonanKenderaans = [];
		}

		if ($pemohon) {
			$id_pemohon = $pemohon->id_pemohon;
			$permohonanBiliks = PermohonanBilik::where('id_pemohon', $id_pemohon)->orderBy('created_at', 'desc')->get();
		} else {
			$pemohon = PPersonel::where('nokp', $pemohon->mykad)->first();
			$permohonanBiliks = [];
		}

		$tindakan = new Tindakan;
		$tindakan->id_permohonan = $id;
		$tindakan->id_status_tempah = 6;
		$tindakan->id_status_makan = 6;
		$tindakan->catatan = $data['catatanBatal']; //catatan alasan batal
		$tindakan->peg_penyelia = Pemohon::where('id_pemohon', $id_pemohon)->first()->mykad;
		$tindakan->updated_by = Carbon\Carbon::now();
		$tindakan->created_by = Carbon\Carbon::now();
		$tindakan->save();

		//EMEL BATAL
        $contentEmel=PermohonanBilik:: join('tempah_makan','permohonan_bilik.id_permohonan_bilik', '=','tempah_makan.id_permohonan_bilik')
                                    ->join('pemohon','pemohon.id_pemohon', '=','permohonan_bilik.id_pemohon')
                                    ->where('permohonan_bilik.id_permohonan_bilik', $id)
                                    ->first();
        //return $contentEmel;
        //dd($contentEmel);
        $pentadbirs=User::where('id_access','1')->get(); //pentadbir sistem
		// $pentadbirs=User::where('mykad','810714035470')->get(); //pentadbir sistem

        //HANTAR EMEL KEPADA PEMOHON
        // Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
        // Mail::send('emailbilik/statusPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
        // {
        //     $header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
        //     //$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
        //     $header->to('azhim@perpaduan.gov.my', 'azhim');
        //     // foreach($pentadbirs as $pentadbir)
        //     // {
        //     // 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
        //     // }

        //     // SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
        //     $header->subject('PERKARA: Notifikasi Status Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
        // });

		$request->session()->flash('status', 'Tempahan bilik berjaya dibatalkan.');
		return view('pemohon.semak', compact('permohonanKenderaans', 'pemohon', 'permohonanBiliks', 'personel'));
	}

	public function lihat_bilik(Request $request)
	{
		$biliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
							->where('id_bilik', '!=', '27')
							->where('id_bilik', '!=', '28')
							->get();

		if(isset($_POST['tapis_bilik'])) {

			$data = $request->input();

			if (isset($data['pilihAras'])) {
				if(strlen($data['pilihAras']) > 0) { $biliks = $biliks->where('aras',$data['pilihAras']); }
			}

			return view('pemohonbilik.lihatmaklumatbilik',compact('biliks'));
		}

		return view('pemohonbilik.lihatmaklumatbilik', compact('biliks'));
	}

	public function tambah_makanan(Request $request, $id) {
		$optJenisHidangans = LkpJenisHidangan::get();
		$tempahmakan = TempahMakan::where('id_tempah_makan', $id)->first();
		$menumakan = MenuMakan::where('id_tempah_makan', $id)->get();

		return view('pemohonbilik.tempahanmakanan', compact('menumakan', 'tempahmakan', 'optJenisHidangans'));
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
				return redirect('/pemohon/tempahanbilik/tambah_makanan/' . $id)->withInput();
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

				return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);
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
				return redirect('/pemohon/tempahanbilik/tambah_makanan/' . $id)->withInput();
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

				return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);
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
				return redirect('/pemohon/tempahanbilik/tambah_makanan/' . $id)->withInput();
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

				return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);
			}

		}
		else if(isset($_POST['makanmalam'])){

			$rules = [
				'input_malam' => 'required',
				'kalori_malam' => 'required|int',
				'id_jenis_hidangan4' => 'required',
			];

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				$request->session()->flash('failed', "Sila pastikan anda masukkan menu makan malam dengan betul.");
				return redirect('/pemohon/tempahanbilik/tambah_makanan/' . $id)->withInput();
			} else {
				$menumakan->id_tempah_makan = $id;
				$menumakan->menu = $data['input_malam'];
				$menumakan->kalori = $data['kalori_malam'];
				$menumakan->jenis_makan = $data['jenis_makan4'];
				$menumakan->save();

				//save jenis hidangan makan malam
				TempahMakan::where('id_tempah_makan', $id)->update([
					'id_jenis_hidangan4' => $data['id_jenis_hidangan4'],
				]);

				return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);
			}

		}
		else if( isset($_POST['edit_makanan']) ){
			// return $menuMakan = MenuMakan::find($data['id_menu_makan']);

			MenuMakan::where('id_menu_makan', $data['id_menu_makan'])->update([
				'menu' => $data['menu_baru'],
				'kalori' =>  $data['kalori_baru'],
			]);

			return redirect('/pemohon/tempahanbilik/tambah_makanan/'.$id);

		}
		else if(isset($_POST['hantar'])) {

			//check if menu makan kosong or not
			$checkMenuMakan = MenuMakan::where('id_tempah_makan', $id)->first();
			if($checkMenuMakan == null) {
				$request->session()->flash('failed', "Sila isi menu makan anda dengan betul. Menu makan tidak boleh ditinggalkan kosong.");
				return redirect('/pemohon/tempahanbilik/tambah_makanan/' . $id)->withInput();
			}

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
				return redirect('/pemohon/tempahanbilik/butiran/' . $id .'/' .$idPemohon);
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

				//EMEL MOHON BARU
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
				// $pentadbirs=User::where('mykad','810714035470') //Noraini //pentadbir sistem
				// 				->Orwhere('mykad','881015115517') //Aiman
				// 				->Orwhere('mykad','860727565409') //Idham
				// 				->get();

				//HANTAR EMEL KEPADA PEMOHON
				Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				// Mail::send('emailbilik/notiPemohonBilik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				{
					$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
					$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
					// $header->to('azhim@perpaduan.gov.my', 'azhim');
					// $header->bcc('azhim@perpaduan.gov.my', 'azhim');
					foreach($pentadbirs as $pentadbir)
					{
						$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					}

					// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
					$header->subject('PERKARA: Notifikasi Permohonan Tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara');
				});

				$request->session()->flash('status', 'Tempahan mesyuarat berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
				return redirect('/pemohon/tempahanbilik/butiran/' . $id .'/' .$idPemohon);
			}

		}

	}

	function hapus_makanan($id){
		$menuMakans = MenuMakan::where('id_menu_makan', $id)->first();
		$tempahmakan = TempahMakan::where('id_tempah_makan', $menuMakans->id_tempah_makan)->first();
		$hapusMenu = MenuMakan::where('id_menu_makan', $id)->delete();
		$menumakan =MenuMakan::where('id_tempah_makan', $tempahmakan->id_tempah_makan)->get();
		$optJenisHidangans = LkpJenisHidangan:: get();

		return view('pemohonbilik.tempahanmakanan', compact('menumakan', 'tempahmakan', 'optJenisHidangans'));
	}

}
