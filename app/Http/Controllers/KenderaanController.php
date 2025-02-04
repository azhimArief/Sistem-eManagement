<?php

namespace App\Http\Controllers;

use App\Kenderaan;
use App\LkpJenisKenderaan;
use App\LkpModel;
use App\LkpStatus;
use App\LkpPemandu;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use Illuminate\Http\Request;
use Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class KenderaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$Srhfield = ['jenis'=>''];
		$optionJenisKenderaans = LkpJenisKenderaan::get();		
		$kenderaans = Kenderaan::get();
						
		if(isset($_POST['tapis_kenderaan'])) {
		
			$data = $request->input();
			
			if(strlen($data['jenis']) > 0) { $kenderaans = $kenderaans->where('id_jenis',$data['jenis']); $Srhfield['jenis']=$data['jenis']; }
		}

        return view('kenderaan.senarai',compact('kenderaans','optionJenisKenderaans','Srhfield'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		$optionJeniskenderaans = LkpJenisKenderaan::get();		
		$optionPemandus = LkpPemandu::get();	
		$optionStatuss = LkpStatus::whereIn('id_status',['7','8','12'])->get();	
		$optionModels = LkpModel::get();
		
        return view('kenderaan.tambah', compact('optionJeniskenderaans','optionPemandus','optionStatuss','optionModels'));
    }
	
    public function simpan_tambah(Request $request)
    {
		$data = $request->input();

		$rules = [
			// 'mykad' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('kenderaan/tambah')->withInput();
			
		} else {
			
			try {

				$kenderaan = new Kenderaan;
				$kenderaan->id_model = $data['model'];
				$kenderaan->no_plat = $data['no_plat'];
				$kenderaan->pemandu = $data['pemandu'];
				$kenderaan->id_jenis = $data['jenis'];
				$kenderaan->Bil_penumpang = $data['Bil_penumpang'];
				$kenderaan->id_status = $data['status'];
				$kenderaan->catatan = $data['catatan'];
				$kenderaan->save();

				$id_kenderaan = $kenderaan->max('id_kenderaan');
				

				$request->session()->flash('status', 'Maklumat kenderaan berjaya disimpan.');
				return redirect('kenderaan/butiran/'.$id_kenderaan);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat kenderaan tidak berjaya disimpan.');
				return redirect('kenderaan/tambah')->withInput();
			}
			
		}
		
    }
	
    public function butiran($id)
    {
		
        $kenderaan  = Kenderaan::where(['id_kenderaan'=>$id])->first();	

		return view('kenderaan.butiran', compact('kenderaan'));
    }
	
    public function kemaskini($id)
    {
		$kenderaan = Kenderaan::where(['id_kenderaan'=>$id])->first();
		
		$optionJenisKenderaans = LkpJenisKenderaan::get();	
		$optionPemandus = LkpPemandu::get();	
		$optionStatuss = LkpStatus::whereIn('id_status',['7','8','12'])->get();	
		$optionModels = LkpModel::get();	
						
		return view('kenderaan.kemaskini', compact('kenderaan','optionJenisKenderaans','optionPemandus','optionStatuss','optionModels'));
    }
	
    public function simpan_kemaskini(Request $request, $id)
    {
		$data = $request->input();
		
		$rules = [
			// 'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('kenderaan/butiran/'.$id)->withInput();
			
		} else {
			
			try {
				
				$kenderaan = Kenderaan::where('id_kenderaan', $id)
							->update([
								'no_plat' => $data['no_plat'],
								'id_jenis' => $data['jenis'],
								'id_model' => $data['model'],
								'pemandu' => $data['nama_pemandu'],
								'Bil_penumpang' => $data['Bil_penumpang'],
								'id_status' => $data['status'],
								'catatan' => $data['catatan'],
							]);
				
				$request->session()->flash('status', 'Maklumat kenderaan berjaya disimpan.');
				return redirect('kenderaan/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat kenderaan tidak berjaya disimpan.');
				return redirect('kenderaan/butiran/'.$id);
			}
			
		}
    }
	
    public function hapus($id)
    {
        $kenderaan  = Kenderaan::where(['id_kenderaan'=>$id])->first();	

		return view('kenderaan.hapus', compact('kenderaan'));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			$kenderaan = new Kenderaan;
			$kenderaan->where('id_kenderaan', $id)
						->delete();
			
			$request->session()->flash('status', 'Maklumat kenderaan berjaya dihapuskan.');
			return redirect('kenderaan');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat kenderaan tidak berjaya dihapuskan.');
			return redirect('kenderaan/hapus/'.$id);
		}
    }
}
