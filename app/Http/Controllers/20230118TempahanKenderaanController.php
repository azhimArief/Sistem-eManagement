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

class TempahanKenderaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$optTujuan = LkpTujuan::get();
		$optJenisPerjalanan = LkpJenisPerjalanan::get();
		$optStatus = LkpStatus::whereIn('id_status',['1','2','3','4'])->get();	

		// if(Auth::User()->id_access == 2){
		// 	$nama = Auth::User()->nama;
		// 	$permohonanKenderaans = PermohonanKenderaan::join('pemohon', 'permohonan_kenderaan.id_pemohon', '=', 'pemohon.id_pemohon')
		// 												->where('pemohon.nama','LIKE', "%{$nama}%")
		// 												->orderBy('permohonan_kenderaan.created_by','desc')
		// 												->get();
		// }else{

			$permohonanKenderaans = PermohonanKenderaan::orderBy('created_by','desc')->get();

			$Srhfield = ['kod_permohonan'=>'','tujuan'=>'', 'status'=>'', 'tkh_dari'=>'', 'tkh_hingga'=>'' ];

			if(isset($_POST['tapis']))
			{
			  
					 
			  $data = $request->input();
			//   dd($data['tkh_hingga']);
	
			// dd($permohonanKenderaans->where('created_by',date("Y-m-d")));
			 
			 if(strlen($data['kod_permohonan']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('kod_permohonan',$data['kod_permohonan']); $Srhfield['kod_permohonan']=$data['kod_permohonan']; }
			//  if(strlen($data['created_by']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('created_by',$data['created_by']); $Srhfield['created_by']=$data['created_by'];}
			 if(strlen($data['tujuan']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('id_tujuan',$data['tujuan']); $Srhfield['tujuan']=$data['tujuan'];}
			 if(strlen($data['status']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('id_status',$data['status']); $Srhfield['status']=$data['status']; }
			 if(strlen($data['tkh_dari']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('created_by','>=',$data['tkh_dari'].' 00:00:00'); $Srhfield['tkh_dari']=$data['tkh_dari']; }
			 if(strlen($data['tkh_hingga']) > 0) { $permohonanKenderaans = $permohonanKenderaans->where('created_by','<=', $data['tkh_hingga'].' 23:59:59'); $Srhfield['tkh_hingga']=$data['tkh_hingga']; }
			}
		// }

		// dd($permohonanKenderaans);
        return view('tempahankenderaan.senarai',compact('permohonanKenderaans','optTujuan','optJenisPerjalanan','Srhfield','optStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		
		$optJenisPerjalanans = LkpJenisPerjalanan::get();
		$optTujuans = LkpTujuan::get();
		$optBahagians = PLkpBahagian::whereIn('agensi_id',[1,3])->orderBy('bahagian')->get();
		$optNegeris = RLkpNegeri::orderBy('negeri')->get();
		$pemohon = Pemohon::where('mykad', Auth::user()->mykad )->first();
		$personel = PPersonel::where('nokp', Auth::user()->mykad )->first();
		
        return view('tempahankenderaan.tambah', compact('optJenisPerjalanans','optTujuans','optBahagians','optNegeris','pemohon','personel'));
    }

	public function searchPegawais (Request $request)
    {
      $id = $request->input('id');
      $data = PPersonel::where('bahagian_id', $id)
						// ->whereIn('agensi_id',[1,2])
	 					->orderBy('name')
						->get();
// dd($id);

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

		if(isset($_POST['semak_nama2'])) {
			
			// $users=Users::where(['mykad'=>$data['mykad']])->first();
			
			$nama=$data['pohon_bagi'];
			$personel=PPersonel::where('name','LIKE', "%{$nama}%")
								->first();
				
				if(strlen($personel)==0) {
					$request->session()->flash('failed', 'Nama pegawai tiada dalam pangkalan data');
					return redirect('tempahankenderaan/tambah')->withInput();
				} else {
					
					//$xemel = explode('@',$personel['emel']);
					$newdata = array(
						'pohon_bagi'=>$personel->name,
						'bahagian'=>PLkpBahagian::find($personel['bahagian_id'])->bahagian,
						'jawatan'=>$personel['jawatan'],
						'gred'=>$personel['gred'],
						'emel'=>$personel['email'],
						'mykad'=>PPersonel::find($personel['nokp'])->nokp,
					);
					$data = array_replace($data,$newdata);
					// dd($data);
					
					return redirect('tempahankenderaan/tambah')->withInput($data);
				}
		
			
		} elseif(isset($_POST['submit_tempahankenderaan'])) {

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
				'lokasi_tujuan' => 'required',
				'bil_penumpang' => 'required',
			];
			
			$validator = Validator::make($request->all(),$rules);
			
			if ($validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi dan dokumen tidak sah.");
			return redirect('tempahankenderaan/tambah')->withInput();
			
			} elseif ($validator->fails() && $dokumenIns==1) {
				
				$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
				return redirect('tempahankenderaan/tambah')->withInput();
				
			} elseif (!$validator->fails() && $dokumenIns==0) {
				
				$request->session()->flash('failed', 'dokumen tidak sah.');
				return redirect('tempahankenderaan/tambah')->withInput();
				
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

					$pemohon = Pemohon::where('mykad', $data['mykad'])->first();
					

					if($pemohon=='') {
						$pemohon = new Pemohon;
						//$users->id_pengguna = $data['id_pengguna'];
						$pemohon->mykad = $data['mykad'];
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
							'telefon' => $data['telefon'],
							'tel_bimbit' => $data['tel_bimbit'],
							'updated_by' => Carbon\Carbon::now(),
						]);
					}

					$id_pemohon = $pemohon->id_pemohon;

                    PPersonel::where('nokp', $data['mykad'])->update([
						'email' => $data['emel'],
						'tel' => $data['telefon'],
						'tel_bimbit' => $data['tel_bimbit'],
						'updated_at' => Carbon\Carbon::now(),
					]);
	
                    // dd($id_pemohon);
					
					$permohonanKenderaan = new PermohonanKenderaan;
					$permohonanKenderaan->id_pemohon = $id_pemohon;
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
					$tindakan->peg_penyelia = Auth::User()->mykad;
					$tindakan->updated_by = Carbon\Carbon::now();
					$tindakan->created_by = Carbon\Carbon::now();
					$tindakan->save();

					$expPenumpang = explode('|x|x|', $data['maklumat_penumpang']);
					
					for($mj=0; $mj<count($expPenumpang) - 1; $mj++) {
						$decodeMJ = base64_decode($expPenumpang[$mj]);
						$expDecodeMJ = explode('x|x', $decodeMJ);

						$penumpang = new Penumpang;
						$penumpang->nama = $expDecodeMJ[4];
						$penumpang->gred = $expDecodeMJ[7];
						$penumpang->emel = $expDecodeMJ[6];
						$penumpang->no_tel = $expDecodeMJ[5];
						$penumpang->bahagian = $expDecodeMJ[2];
						$penumpang->mykad = $expDecodeMJ[8];
						$penumpang->id_tempahan = $id_permohonan;
						$penumpang->created_at = Carbon\Carbon::now();
						$penumpang->updated_at = Carbon\Carbon::now();
						$penumpang->save();

						PPersonel::where('nokp',$expDecodeMJ[7])->update([
							'email' => $expDecodeMJ[6],
							'tel_bimbit' => $expDecodeMJ[5],
							'updated_at' => Carbon\Carbon::now(),
						]);
					}//dd( $decodeMJ);

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
                    // $header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
                    // $header->to('asnidadon@gmail.com', 'as');
                    // // $header->to($contentEmel->emel, $contentEmel->nama);
                    // // foreach($pentadbirs as $pentadbir)
                    // // {
                    // // 	$header->to($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                    // // }

                    // // SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
                    // $header->subject('PERKARA: Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara');
                    // });


					$request->session()->flash('status', 'Tempahan kenderaan berjaya dihantar. Sila semak emel anda untuk butiran tempahan.');
					return redirect('tempahankenderaan/butiran/'.$id_permohonan);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Tempahan kenderaan tidak berjaya dihantar.');
					return redirect('tempahankenderaan/tambah')->withInput();
				}
				
			}
		}
		
    }
	
    public function butiran($id)
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

		$personels = PPersonel::get();
		$tindakans =  Tindakan::where(['id_permohonan'=>$id])->orderBy('created_by')->get();
		// dd($tindakans);
		$kenderaan = Kenderaan::where('id_status', '7')->get();
		$optStatuss = LkpStatus::whereIn('id_status',['3','4','5'])->get();
						
		return view('tempahankenderaan.butiran', compact('permohonanKenderaan','personels','pemohon','tindakan','kenderaanPergi','kenderaanBalik','tindakans','penumpangs','kenderaan','optStatuss'));
    }
	
    public function kemaskini($id)
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
		
// dd($str);
						
		return view('tempahankenderaan.kemaskini', compact('permohonanKenderaan','pemohon','optNegeris','optJenisPerjalanans','optTujuans','optBahagians','maklumat_penumpang'));
    }
	
    public function simpan_kemaskini(Request $request, $id)
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
			return redirect('tempahankenderaan/kemaskini/'.$id)->withInput();
			
		} elseif ($validator->fails() && $dokumenIns==1) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('tempahankenderaan/kemaskini/'.$id)->withInput();
			
		} elseif (!$validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed', 'Dokumen tidak sah.');
			return redirect('tempahankenderaan/kemaskini/'.$id)->withInput();
			
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
					'tel_bimbit' => $data['tel_bimbit'],
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
				$tindakan->peg_penyelia = Auth::User()->mykad;
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
			
				
				$request->session()->flash('status', 'Maklumat permohonan berjaya dikemaskini.');
				return redirect('tempahankenderaan/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat permohonan tidak berjaya dikemaskini.');
				return redirect('tempahankenderaan/kemaskini/'.$id);
			}
			
		}

    }

	public function batal($id)
    {
		$permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// dd($permohonanKenderaan);
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();
		
		$penumpangs = Penumpang::where(['id_tempahan'=>$id])->get();

		return view('tempahankenderaan.batal', compact('pemohon','permohonanKenderaan','penumpangs'));
    }
	
    public function simpan_batal(Request $request, $id)
    {
		try {			
			// dd($id);
			// Permohonan::where('id_permohonan', $id)->delete();
			PermohonanKenderaan::where('id_maklumat_permohonan', $id)->update([
				'id_status' => 6,
				'updated_by' => Carbon\Carbon::now(),
			]);

			$tindakan = new Tindakan;
			$tindakan->id_permohonan = $id;
			$tindakan->id_status_tempah = 6;
			$tindakan->peg_penyelia = Auth::User()->mykad;
			$tindakan->updated_by = Carbon\Carbon::now();
			$tindakan->created_by = Carbon\Carbon::now();
			$tindakan->save();
			
			$request->session()->flash('status', 'Permohonan berjaya dibatalkan.');
			return redirect('tempahankenderaan');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Permohonan tidak berjaya dibatalkan.');
			return redirect('tempahankenderaan/batal/'.$id);
		}
    }
	
	public function tindakan($id)
    {
		$permohonanKenderaan = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();

		$optPemandus = LkpPemandu::where('status','!=',10)->get();	
        // $optPemandus = DB::select('select k.id_kenderaan, k.no_plat
        //                 from kenderaan k
        //                 where k.id_kenderaan not in
        //                 (SELECT t.kenderaan_pergi
        //                 from tindakan t, permohonan_kenderaan pk
        //                 where t.id_permohonan=pk.id_maklumat_permohonan
        //                 and t.id_status_tempah=3
        //                 and pk.tkh_pergi = '.$permohonanKenderaan->tkh_pergi.'
        //                 and pk.masa_pergi <= TIME("'.$permohonanKenderaan->masa_pergi.'"))
        //                 and k.id_kenderaan not in
        //                 (SELECT t.kenderaan_balik
        //                 from tindakan t, permohonan_kenderaan pk
        //                 where t.id_permohonan=pk.id_maklumat_permohonan
        //                 and t.id_status_tempah=3
        //                 and pk.tkh_pergi = '.$permohonanKenderaan->tkh_balik.'
        //                 and pk.masa_balik >= TIME("'.$permohonanKenderaan->masa_balik.'"))');
                        // and '.$permohonanKenderaan->masa_pergi.' < pk.masa_pergi
                        // and '.$permohonanKenderaan->masa_balik.' < pk.masa_balik

        // dd($permohonanKenderaan->masa_pergi);
		$kenderaan = Kenderaan::join('lkp_pemandu','kenderaan.pemandu','=','lkp_pemandu.mykad')
								->where('kenderaan.id_status', '7')
								->where('lkp_pemandu.status', '9')
								->get();
		// $optJenisKenderaans = LkpJenisKenderaan::get();	
		$optStatuss = LkpStatus::whereIn('id_status',['3','4','5'])->get();
		
						
		return view('tempahankenderaan.tindakan', compact('kenderaan','optStatuss','permohonanKenderaan'));
    }

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

			$rules = [
				// 'tajuk' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
				// 'hp_pemandu_pergi' => 'required_if:status,3',
			];
			
			$validator = Validator::make($request->all(),$rules);
			
			if ($validator->fails()) {
				
				$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
				return redirect('tempahankenderaan/tindakan/'.$id)->withInput();
				
			} else {
				
				try {

					$tindakan = new Tindakan;
					//$users->id_pengguna = $data['id_pengguna'];
					$tindakan->id_permohonan = $id;
					// $tindakan->kenderaan_pergi = $data['kenderaan_pergi'];
					if(isset($_POST['jenis_pemanduu'])){
						if($data['jenis_pemanduu']==1){
							$tindakan->kenderaan_pergi = $data['kenderaan_pergi'];
						}else{
							if(isset($_POST['kenderaan_pergi'])) $tindakan->kenderaan_pergi = $data['kenderaan_pergi']; else $tindakan->kenderaan_pergi = null;
						}
					}
					else{
						if(isset($_POST['kenderaan_pergi'])) $tindakan->kenderaan_pergi = $data['kenderaan_pergi']; else $tindakan->kenderaan_pergi = null;
		
					}
					
					// $tindakan->hp_pemandu_pergi = $data['hp_pemandu_pergi'];
					if(isset($_POST['jenis_pemandu'])){
						if($data['jenis_pemandu']==1){
							$tindakan->kenderaan_balik = $data['kenderaan_pergi'];
						}else{
							if(isset($_POST['kenderaan_balik'])) $tindakan->kenderaan_balik = $data['kenderaan_balik']; else $tindakan->kenderaan_balik = null;
						}
					}
					else{
						if(isset($_POST['kenderaan_balik'])) $tindakan->kenderaan_balik = $data['kenderaan_balik']; else $tindakan->kenderaan_balik = null;
						// if(isset($_POST['hp_pemandu_balik'])) $tindakan->hp_pemandu_balik = $data['hp_pemandu_balik']; else $tindakan->hp_pemandu_balik = null;
					}
					
					$tindakan->catatan = $data['catatan'];
					$tindakan->id_status_tempah = $data['status'];
					$tindakan->peg_penyelia = Auth::User()->mykad;
					$tindakan->updated_by = Carbon\Carbon::now();
					$tindakan->created_by = Carbon\Carbon::now();
					$tindakan->save();
					
					$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan', $id)
								->update([
									'id_status' => $data['status'],
									'updated_by' => Carbon\Carbon::now(),
								]);

					$contentEmel=PermohonanKenderaan::select('permohonan_kenderaan.*','pemohon.nama','pemohon.emel', 'tindakan.kenderaan_pergi', 'tindakan.kenderaan_balik')
								->join('pemohon','permohonan_kenderaan.id_pemohon','pemohon.id_pemohon')
								->join('tindakan','permohonan_kenderaan.id_maklumat_permohonan','tindakan.id_permohonan')
								->where('id_maklumat_permohonan',$id)
								->orderBy('tindakan.id_tindakan', 'desc')
								->first();
					// dd($contentEmel);

					// jika lulus
                    if ($tindakan->id_status_tempah==3){
						$pentadbirs=User::get(); //pentadbir sistem
					}else{
						$pentadbirs=User::where('id_access','1')->get(); //pentadbir sistem
					}

					//HANTAR EMEL KEPADA PEMOHON, CC PENTADBIR
					Mail::send('email/statusPemohonKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
					{
						$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
                        // $header->to('asnidamj@perpaduan.gov.my', 'pemohon'); //test
						$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
						foreach($pentadbirs as $pentadbir)
						{
							$header->bcc($pentadbir->email,$pentadbir->nama);	
						}
						
						// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
						$header->subject('PERKARA: Notifikasi Status Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara');
					});

					// jika lulus
                    if ($tindakan->id_status_tempah==3){

                        //HANTAR EMEL KEPADA PEMANDU
						// jika pemandu pergi sahaja (perjalanan pergi sahaja)
						if($contentEmel->id_jenis_perjalanan==1){

							$pemandu=LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
												->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
												->first();

							Mail::send('email/statusPemanduKenderaanPergi', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemandu)
							{
								$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
								// $header->to('asnidamj@perpaduan.gov.my', $pemandu->email); //test
								
									$header->to($pemandu->email,$pemandu->nama_pemandu);	
								
								
								// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
								$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
							});
						}else{
							if($tindakan->kenderaan_pergi==$tindakan->kenderaan_balik){

								$pemandus = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
											->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
											->orwhere('kenderaan.id_kenderaan',$tindakan->kenderaan_balik)
											->get();

								// jika pemandu pergi=pemandu balik
								Mail::send('email/statusPemanduKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemandus)
								{
									$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
									// $header->to('asnidamj@perpaduan.gov.my', 'pemandu'); 
									foreach($pemandus as $pemandu)
									{
										$header->to($pemandu->email,$pemandu->nama_pemandu);	
									}
									
									// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
									$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
								});	
							}else{
								// jika pemandu pergi != pemandu balik
								$pemanduP = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
											->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
											->first();

								$pemanduB = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
											->where('kenderaan.id_kenderaan',$tindakan->kenderaan_balik)
											->first();

									// emel pemandu pergi
								Mail::send('email/statusPemanduKenderaanPergi', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemanduP)
								{
									$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
									$header->to($pemanduP->email, $pemanduP->nama_pemandu); //test
									
									// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
									$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
								});
								
									//emel pemandu balik
									Mail::send('email/statusPemanduKenderaanBalik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemanduB)
								{
									$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
									$header->to($pemanduB->email, $pemanduB->nama_pemandu); //test
									
									// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
									$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
								});
								
							}
						}
                    }
					
					$request->session()->flash('status', 'Maklumat tindakan berjaya disimpan.');
					return redirect('tempahankenderaan/butiran/'.$id);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Maklumat tindakan tidak berjaya disimpan.');
					return redirect('tempahankenderaan/tindakan/'.$id)->withInput();
				}
			}
				
    }

	public function kemaskini_tindakan($id)
    {
		$permohonanKenderaan = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// $kenderaans = Kenderaan::where('id_status', '7')->get();
		$kenderaans = Kenderaan::join('lkp_pemandu','kenderaan.pemandu','=','lkp_pemandu.mykad')
					->where('kenderaan.id_status', '7')
					->where('lkp_pemandu.status', '9')
					->get();
		$optStatuss = LkpStatus::whereIn('id_status',['3','4','5'])->get();
		$tindakan = Tindakan::where('id_permohonan', $id)
							->whereIn('id_status_tempah', ['3','4','5'])
							->orderBy('created_by', 'desc')
							->first();

			$kenderaanPergi = Kenderaan::join ('emanagement.lkp_jenis_kenderaan', 'emanagement.kenderaan.id_jenis', '=', 'emanagement.lkp_jenis_kenderaan.id_jenis_kenderaan')
							->join('emanagement.lkp_model','emanagement.kenderaan.id_model','=','emanagement.lkp_model.id_model')
							->join('emanagement.lkp_pemandu','emanagement.kenderaan.pemandu','=','emanagement.lkp_pemandu.mykad')
							->where('id_kenderaan',$tindakan->kenderaan_pergi)
							->first();

			if (isset($tindakan->kenderaan_balik)){
				$kenderaanBalik = Kenderaan::join ('emanagement.lkp_jenis_kenderaan', 'emanagement.kenderaan.id_jenis', '=', 'emanagement.lkp_jenis_kenderaan.id_jenis_kenderaan')
								->join('emanagement.lkp_model','emanagement.kenderaan.id_model','=','emanagement.lkp_model.id_model')
								->join('emanagement.lkp_pemandu','emanagement.kenderaan.pemandu','=','emanagement.lkp_pemandu.mykad')
								->where('id_kenderaan',$tindakan->kenderaan_balik)
								->first();
			} else { $kenderaanBalik = []; }
		

		// dd($kenderaanPergi);
						
		return view('tempahankenderaan.kemaskini_tindakan', compact('kenderaans','optStatuss','permohonanKenderaan','tindakan','kenderaanPergi','kenderaanBalik'));
    }
	
    public function simpan_kemaskini_tindakan(Request $request, $id)
    {
		$data = $request->input();

		// dd($data);
		
		$rules = [
			// 'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
			
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('tempahankenderaan/kemaskini/'.$id)->withInput();
			
		} 
		else {
			
			try {

				$tindakan = new Tindakan;
					//$users->id_pengguna = $data['id_pengguna'];
				$tindakan->id_permohonan = $id;
				$tindakan->kenderaan_pergi = $data['kenderaan_pergi'];
				// $tindakan->hp_pemandu_pergi = $data['hp_pemandu_pergi'];
				if(isset($_POST['jenis_pemandu'])){
					if($data['jenis_pemandu']==1){
						$tindakan->kenderaan_balik = $data['kenderaan_pergi'];
					}else{
						if(isset($_POST['kenderaan_balik'])) $tindakan->kenderaan_balik = $data['kenderaan_balik']; else $tindakan->kenderaan_balik = null;
					}
				}
				else{
					if(isset($_POST['kenderaan_balik'])) $tindakan->kenderaan_balik = $data['kenderaan_balik']; else $tindakan->kenderaan_balik = null;
					// if(isset($_POST['hp_pemandu_balik'])) $tindakan->hp_pemandu_balik = $data['hp_pemandu_balik']; else $tindakan->hp_pemandu_balik = null;
				}
				$tindakan->catatan = $data['catatan'];
				$tindakan->id_status_tempah = $data['status'];
				$tindakan->peg_penyelia = Auth::User()->mykad;
				$tindakan->updated_by = Carbon\Carbon::now();
				$tindakan->created_by = Carbon\Carbon::now();
				$tindakan->save();
				
				$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan', $id)
										->update([
											'id_status' => $data['status'],
											'updated_by' => Carbon\Carbon::now(),
										]);

				$contentEmel=PermohonanKenderaan::select('permohonan_kenderaan.*','pemohon.nama','pemohon.emel', 'tindakan.kenderaan_pergi', 'tindakan.kenderaan_balik')
										->join('pemohon','permohonan_kenderaan.id_pemohon','pemohon.id_pemohon')
										->join('tindakan','permohonan_kenderaan.id_maklumat_permohonan','tindakan.id_permohonan')
										->where('id_maklumat_permohonan',$id)
										->orderBy('tindakan.id_tindakan', 'desc')
										->first();
				// dd($contentEmel);
				// jika lulus
				if ($tindakan->id_status_tempah==3){
					$pentadbirs=User::get(); //pentadbir sistem
				}else{
					$pentadbirs=User::where('id_access','1')->get(); //pentadbir sistem
				}

				//HANTAR EMEL KEPADA PEMOHON
				Mail::send('email/statusPemohonKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pentadbirs)
				{
					$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
					$header->to($contentEmel->emel, $contentEmel->nama); //emel pemohon
					foreach($pentadbirs as $pentadbir)
					{
						$header->bcc($pentadbir->email,$pentadbir->nama);	
					}
					
					// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
					$header->subject('PERKARA: [Kemaskini] Notifikasi Status Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara');
				});

                if ($tindakan->id_status_tempah==3){

					//HANTAR EMEL KEPADA PEMANDU
					// jika pemandu pergi sahaja (perjalanan pergi sahaja)
					if($contentEmel->id_jenis_perjalanan==1){

						$pemandu=LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
											->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
											->first();

						Mail::send('email/statusPemanduKenderaanPergi', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemandu)
						{
							$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
							// $header->to('asnidamj@perpaduan.gov.my', $pemandu->email); //test
							// foreach($pemandus as $pemandu)
							// {
								$header->to($pemandu->email,$pemandu->nama_pemandu);	
							// }
							
							// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
							$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
						});
					}else{
						if($tindakan->kenderaan_pergi==$tindakan->kenderaan_balik){

							$pemandus = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
										->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
										->orwhere('kenderaan.id_kenderaan',$tindakan->kenderaan_balik)
										->get();

							// jika pemandu pergi=pemandu balik
							Mail::send('email/statusPemanduKenderaan', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemandus)
							{
								$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
								// $header->to('asnidamj@perpaduan.gov.my', 'pemandu'); 
								foreach($pemandus as $pemandu)
								{
									$header->to($pemandu->email,$pemandu->nama_pemandu);	
								}
								
								// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
								$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
							});	
						}else{
							// jika pemandu pergi != pemandu balik
							$pemanduP = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
										->where('kenderaan.id_kenderaan',$tindakan->kenderaan_pergi)
										->first();

							$pemanduB = LkpPemandu::join('kenderaan','kenderaan.pemandu','=','lkp_pemandu.mykad')
										->where('kenderaan.id_kenderaan',$tindakan->kenderaan_balik)
										->first();

								// emel pemandu pergi
							Mail::send('email/statusPemanduKenderaanPergi', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemanduP)
							{
								$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
								// $header->to('asnidamj@perpaduan.gov.my', $pemanduP->email); //test
								$header->to($pemanduP->email,$pemanduP->nama_pemandu);	
								// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
								$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
							});
							
								//emel pemandu balik
								Mail::send('email/statusPemanduKenderaanBalik', ['content' => $contentEmel], function ($header) use ($contentEmel,$pemanduB)
							{
								$header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
								// $header->to('asnidamj@perpaduan.gov.my', $pemanduB->email); //test
								$header->to($pemanduB->email,$pemanduB->nama_pemandu);	
								// SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
								$header->subject('PERKARA: Notifikasi Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
							});
							
						}
					}
				}
			
				
				$request->session()->flash('status', 'Maklumat tindakan berjaya disimpan.');
				return redirect('tempahankenderaan/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat tindakan tidak berjaya disimpan.');
				return redirect('tempahankenderaan/kemaskini/'.$id);
			}
			
		}

    }

	public function butiran_tindakan($id)
    {
        // $permohonanKenderaan  = permohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		// // dd($permohonanKenderaan);
		// $id_pemohon = $permohonanKenderaan->id_pemohon;
		// $pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();

		$tindakan  = Tindakan::where(['id_tindakan'=>$id])
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

		// dd($kenderaanBalik);
						
		return view('tempahankenderaan.butiran_tindakan', compact('tindakan','kenderaanPergi','kenderaanBalik'));
    }

	public function simpan_sah(Request $request, $id)
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

			$tindakan = new Tindakan;
			$tindakan->id_permohonan = $id;
			$tindakan->kenderaan_pergi = $tk->kenderaan_pergi;
			$tindakan->kenderaan_balik = $tk->kenderaan_balik;
			$tindakan->id_status_tempah = 11;
			$tindakan->peg_penyelia = Auth::User()->mykad;
			$tindakan->updated_by = Carbon\Carbon::now();
			$tindakan->created_by = Carbon\Carbon::now();
			$tindakan->save();
			
			$request->session()->flash('status', 'Tempahan kenderaan berjaya disahkan.');
			return redirect('tempahankenderaan/butiran/'.$id);
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Tempahan kenderaan tidak berjaya disahkan.');
			return redirect('tempahankenderaan/butiran/'.$id)->withInput();
		}
				
    }

    public function hapus($id)
    {
		
		return view('tempahankenderaan.hapus', compact(''));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			Permohonan::where('id_permohonan', $id)->delete();
			permohonanKenderaan::where('id_pemohonan', $id)->delete();
			
			$request->session()->flash('status', 'Maklumat Permohonan berjaya dihapuskan.');
			return redirect('tempahankenderaan');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat Permohonan tidak berjaya dihapuskan.');
			return redirect('tempahankenderaan/hapus/'.$id);
		}
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
