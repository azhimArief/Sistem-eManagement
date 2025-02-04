<?php

namespace App\Http\Controllers;

use App\LkpKaterer;
use App\LkpModel;
use App\LkpStatus;
use App\LkpPemandu;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use Illuminate\Http\Request;
use Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class KatererController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$Srhfield = ['jenis'=>''];
		//$katerers = LkpKaterer::whereNotIn('id_katerer',['24','25'])->get();
		$katerers = LkpKaterer::get();
		// dd($katerers);
						
		if(isset($_POST['tapis_katerer'])) {
		
			$data = $request->input();
			
			if(strlen($data['jenis']) > 0) { $katerers = $katerers->where('id_jenis',$data['jenis']); $Srhfield['jenis']=$data['jenis']; }
		}

        return view('katerer.senarai',compact('katerers','Srhfield'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {

        return view('katerer.tambah');
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
			return redirect('katerer/tambah')->withInput();
			
		} else {
			
			// try {
				//if ada gambar
				// if($request->hasFile('gambar_katerer')) {
				// 	$file = $request->file('gambar_katerer');
				// 	$destinationPath = 'uploads/katerer';
				// 	$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				// } else {
				// 	$path = '';
				// }


				$katerer = new LkpKaterer();
				$katerer->nama_katerer = $data['nama_katerer'];
				$katerer->alamat  = $data['alamat'];
				$katerer->person_in_charge  = $data['person'];
				$katerer->emel  = $data['emel'];
				$katerer->no_tel_katerer  = $data['notel'];
				$katerer->tkh_mula  = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
				$katerer->tkh_tamat = Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d');
				$katerer->save();

				$id_katerer = $katerer->max(	'id_katerer');
				

				$request->session()->flash('status', 'Maklumat katerer berjaya disimpan.');
				return redirect('katerer/butiran/'.$id_katerer);
			
			// } 
			// catch(Exception $e){
			// 	$request->session()->flash('failed', 'Maklumat katerer tidak berjaya disimpan.');
			// 	return redirect('katerer/tambah')->withInput();
			// }
			
		}
		
    }
	
    public function butiran($id)
    {
		
        $katerers  = LkpKaterer::where(['id_katerer'=>$id])->first();	

		return view('katerer.butiran', compact('katerers'));
    }
	
    public function kemaskini($id)
    {
		$katerers = LkpKaterer::where(['id_katerer'=>$id])->first();
				
		return view('katerer.kemaskini', compact('katerers'));
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
			return redirect('katerer/butiran/'.$id)->withInput();
			
		} else {
			
			// try {

					LkpKaterer::where('id_katerer', $id)
							   ->update([
								'nama_katerer' => $data['nama_katerer'],
								'alamat' => $data['alamat'],
								'person_in_charge' => $data['person'],
								'emel' => $data['emel'],
								'no_tel_katerer' => $data['notel'],
								'tkh_mula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
								'tkh_tamat' => Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d'),
							]);
				
				$request->session()->flash('status', 'Maklumat katerer berjaya disimpan.');
				return redirect('katerer/butiran/'.$id);
			
			//} 
			// catch(Exception $e){
			// 	$request->session()->flash('failed', 'Maklumat katerer tidak berjaya disimpan.');
			// 	return redirect('katerer/butiran/'.$id);
			// }
			
		}
    }
	
    public function hapus($id)
    {
        $katerers  = LkpKaterer::where(['id_katerer'=>$id])->first();	

		return view('katerer.hapus', compact('katerers'));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			$katerer = new LkpKaterer;
			$katerer->where('id_katerer', $id)
						->delete();
			
			$request->session()->flash('status', 'Maklumat katerer berjaya dihapuskan.');
			return redirect('katerer');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat katerer tidak berjaya dihapuskan.');
			return redirect('katerer/hapus/'.$id);
		}
    }
}
