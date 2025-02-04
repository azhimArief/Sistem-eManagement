<?php

namespace App\Http\Controllers;

use App\User;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use App\LkpAccess;
use App\LkpJenisKenderaan;
use App\LkpModel;
use App\LkpPemandu;
use App\LkpJenisPerjalanan;
use App\LkpTujuan;
use App\LkpStatus;
use App\Penilaian;
use App\LkpSoalan;
use App\PermohonanKenderaan;
use App\Pemohon;
use App\Kenderaan;
use App\Tindakan;
use App\Penumpang;
use App\RLkpNegeri;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Auth;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PemohonController extends Controller
{
    public function search(Request $request)
	{
	   // Get the search value from the request
	   $search = $request->input('nokp');
	   $result = PPersonel::select('pegawais.*')->where('nokp', $search)->first();

	   if($result){
		$pemandu =PPersonel::where('nokp', $result->nokp)
			->where('jawatan', 'LIKE', '%' . "pemandu". '%')
			->first();

	   }
							// dd($pemandu);
	

	  return view('layouts.profile', compact('result','pemandu'));
  
  	}

	public function semak($nokp)
    {
		
		$pemohon = Pemohon::where('mykad', $nokp)->first();
		if($pemohon){
			$id_pemohon=$pemohon->id_pemohon;
			$permohonanKenderaans = PermohonanKenderaan::where('id_pemohon', $id_pemohon)->orderBy('created_by','desc')->get();
		}else{
			$pemohon=PPersonel::where('nokp', $nokp)->first();
			$permohonanKenderaans = [];
		}
		// dd($pemohon);
		
        return view('pemohon.semak',compact('permohonanKenderaans','pemohon'));
    }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
	public function tambah_tempahankenderaan($search)
	{

    // $data = $request->input();
    // $personel=PPersonel::where(['nokp'=>$data['mykad']])->first();
    // $result = PPersonel::find($personel['nokp'])->first();
    // $search = $request->input('nokp');
	
	// $pemohon = Pemohon::where('mykad', $search )->first();
	$result = PPersonel::select('pegawais.*')->where('nokp', $search)->first();
    // $result = PPersonel::select('pegawais.*','bahagian.bahagian')
    // ->join('PLkpBahagian', 'pegawais.bahagian_id', '=', 'bahagian.id')
    // ->where('nokp', $search)
    // ->first();

//   dd($result);
	$optJenisPerjalanans = LkpJenisPerjalanan::get();
	$optTujuans = LkpTujuan::get();
	$optBahagians = PLkpBahagian::whereIn('agensi_id',[1,3])->orderBy('bahagian')->get();
	$optNegeris = RLkpNegeri::orderBy('negeri')->get();

    return view('pemohon.tempahkenderaan', compact( 'result','optJenisPerjalanans','optTujuans','optBahagians','optNegeris'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function simpant_tempahankenderaan(Request $request, $nokp)
  {
    // dd($request);

    $data = $request->input();
		// dd($data);

		if($request->hasFile('lampiran')){
			$file = $request->file('lampiran');			
			//echo $file->getClientOriginalExtension(); // = pdf
			//echo $file->getSize()/1024/1024; //to get MB
			//echo $file->getMimeType(); // = application/pdf
			
			if($file->getMimeType()=='application/pdf' && $file->getSize()/1024/1024 > 2) {
				$dokumenIns = 0;
			} else {
				$dokumenIns = 1;
			}
		} else {
			$dokumenIns = 1;
		}

		$rules = [
			// 'mykad' => 'required|string|min:3|max:255'
			'emel' => 'required|string|email|max:255',
			'telefon' => 'required',
			'tel_bimbit' => 'required',
			'jenis_perjalanan' => 'required',
			'id_tujuan' => 'required',
			'tkh_pergi' => 'required',
			'tkh_balik' => 'required_if:jenis_perjalanan,2,3',
			'masa_pergi' => 'required',
			'masa_balik' => 'required_if:jenis_perjalanan,2,3',
      		'id_negeri' => 'required',
			'lokasi_tujuan' => 'required',
			'bil_penumpang' => 'required',
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails() && $dokumenIns==0) {
		
		$request->session()->flash('failed',"Ruangan bertanda * wajib diisi dan dokumen tidak sah.");
		return redirect('pemohon/tempahankenderaan')->withInput();
		
		} elseif ($validator->fails() && $dokumenIns==1) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('pemohon/tempahankenderaan/'.$nokp)->withInput();
			
		} elseif (!$validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed', 'Dokumen tidak sah.');
			return redirect('pemohon/tempahankenderaan/'.$nokp)->withInput();
			
		} else {
			
			try {
				if($request->hasFile('lampiran')) {
					$destinationPath = 'uploads/tempahan';
					$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				} else {
					$path = '';
				}

				// kod V2021/00001
				// $jumlah = PermohonanKenderaan::max('id_maklumat_permohonan');	
				$jumlah = PermohonanKenderaan::whereYear('created_by', '=', Carbon\Carbon::now()->format('Y'))->count('id_maklumat_permohonan');					
				$jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
				$kod_permohonan = 'V'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;

				$pemohon = Pemohon::where('mykad', $nokp)->first();
				
				if(isset($data['emel'])) { $emel = $data['emel']; } else { $emel = ''; }
				if($emel=='') { $emel = $pemohon->emel; }
				if(isset($data['telefon'])) { $telefon = $data['telefon']; } else { $telefon = ''; }
				if($telefon=='') { $telefon = $pemohon->telefon; }
				if(isset( $data['tel_bimbit'])) { $tel_bimbit = $data['tel_bimbit']; } else { $tel_bimbit = ''; }
				if($tel_bimbit=='') { $tel_bimbit = $pemohon->tel_bimbit; }

				if($pemohon=='') {
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

				}else{

					

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
					'email' => $emel,
					'tel' => $telefon,
					'tel_bimbit' => $tel_bimbit,
					'updated_at' => Carbon\Carbon::now(),
				]);

				// $id_pemohon = $pemohon->max('id_pemohon');
				
				$permohonanKenderaan = new PermohonanKenderaan;
				$permohonanKenderaan->id_pemohon = $pemohon->id_pemohon;
				$permohonanKenderaan->kod_permohonan = $kod_permohonan;
				$permohonanKenderaan->id_jenis_perjalanan=$data['jenis_perjalanan'];
				$permohonanKenderaan->tkh_pergi = Carbon\Carbon::parse($data['tkh_pergi'])->format('Y-m-d');
				if(isset($data['tkh_balik']))$permohonanKenderaan->tkh_balik = Carbon\Carbon::parse($data['tkh_balik'])->format('Y-m-d'); else $permohonanKenderaan->tkh_balik = null;
				$permohonanKenderaan->masa_pergi = $data['masa_pergi'];
				$permohonanKenderaan->masa_balik = $data['masa_balik'];
				$permohonanKenderaan->id_tujuan = $data['id_tujuan'];
				$permohonanKenderaan->id_negeri = $data['id_negeri'];
				$permohonanKenderaan->lokasi_tujuan = $data['lokasi_tujuan'];
				$permohonanKenderaan->keterangan_lanjut = $data['nama_tujuan'];
				$permohonanKenderaan->bil_penumpang = $data['bil_penumpang'];
				$permohonanKenderaan->id_status = 1;
				$permohonanKenderaan->lampiran = $path;
				$permohonanKenderaan->updated_by = Carbon\Carbon::now();
				$permohonanKenderaan->created_by = Carbon\Carbon::now();

				$permohonanKenderaan->save();

				$id_permohonan = $permohonanKenderaan->max('id_maklumat_permohonan');
				
				$tindakan = new Tindakan;
				$tindakan->id_permohonan = $id_permohonan;
				$tindakan->id_status_tempah = 1;
				$tindakan->peg_penyelia = $pemohon->mykad;
				$tindakan->updated_by = Carbon\Carbon::now();
				$tindakan->created_by = Carbon\Carbon::now();
				$tindakan->save();

				$expPenumpang = explode('|x|x|', $data['maklumat_penumpang']);
				
				for($mj=0; $mj<count($expPenumpang) - 1; $mj++) {
					$decodeMJ = base64_decode($expPenumpang[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					$penumpang = new Penumpang;
					$penumpang->nama = $expDecodeMJ[4];
					$penumpang->emel = $expDecodeMJ[6];
					$penumpang->no_tel = $expDecodeMJ[5];
					$penumpang->bahagian = $expDecodeMJ[2];
					$penumpang->mykad = $expDecodeMJ[7];
					$penumpang->id_tempahan = $id_permohonan;
					$penumpang->created_at = Carbon\Carbon::now();
					$penumpang->updated_at = Carbon\Carbon::now();
					$penumpang->save();

					PPersonel::where('nokp',$expDecodeMJ[7])->update([
						'email' => $expDecodeMJ[6],
						'tel_bimbit' => $expDecodeMJ[5],
						'updated_at' => Carbon\Carbon::now(),
					]);
				//dd( $decodeMJ);
        		}

				$contentEmel=PermohonanKenderaan::select('permohonan_kenderaan.*','pemohon.nama','pemohon.emel')
												->join('pemohon','permohonan_kenderaan.id_pemohon','pemohon.id_pemohon')
												->where('id_maklumat_permohonan',$id_permohonan)
												->first();
				// dd($contentEmel);
				$pentadbirs=User::where('id_access','1')->get(); //pentadbir sistem

				//HANTAR EMEL KEPADA PEMOHON
				Mail::send('email/notiPemohonKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				{
					$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
					$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
					foreach($pentadbirs as $pentadbir)
					{
						$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					}

					// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
					$header->subject('PERKARA: Notifikasi Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara');
				});

				// Mail::send('email/notiPenyeliaKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				// {
				// 	$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
				// 	$header->to('asnidadon@gmail.com', 'as');
				// 	// $header->to($contentEmel->emel, $contentEmel->nama);
				// 	// foreach($pentadbirs as $pentadbir)
				// 	// {
				// 	// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
				// 	// }
					
				// 	// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
				// 	$header->subject('PERKARA: Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara');
				// 	});

				$request->session()->flash('status', 'Tempahan kenderaan berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
				return redirect('pemohon/tempahankenderaan/butiran/'.$id_permohonan);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Tempahan kenderaan tidak berjaya dihantar.');
				return redirect('pemohon/tempahankenderaan/'.$nokp)->withInput();
			}
			
		}
	

  }
  /**
  * Display the specified resource.
  *
  * @param  \App\Aduan  $aduan
  * @return \Illuminate\Http\Response
  */

  public function butiran_tempahankenderaan($id)
  {
 
    $permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// dd($permohonanKenderaan);
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();

		$tindakan  = Tindakan::where(['id_permohonan'=>$id])
								->whereIn('id_status_tempah', [3, 4, 5]) //lulus
								->orderBy('created_by', 'desc')
								->first();

		$penumpangs = Penumpang::where(['id_tempahan'=>$id])->get();   
		// dd($penumpangs);

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

		// dd($kenderaanBalik);

		$tindakans =  Tindakan::where(['id_permohonan'=>$id])->orderBy('created_by')->get();
		// dd($tindakans);
		$kenderaan = Kenderaan::where('id_status', '7')->get();
		$optStatuss = LkpStatus::whereIn('id_status',['3','4','5'])->get();
						
		return view('pemohon.butirantempahkenderaan', compact('permohonanKenderaan','pemohon','tindakan','kenderaanPergi','kenderaanBalik','tindakans','penumpangs','kenderaan','optStatuss'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Aduan  $aduan
  * @return \Illuminate\Http\Response
  */
  public function kemaskini_tempahankenderaan($id)
  {
    $optJenisPerjalanans = LkpJenisPerjalanan::get();
		$optTujuans = LkpTujuan::get();
		$optNegeris = RLkpNegeri::orderBy('negeri')->get();
        $permohonanKenderaan = PermohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();
		$optBahagians = PLkpBahagian::orderBy('bahagian')->get();
		$penumpangs = Penumpang::where(['id_tempahan'=>$id])->get();
		$maklumat_penumpang='';
		foreach ($penumpangs as $penumpang) {
			$maklumat_penumpang.= base64_encode($penumpang->id_penumpang.'x|x'.''.'x|x'.$penumpang->bahagian.'x|x'.''.'x|x'.$penumpang->nama.'x|x'.$penumpang->no_tel.'x|x'.$penumpang->emel.'x|x'.$penumpang->mykad).'|x|x|';
		}
		// $str = base64_decode($maklumat_penumpang);
// dd($penumpangs);
						
		return view('pemohon.kemaskinitempahkenderaan', compact('permohonanKenderaan','pemohon','optNegeris','optJenisPerjalanans','optTujuans','optBahagians','maklumat_penumpang'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Aduan  $aduan
  * @return \Illuminate\Http\Response
  */
  public function simpank_tempahankenderaan(Request $request, $id)
  {
    $data = $request->input();

		// dd($data);
		
		if($request->hasFile('lampiran')){
			$file = $request->file('lampiran');			
			//echo $file->getClientOriginalExtension(); // = pdf
			//echo $file->getSize()/1024/1024; //to get MB
			//echo $file->getMimeType(); // = application/pdf
			
			if($file->getMimeType()=='application/pdf' && $file->getSize()/1024/1024 > 2) {
				$dokumenIns = 0;
			} else {
				$dokumenIns = 1;
			}
		} else {
			$dokumenIns = 1;
		}
		
		$rules = [
			// 'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
			'telefon' => 'required',
			'tel_bimbit' => 'required',
			'jenis_perjalanan' => 'required',
			'id_tujuan' => 'required',
			'tkh_pergi' => 'required', 
			'tkh_balik' => 'required_if:jenis_perjalanan,2,3',
			'masa_pergi' => 'required',
			'masa_balik' => 'required_if:jenis_perjalanan,2,3',
			'lokasi_tujuan' => 'required',
			'bil_penumpang' => 'required',
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi dan dokumen tidak sah.");
			return redirect('pemohon/tempahankenderaan/kemaskini/'.$id)->withInput();
			
		} elseif ($validator->fails() && $dokumenIns==1) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('pemohon/tempahankenderaan/kemaskini/'.$id)->withInput();
			
		} elseif (!$validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed', 'Dokumen tidak sah.');
			return redirect('pemohon/tempahankenderaan/kemaskini/'.$id)->withInput();
			
		} else {
			
			try {
			
				if($request->hasFile('lampiran')) {
					$destinationPath = 'uploads/tempahan';
					$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				} else {
					$path = '';
				}
				
				if($path=='') { $path = PermohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first()->lampiran; }
				
				$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan', $id)->first();
				$pemohon = Pemohon::where('id_pemohon', $permohonanKenderaan->id_pemohon)->first();

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

							
				if(isset($data['tkh_balik'])) { $tkh_balik = Carbon\Carbon::parse($data['tkh_balik'])->format('Y-m-d'); } else { $tkh_balik = null; }
				
				if(isset($data['masa_balik'])) { $masa_balik = Carbon\Carbon::parse($data['masa_balik'])->format('H:i:s'); } else { $masa_balik = null; }
				// dd($tkh_balik, $masa_balik);

				$permohonanKenderaan->update([
								'id_jenis_perjalanan' => $data['jenis_perjalanan'],
								'id_tujuan' => $data['id_tujuan'],
								'tkh_pergi' => Carbon\Carbon::parse($data['tkh_pergi'])->format('Y-m-d'),
								'tkh_balik' => $tkh_balik,
								'masa_pergi' => Carbon\Carbon::parse($data['masa_pergi'])->format('H:i:s'),
								'masa_balik' => $masa_balik,
								'id_negeri' => $data['id_negeri'],
								'lokasi_tujuan' => $data['lokasi_tujuan'],
								'bil_penumpang' =>  $data['bil_penumpang'],
								'keterangan_lanjut' => $data['nama_tujuan'],
								'id_status' => 2, //status kemaskini
								'lampiran' => $path,
								'updated_by' => Carbon\Carbon::now(),
							]);
				
				$tindakan = new Tindakan;
				$tindakan->id_permohonan = $id;
				$tindakan->id_status_tempah = 2;
				$tindakan->peg_penyelia = $pemohon->mykad;
				$tindakan->updated_by = Carbon\Carbon::now();
				$tindakan->created_by = Carbon\Carbon::now();
				$tindakan->save();

				$mjnotin=array();
				$expPenumpang = explode('|x|x|', $data['maklumat_penumpang']);
				for($mj=0; $mj<count($expPenumpang) - 1; $mj++) {
					$decodeMJ = base64_decode($expPenumpang[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					if(strlen($expDecodeMJ[0])==0) {
						$penumpang = new Penumpang;
						$penumpang->nama = $expDecodeMJ[4];
						$penumpang->emel = $expDecodeMJ[6];
						$penumpang->no_tel = $expDecodeMJ[5];
						$penumpang->bahagian = $expDecodeMJ[2];
						$penumpang->mykad = $expDecodeMJ[7];
						$penumpang->id_tempahan = $id;
						$penumpang->created_at = Carbon\Carbon::now();
						$penumpang->updated_at = Carbon\Carbon::now();
						$penumpang->save();

						$newidjr = $penumpang->max('id_penumpang');
						array_push($mjnotin,$newidjr);
					} else {
						array_push($mjnotin,$expDecodeMJ[0]);
					}
					PPersonel::where('nokp',$expDecodeMJ[7])->update([
						'email' => $expDecodeMJ[6],
						'tel_bimbit' => $expDecodeMJ[5],
						'updated_at' => Carbon\Carbon::now(),
					]);
				}
				Penumpang::where('id_tempahan', $id)->whereNotIn('id_penumpang', $mjnotin)->delete();
			
				
				$request->session()->flash('status', 'Maklumat tempahan berjaya disimpan.');
				return redirect('pemohon/tempahankenderaan/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat tempahan tidak berjaya disimpan.');
				return redirect('pemohon/tempahankenderaan/kemaskini/'.$id)->withInput();
			}
			
		}
  }

  	public function batal_tempahankenderaan($id)
    {
		$permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// dd($permohonanKenderaan);
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();
		
		$penumpangs = Penumpang::where(['id_tempahan'=>$id])->get();

		return view('pemohon.bataltempahkenderaan', compact('pemohon','permohonanKenderaan','penumpangs'));
    }
	
    public function simpanb_tempahankenderaan(Request $request, $id)
    {
		try {			
			// Permohonan::where('id_permohonan', $id)->delete();
			PermohonanKenderaan::where('id_maklumat_permohonan', $id)->update([
				'id_status' => 6,
				'updated_by' => Carbon\Carbon::now(),
			]);

			$id_pemohon=PermohonanKenderaan::where('id_maklumat_permohonan', $id)->first()->id_pemohon;

			$tindakan = new Tindakan;
			$tindakan->id_permohonan = $id;
			$tindakan->id_status_tempah = 6;
			$tindakan->peg_penyelia = Pemohon::where('id_pemohon', $id_pemohon)->first()->mykad;
			$tindakan->updated_by = Carbon\Carbon::now();
			$tindakan->created_by = Carbon\Carbon::now();
			$tindakan->save();
			
			$request->session()->flash('status', 'Tempahan kenderaan berjaya dibatalkan.');
			return redirect('status');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Tempahan kenderaan tidak berjaya dibatalkan.');
			return redirect('tempahankenderaan/batal/'.$id);
		}
    }

	public function sah_tempahankenderaan(Request $request, $id)
    {
		$data = $request->input();

		// dd($data);
		try {
			
			$tk=Tindakan::select('kenderaan_pergi','kenderaan_balik')
									->where('id_permohonan', $id)
									->where('id_status_tempah', 3)
									->orderBy('id_tindakan','desc')
									->first();
				// dd($tk->kenderaan_balik);
			
			$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan', $id)
						->update([
							'id_status' => 11,
							'updated_by' => Carbon\Carbon::now(),
						]);

			$id_pemohon = PermohonanKenderaan::where('id_maklumat_permohonan', $id)->first()->id_pemohon;

			$tindakan = new Tindakan;
			$tindakan->id_permohonan = $id;
			$tindakan->kenderaan_pergi = $tk->kenderaan_pergi;
			$tindakan->kenderaan_balik = $tk->kenderaan_balik;
			$tindakan->id_status_tempah = 11;
			$tindakan->peg_penyelia = Pemohon::where('id_pemohon', $id_pemohon)->first()->mykad;
			$tindakan->updated_by = Carbon\Carbon::now();
			$tindakan->created_by = Carbon\Carbon::now();
			$tindakan->save();
			
			$request->session()->flash('status', 'Tempahan kenderaan berjaya disahkan.');
			return redirect('pemohon/tempahankenderaan/butiran/'.$id);
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Tempahan kenderaan tidak berjaya disahkan.');
			return redirect('pemohon/tempahankenderaan/butiran/'.$id)->withInput();
		}
				
    }


  public function penilaiankenderaan(Request $request, $mykad)
  {
    $Srhfield = ['id_tempahan'=>''];
    $lkpSoalans = LkpSoalan::get();
	
	// $penilaians = Penilaian::where('mykad_penumpang',$mykad)
	// 				// ->whereNotIn('id_maklumat_permohonan',[$p])
	// 				->get();

	// $tempah[] = '';

	// if($penilaians){
	// 	foreach($penilaians as $p){
	// 		$tempah[] = $p->id_maklumat_permohonan;
	// 	}
	// }
					
	// $id_tempahans = Penumpang::where('mykad',$mykad)
	// 				->whereNotIn('id_tempahan',[$tempah])
	// 				->get();
	$tempah = Penilaian::where('mykad_penumpang', $mykad)
						->select('id_maklumat_permohonan')
						->get()->toArray();
	// dd($tempah);

	$id_tempahans = Penumpang::join('permohonan_kenderaan','permohonan_kenderaan.id_maklumat_permohonan','=','penumpang.id_tempahan')
				->whereIn('permohonan_kenderaan.id_status',[3,11])
				->where('penumpang.mykad',$mykad)
				->whereNotIn('penumpang.id_tempahan', $tempah)
				->get();
	// dd($id_tempahans);

	$mykad=$mykad;
	$permohonanKenderaan = PermohonanKenderaan::first();

	// $permohonanKenderaans = PermohonanKenderaan::get();
        // $optParlimens = LkpParlimen::orderBy('parlimen')->get();
        // $optDaerahs = LkpDaerah::orderBy('daerah')->get();
        // $Srhfield = ['kod_risi'=>'','jenis_risi'=>'','agama'=>'','negeri'=>'','daerah'=>'','parlimen'=>'', 'status_risi'=>'' ];

    return view('pemohon.penilaian',compact('Srhfield','lkpSoalans','permohonanKenderaan','id_tempahans','mykad'));
  }

  public function simpan_penilaiankenderaan(Request $request, $mykad)
    {
		// $data = $request->input();
		// dd($mykad);

		$rules = [
			// 'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
			'id_tempahan' => 'required',
			'skala' => 'required',
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Semua ruangan wajib diisi.");
			return redirect('pemohom/penilaian/'.$mykad)->withInput();
			
		} else {
			
			try {

				foreach($request->soalan as  $i=>$so){

					// $this->validate(request(), [
			
					// 	'pili' => 'required',
			
					// ]);
					$question[$i] = $so;
					$skor[$i] = $request->skala[$i];
				}
				// dd($question[1]);

					$penilaian = new Penilaian;
					$penilaian->id_maklumat_permohonan = $request->id_tempahan;
					$penilaian->mykad_penumpang = $mykad;
					$penilaian->soalan1 = $question[1];
					$penilaian->skala1 = $skor[1];
					$penilaian->soalan2 = $question[2];
					$penilaian->skala2 = $skor[2];
					$penilaian->soalan3 = $question[3];
					$penilaian->skala3 = $skor[3];
					$penilaian->soalan4 = $question[4];
					$penilaian->skala4 = $skor[4];
					$penilaian->soalan5 = $question[5];
					$penilaian->skala5 = $skor[5];
					$penilaian->ulasan = $request->ulasan;
					$penilaian->created_at = Carbon\Carbon::now();
					$penilaian->updated_at = Carbon\Carbon::now();
					$penilaian->save();
				
				$request->session()->flash('status', 'Borang penilaian berjaya dihantar.');
				return redirect('status');
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Borang penilaian tidak berjaya dihantar.');
				return redirect('pemohon/penilaian/'.$mykad)->withInput();
			}
			
		}
    }

	public function catatanpemandu($mykad)
    {
        $mykad = $mykad;
		$Srhfield = ['id_tempahan'=>''];

		$penilaians = Penilaian::where('mykad_pemandu',$mykad)
					// ->whereNotIn('id_maklumat_permohonan',[$p])
					->get();

		$tempah[] = '';

		if($penilaians){
			foreach($penilaians as $p){
				$tempah[] = $p->id_maklumat_permohonan;
			}
		}
		// dd([$tempah]);
		$id_tempahans = Tindakan::select('tindakan.id_permohonan', 'tindakan.id_status_tempah', 'tindakan.kenderaan_pergi', 'tindakan.kenderaan_balik','kenderaan.id_kenderaan', 'kenderaan.pemandu')
									->join('kenderaan', function($join){
										$join->on('kenderaan.id_kenderaan','=','tindakan.kenderaan_pergi'); 
										$join->orOn('kenderaan.id_kenderaan','=','tindakan.kenderaan_balik');
									})
									->where('tindakan.id_status_tempah',3)
									->where('kenderaan.pemandu',$mykad)
									->whereNotIn('tindakan.id_permohonan',$tempah)
									->distinct('tindakan.id_permohonan')
									->get();
		
	

		// dd($id_tempahans);
		

		return view('pemohon.catatan', compact('mykad','id_tempahans','Srhfield'));
    }
	
    public function simpan_catatanpemandu(Request $request, $mykad)
    {
		$data = $request->input();

		$rules = [
			// 'mykad' => 'required|string|min:3|max:255'
			'komen_pemandu' => 'required'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Semua ruangan wajib diisi.");
			return redirect('pemandu/catatan/'.$mykad)->withInput();
			
		} else {
			
			try {

				$penilaian = new Penilaian;
				$penilaian->id_maklumat_permohonan = $data['id_tempahan'];
				$penilaian->mykad_pemandu = $mykad;
				$penilaian->komen_pemandu = $data['komen_pemandu'];
				$penilaian->created_at = Carbon\Carbon::now();
				$penilaian->updated_at = Carbon\Carbon::now();
				$penilaian->save();


				$request->session()->flash('status', 'Catatan pemandu berjaya dihantar.');
				return redirect('status');
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Catatan pemandu tidak berjaya dihantar.');
				return redirect('pemandu/catatan/'.$mykad)->withInput();
			}
			
		}
    }

	public function tambah_tempahanbilik($search)
	{

    // $data = $request->input();
    // $personel=PPersonel::where(['nokp'=>$data['mykad']])->first();
    // $result = PPersonel::find($personel['nokp'])->first();
    // $search = $request->input('nokp');
	
	// $pemohon = Pemohon::where('mykad', $search )->first();
	$result = PPersonel::select('pegawais.*')->where('nokp', $search)->first();
    // $result = PPersonel::select('pegawais.*','bahagian.bahagian')
    // ->join('PLkpBahagian', 'pegawais.bahagian_id', '=', 'bahagian.id')
    // ->where('nokp', $search)
    // ->first();

//   dd($result);
	$optJenisPerjalanans = LkpJenisPerjalanan::get();
	$optTujuans = LkpTujuan::get();
	$optBahagians = PLkpBahagian::orderBy('bahagian')->get();
	$optNegeris = RLkpNegeri::orderBy('negeri')->get();

    return view('pemohon.developing', compact( 'result','optJenisPerjalanans','optTujuans','optBahagians','optNegeris'));
  }
}
