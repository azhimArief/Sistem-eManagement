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
use Illuminate\Http\Request;
use Carbon;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TempahanKenderaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// $Srhfield = ['kod_risi'=>'','jenis_risi'=>'','negeri'=>''];
		// $optJenisRisis = LkpJenisRisi::get();
		// $optNegeris = LkpNegeri::get();
		
		$permohonanKenderaans = PermohonanKenderaan::orderBy('created_by','desc')->get();
		
		// if(isset($_POST['tapis_risi'])) {
		
		// 	$data = $request->input();
			
		// 	if(strlen($data['kod_risi']) > 0) { $maklumatRisis = $maklumatRisis->where('kod_risi',$data['kod_risi']); $Srhfield['kod_risi']=$data['kod_risi']; }
		// 	if(strlen($data['jenis_risi']) > 0) { $maklumatRisis = $maklumatRisis->where('id_jenis_risi',$data['jenis_risi']); $Srhfield['jenis_risi']=$data['jenis_risi']; }
		// 	if(strlen($data['negeri']) > 0) { $maklumatRisis = $maklumatRisis->where('negeri',$data['negeri']); $Srhfield['negeri']=$data['negeri']; }
		// }
		
        return view('tempahankenderaan.senarai',compact('permohonanKenderaans'));
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
		
        return view('tempahankenderaan.tambah', compact('optJenisPerjalanans','optTujuans'));
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
				//'email' => 'required|string|email|max:255'
				'telefon'  => 'required',
				'tel_bimbit'  => 'required',
				'jenis_perjalanan'  => 'required',
				'id_tujuan'  => 'required',
				'tkh_pergi'  => 'required',
				'masa_pergi'  => 'required',
				'lokasi_tujuan'  => 'required',
				'bil_penumpang'  => 'required',
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
					$jumlah = PermohonanKenderaan::count();					
        			$jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
					$kod_permohonan = 'V'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;

					$pemohon = new Pemohon;
					//$users->id_pengguna = $data['id_pengguna'];
					$pemohon->mykad = $data['mykad'];
					$pemohon->nama = $data['nama'];
					$pemohon->pohon_bagi = $data['pohon_bagi'];
					$pemohon->bahagian = $data['bahagian'];
					$pemohon->emel = $data['emel'];
					$pemohon->telefon = $data['telefon'];
					$pemohon->tel_bimbit = $data['tel_bimbit'];
					$pemohon->jawatan = $data['jawatan'];
					$pemohon->gred = $data['gred'];
					$pemohon->updated_by = Carbon\Carbon::now();
					$pemohon->created_by = Carbon\Carbon::now();
					$pemohon->save();

					$id_pemohon = $pemohon->max('id_pemohon');
					
					// if(isset($_POST['jenis_akaun'])) $jenis_bank1=$data['jenis_akaun']; else $jenis_bank1='';
					$permohonanKenderaan = new PermohonanKenderaan;
					$permohonanKenderaan->id_pemohon = $id_pemohon;
					$permohonanKenderaan->kod_permohonan = $kod_permohonan;
					$permohonanKenderaan->id_jenis_perjalanan=$data['jenis_perjalanan'];
					$permohonanKenderaan->tkh_pergi = Carbon\Carbon::parse($data['tkh_pergi'])->format('Y-m-d');
					if(isset($data['tkh_balik'])) $permohonanKenderaan->tkh_balik = Carbon\Carbon::parse($data['tkh_balik'])->format('Y-m-d'); else $permohonanKenderaan->tkh_balik = null;
					$permohonanKenderaan->masa_pergi = $data['masa_pergi'];
					$permohonanKenderaan->masa_balik = $data['masa_balik'];
					$permohonanKenderaan->id_tujuan = $data['id_tujuan'];
					$permohonanKenderaan->lokasi_tujuan = $data['lokasi_tujuan'];
					$permohonanKenderaan->keterangan_lanjut = $data['nama_tujuan'];
					$permohonanKenderaan->bil_penumpang = $data['bil_penumpang'];
					$permohonanKenderaan->id_status = 1;
					$permohonanKenderaan->lampiran = $path;
					$permohonanKenderaan->updated_by = Carbon\Carbon::now();
					$permohonanKenderaan->created_by = Carbon\Carbon::now();

					$permohonanKenderaan->save();

					$id_permohonan = $permohonanKenderaan->max('id_maklumat_permohonan');

					$request->session()->flash('status', 'Tempahan kenderaan berjaya disimpan. Sila semak emel anda untuk butiran tempahan.');
					return redirect('tempahankenderaan/butiran/'.$id_permohonan);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Tempahan kenderaan tidak berjaya disimpan.');
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
		$tindakan  = Tindakan::where(['id_permohonan'=>$id])->first();
		if (isset($tindakan)){
			$jenisKenderaanPergi = Kenderaan::join('emanagement.lkp_jenis_kenderaan', 'kenderaan.id_jenis', '=', 'lkp_jenis_kenderaan.id_jenis_kenderaan')
											->join('emanagement.lkp_model','kenderaan.id_model','=','lkp_model.id_model')
											->join('emanagement.lkp_pemandu','kenderaan.pemandu','=','lkp_pemandu.mykad')
											->where('kenderaan.id_kenderaan',[$tindakan->kenderaan_pergi])
											->first();	

			$jenisKenderaanBalik = Kenderaan::join('emanagement.lkp_jenis_kenderaan', 'kenderaan.id_jenis', '=', 'lkp_jenis_kenderaan.id_jenis_kenderaan')
											->join('emanagement.lkp_model','kenderaan.id_model','=','lkp_model.id_model')
											->join('emanagement.lkp_pemandu','kenderaan.pemandu','=','lkp_pemandu.mykad')								
											->where('kenderaan.id_kenderaan',[$tindakan->kenderaan_balik])
											->first();	
			// dd($jenisKenderaanBalik);
		} else {
			$jenisKenderaanPergi = [];
			$jenisKenderaanBalik =[];
		}
		
		// $jwtnkuasaRisis  = JwtnkuasaRisi::where(['id_risi'=>$id])->get();	
						
		return view('tempahankenderaan.butiran', compact('permohonanKenderaan','pemohon','tindakan','jenisKenderaanPergi','jenisKenderaanBalik'));
    }
	
    public function kemaskini($id)
    {
		$optJenisPerjalanans = LkpJenisPerjalanan::get();
		$optTujuans = LkpTujuan::get();
		
        $permohonanKenderaan = PermohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();
						
		return view('tempahankenderaan.kemaskini', compact('permohonanKenderaan','pemohon','optJenisPerjalanans','optTujuans'));
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
				
				$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan', $id)
															->first();

				$id_pemohon = $permohonanKenderaan->id_pemohon;

				Pemohon::where('id_pemohon', $id_pemohon)
							->update([
								'telefon' => $data['telefon'],
								'tel_bimbit' => $data['tel_bimbit'],
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
								'lokasi_tujuan' => $data['lokasi_tujuan'],
								'bil_penumpang' =>  $data['bil_penumpang'],
								'keterangan_lanjut' => $data['nama_tujuan'],
								'id_status' => 1, //status permohonan baru semula
								'lampiran' => $path,
								'updated_by' => Carbon\Carbon::now(),
							]);
				
				$request->session()->flash('status', 'Maklumat Permohonan berjaya disimpan.');
				return redirect('tempahankenderaan/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat Permohonan tidak berjaya disimpan.');
				return redirect('tempahankenderaan/kemaskini/'.$id);
			}
			
		}

    }

	public function batal($id)
    {
		$permohonanKenderaan  = PermohonanKenderaan::where(['id_maklumat_permohonan'=>$id])->first();
		$id_pemohon = $permohonanKenderaan->id_pemohon;
		$pemohon  = Pemohon::where(['id_pemohon'=>$id_pemohon])->first();	

		return view('tempahankenderaan.batal', compact('pemohon','permohonanKenderaan'));
    }
	
    public function simpan_batal(Request $request, $id)
    {
		try {			
			// Permohonan::where('id_permohonan', $id)->delete();
			PermohonanKenderaan::where('id_pemohon', $id)->update([
				'id_status' => 6,
				'updated_by' => Carbon\Carbon::now(),
			]);
			
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
		$kenderaan = Kenderaan::get();
		// $optJenisKenderaans = LkpJenisKenderaan::get();	
		// $optPemandus = LkpPemandu::get();	
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
					$tindakan->kenderaan_pergi = $data['kenderaan_pergi'];
					$tindakan->hp_pemandu_pergi = $data['hp_pemandu_pergi'];
					if(isset($_POST['kenderaan_balik'])) $tindakan->kenderaan_balik = $data['kenderaan_balik']; else $tindakan->kenderaan_balik = null;
					if(isset($_POST['hp_pemandu_balik'])) $tindakan->hp_pemandu_balik = $data['hp_pemandu_balik']; else $tindakan->hp_pemandu_balik = null;
					$tindakan->catatan = $data['catatan'];
					$tindakan->id_status_tempah = $data['status'];
					$tindakan->updated_by = Carbon\Carbon::now();
					$tindakan->created_by = Carbon\Carbon::now();
					$tindakan->save();
					
					$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan', $id)
								->update([
									'id_status' => $data['status'],
									'updated_by' => Carbon\Carbon::now(),
								]);
					
					$request->session()->flash('status', 'Maklumat Tindakan berjaya disimpan.');
					return redirect('tempahankenderaan/butiran/'.$id);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Maklumat tindakan tidak berjaya disimpan.');
					return redirect('tempahankenderaan/tindakan/'.$id)->withInput();
				}
			}
				
    }

    public function hapus($id)
    {
        $pemohon  = Permohonan::where(['id_permohonan'=>$id])->first();
		$permohonanKenderaan  = permohonanKenderaan::where(['id_pemohonan'=>$id])->first();
		
		return view('tempahankenderaan.hapus', compact('pemohon','permohonanKenderaan'));
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
}
