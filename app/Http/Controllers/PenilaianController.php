<?php

namespace App\Http\Controllers;

use App\PermohonanKenderaan;
use App\Kenderaan;
use App\Penilaian;
use App\LkpSoalan;
use App\LkpJenisKenderaan;
use App\LkpModel;
use App\LkpStatus;
use App\LkpPemandu;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use Illuminate\Http\Request;
use Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PenilaianController extends Controller
{
	public function penilaiankenderaan($id)
    {
		$lkpSoalans = LkpSoalan::get();
		$permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan',$id)->first();
		
        return view('penilaian.kenderaan', compact('lkpSoalans','permohonanKenderaan'));
    }

	public function simpan_penilaiankenderaan(Request $request, $id)
    {
		// $data = $request->input();
		
		$rules = [
			// 'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
			'skala' => 'required',
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Semua ruangan wajib diisi.");
			return redirect('penilaian/penilaiankenderaan/'.$id)->withInput();
			
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
					$penilaian->id_maklumat_permohonan = $id;
					$penilaian->mykad_penumpang = Auth::user()->mykad;
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
				
				$request->session()->flash('status', 'Borang penilaian berjaya disimpan.');
				return redirect('tempahankenderaan');
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Borang penilaian tidak berjaya disimpan.');
				return redirect('penilaian/penilaiankenderaan/'.$id)->withInput();
			}
			
		}
    }
    public function catatanpemandu($id)
    {
        $permohonanKenderaan = PermohonanKenderaan::where('id_maklumat_permohonan',$id)->first();

		return view('penilaian.catatan', compact('permohonanKenderaan'));
    }
	
    public function simpan_catatanpemandu(Request $request, $id)
    {
		$data = $request->input();

		$rules = [
			// 'mykad' => 'required|string|min:3|max:255'
			'komen_pemandu' => 'required'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('penilaian/catatanpemandu/'.$id)->withInput();
			
		} else {
			
			try {

				$penilaian = new Penilaian;
				$penilaian->id_maklumat_permohonan = $id;
				$penilaian->mykad_pemandu = Auth::user()->mykad;
				$penilaian->komen_pemandu = $data['komen_pemandu'];
				$penilaian->created_at = Carbon\Carbon::now();
				$penilaian->updated_at = Carbon\Carbon::now();
				$penilaian->save();


				$request->session()->flash('status', 'Catatan pemandu berjaya disimpan.');
				return redirect('tempahankenderaan');
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Catatan pemandu tidak berjaya disimpan.');
				return redirect('penilaian/catatanpemandu/'.$id)->withInput();
			}
			
		}
    }
    public function borang()
    {
	
		$lkpSoalans = LkpSoalan::get();
		
        return view('penilaian.borang', compact('lkpSoalans'));
    }
	
    public function catatan_pemandu()
    {
		
        return view('penilaian.penilaianpemandu');
    }

    public function simpan_tambah(Request $request)
    {
		
		
    }
	
}