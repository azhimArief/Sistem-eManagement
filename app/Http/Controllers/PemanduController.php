<?php

namespace App\Http\Controllers;

use App\Kenderaan;
use App\LkpJenisKenderaan;
use App\LkpStatus;
use App\LkpPemandu;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use Illuminate\Http\Request;
use Carbon;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PemanduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// $Srhfield = ['jenis'=>''];	
		$pemandus = LkpPemandu::orderBy('nama_pemandu')->get();
						
		// if(isset($_POST['tapis_pemandu'])) {
		
		// 	$data = $request->input();
			
		// 	if(strlen($data['jenis']) > 0) { $pemandus = $pemandus->where('jenis_pemandu',$data['jenis']); $Srhfield['jenis']=$data['jenis']; }
		// }

        return view('pemandu.senarai',compact('pemandus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		
        return view('pemandu.tambah');
    }
	
    public function simpan_tambah(Request $request)
    {
		$data = $request->input();
		// dd($data);

		if(isset($_POST['semak_mykad'])) {
			
			$pemandu=LkpPemandu::where(['mykad'=>$data['mykad']])->first();
			
			if(strlen($pemandu)==0) {
				$personel=PPersonel::where(['nokp'=>$data['mykad']])->first();
				
				if(strlen($personel)==0) {
					$request->session()->flash('failed', 'Nama pegawai tiada dalam pangkalan data');
					return redirect('pemandu/tambah')->withInput();
				} else {
					
					//$xemel = explode('@',$personel['emel']);
					$newdata = array(
						'nama_pemandu'=>$personel->name,
						'gred'=>$personel['gred'],
						'bahagian'=>PLkpBahagian::find($personel['bahagian_id'])->bahagian,
						'mykad'=>PPersonel::find($personel['nokp'])->nokp,
						'no_tel_bimbit'=>$personel['tel_bimbit'],
						'email'=>$personel['email'],
					);
					$data = array_replace($data,$newdata);
					
					return redirect('pemandu/tambah')->withInput($data);
				}
			} else {
				$request->session()->flash('failed', 'No. Mykad telah wujud.');
				return redirect('pemandu/tambah')->withInput();
			}
			
		} elseif(isset($_POST['submit_pemandu'])) {


			$rules = [
				// 'mykad' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
			];
			
			$validator = Validator::make($request->all(),$rules);
			
			if ($validator->fails()) {
				
				$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
				return redirect('pemandu/tambah')->withInput();	
		
			} else {
				
				try {

					$pemandu = new LkpPemandu;

					$pemandu->mykad = $data['mykad'];
					$id_pemandu = $data['mykad'];
					$pemandu->nama_pemandu = $data['nama_pemandu'];
					$pemandu->gred_pemandu = $data['gred'];
					$pemandu->bahagian = $data['bahagian'];
					$pemandu->no_tel_bimbit = $data['no_tel_bimbit'];
					$pemandu->email = $data['email'];
					if(isset($data['status'])) { $pemandu->status=$data['status']; } else { $pemandu->status=10; }
					$pemandu->save();

					

					$request->session()->flash('status', 'Maklumat pemandu berjaya disimpan.');
					return redirect('pemandu/butiran/'.$id_pemandu);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Maklumat pemandu tidak berjaya disimpan.');
					return redirect('pemandu/tambah')->withInput();
				}
			}	
			
		}
    }
	
    public function butiran($id)
    {
        $pemandu  = LkpPemandu::where(['mykad'=>$id])->first();	
						
		return view('pemandu.butiran', compact('pemandu'));
    }
	
    public function kemaskini($id)
    {
		$pemandu  = LkpPemandu::where(['mykad'=>$id])
						->first();
		
						
		return view('pemandu.kemaskini', compact('pemandu'));
    }
	
    public function simpan_kemaskini(Request $request, $id)
    {
		$data = $request->input();
		// dd($data);
		$rules = [
			//'email' => 'required|string|email|max:255'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('pemandu/kemaskini/'.$id)->withInput();
			
		} else {
			
			try {
			
				$pemandu = new LkpPemandu;
				
				if(isset($data['status'])) { $status=$data['status']; } else { $status=10; }

				$pemandu->where('mykad', $id)
							->update([
								'no_tel_bimbit' => $data['no_tel_bimbit'],
								'email' => $data['email'],
								'status' => $status,
								// 'keterangan' => $data['keterangan'],
								// 'tarikh_kuatkuasa' => Carbon\Carbon::parse($data['tkh_kuatkuasa'])->format('Y-m-d'),
								// 'tkh_kemaskini' => Carbon\Carbon::now(),
								// 'kemaskini_oleh' => '1',
								// 'path' => $path
							]);
				
				$request->session()->flash('status', 'Maklumat pemandu berjaya disimpan.');
				return redirect('pemandu/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat pemandu tidak berjaya disimpan.');
				return redirect('pemandu/kemaskini/'.$id);
			}
			
		}
    }
	
    public function hapus($id)
    {
        $pemandu  = LkpPemandu::where(['mykad'=>$id])->first();

		return view('pemandu.hapus', compact('pemandu'));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			$pemandu = new LkpPemandu;
			$pemandu->where('mykad', $id)
						->delete();
			
			$request->session()->flash('status', 'Maklumat pemandu berjaya dihapuskan.');
			return redirect('pemandu');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat pemandu tidak berjaya dihapuskan.');
			return redirect('pemandu/hapus/'.$id);
		}
    }

	public function jadual(Request $request)
    {
		// SELECT pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi, pk.lokasi_tujuan, pk.masa_balik, pk.id_jenis_perjalanan, pk.id_status, t.kenderaan_pergi, t.kenderaan_balik, MAX(t.id_tindakan), pk.id_maklumat_permohonan
		// 	FROM permohonan_kenderaan pk, tindakan t
		// 	where pk.id_maklumat_permohonan=t.id_permohonan
		// 	and pk.id_status=11
		// 	AND t.kenderaan_pergi IS NOT null
		// 	GROUP BY pk.id_maklumat_permohonan, t.kenderaan_pergi, t.kenderaan_balik, pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi,pk.masa_balik, pk.lokasi_tujuan, pk.id_jenis_perjalanan, pk.id_status
		// 	HAVING MAX(t.id_tindakan)
		// 	order by pk.tkh_pergi desc
		$Srhfield = ['tkh_dari'=>'', 'tkh_hingga'=>'' ];

		$maklumatJ=DB::select('SELECT t.kenderaan_pergi, t.kenderaan_balik, pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi, pk.masa_balik, pk.id_jenis_perjalanan, pk.lokasi_tujuan, pk.kod_permohonan, pk.id_maklumat_permohonan
						from permohonan_kenderaan pk
						join tindakan t on (pk.id_maklumat_permohonan=t.id_permohonan) 
						and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = pk.id_maklumat_permohonan and t1.id_status_tempah in (3,11))
						order by pk.tkh_pergi asc');

		$maklumats = collect($maklumatJ);
		// dd($maklumats);

		if(isset($_POST['tapis']))
		{
				 
		  $data = $request->input();

			if(strlen($data['tkh_dari']) > 0) { $maklumats = $maklumats->where('tkh_pergi','>=', $data['tkh_dari']); $Srhfield['tkh_dari']=$data['tkh_dari'];}
			if(strlen($data['tkh_hingga']) > 0) { $maklumats = $maklumats->where('tkh_pergi','<=', $data['tkh_hingga']); $Srhfield['tkh_hingga']=$data['tkh_hingga']; }
		}else{
			$maklumats = $maklumats->where('tkh_pergi','>=', date("Y-m-d"));
		}
		

		// dd($maklumats);
        return view('pemandu.jadual',compact('maklumats','Srhfield'));
    }


}
