<?php

namespace App\Http\Controllers;

use App\User;
use App\Event;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use App\LkpAccess;
use App\LkpJenisKenderaan;
use App\LkpModel;
use App\LkpPemandu;
use App\LkpBilik;
use App\LkpJenisPerjalanan;
use App\LkpTujuan;
use App\LkpStatus;
use App\Penilaian;
use App\LkpSoalan;
use App\PermohonanKenderaan;
use App\Pemohon;
use App\Kenderaan;
use App\LkpKaterer;
use App\MenuMakan;
use App\Tindakan;
use App\Penumpang;
use App\PermohonanBilik;
use App\RLkpNegeri;
use App\TempahMakan;
use Carbon;
use Auth;
use Illuminate\Http\Request;


class FullCalendarController extends Controller
{

    // public function index(Request $request)
    // {
    //     //test debug page
    //     $calendar = array();
    //     $events = Event::all();
    //     foreach($events as $event) {
    //         $calendar[] = [
    //             'id' => $event->id,
    //             'title' => $event->title,
    //             'start' => $event->start,
    //             'end' => $event->end,
    //         ];
    //     }

    //     return view('pemohon.fullcalendar', compact('calendar'));
    // }

    public function butiran_bilikcalendar(Request $request)
	{
        $id = $request->input('idEvent');
		//check if user punya event if yes boleh edit
        $idPemohon = $request->input('idPemohon');

		$permohonanBiliks  = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		// dd($permohonanBilik);
		$id_pemohon = $permohonanBiliks->id_pemohon;
		
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

		$personels = PPersonel::get();
		$tindakans =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by')->get();
		$tindakanStatus =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by', 'desc')->first();


		return view('pemohonbilik.butirantempahbilik', compact('permohonanBiliks','personels', 'pemohon', 'optStatuss', 'tempahMakans', 'menuMakans', 'OptBiliks', 'idPemohon', 'tindakans', 'tindakanStatus'));	
	}

    public function butiran_bilikcalendar_admin(Request $request)
	{
        $id = $request->input('idEvent');
		$kalendar = 'yes'; //variable untuk ke butiran, bagitau yang butiran dari kalendar

		$permohonanBilik  = PermohonanBilik::where(['id_permohonan_bilik' => $id])->first();
		// dd($permohonanBilik);
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

		//bila admin view first time change to Dalam proses
		$tindakanFirst =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->latest('created_by')->first();
		//return $tindakanFirst;	
		if ( isset($tindakanFirst) ) {
			if ($tindakanFirst->id_status_tempah != 2 && $tindakanFirst->id_status_tempah != 3 && $tindakanFirst->id_status_tempah != 6 && $tindakanFirst->id_status_tempah != 4
		      && $tindakanFirst->id_status_tempah != 5 && Auth::User()->id_access != 4) {

				PermohonanBilik::where('id_permohonan_bilik', $id)->update([
					'id_status' => 2, //status dalam proses
					'updated_at' => Carbon\Carbon ::now()
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

		$personels = PPersonel::get();
		$tindakans =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by')->get();
		$tindakanStatus =  Tindakan::where(['id_permohonan' => $id])->where('id_status_makan', '!=', null)->orderBy('created_by', 'desc')->first();


		return view('tempahanbilik.butiran', compact('permohonanBilik','personels', 'pemohon', 'optStatuss', 'tempahMakans', 'menuMakans', 'OptBiliks', 'katerers', 'tindakans', 'tindakanStatus', 'kalendar'));	
	}
}
