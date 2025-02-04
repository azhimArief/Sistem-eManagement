<?php

namespace App\Http\Controllers;

use App\LkpBilik;
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

class BilikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$Srhfield = [ 'pilihAras'=> '' ];
		//$biliks = LkpBilik::whereNotIn('id_bilik',['24','25'])->get();
		$biliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
				->get();
		// dd($biliks);
						
		if(isset($_POST['tapis_bilik'])) {
		
			$data = $request->input();
			if (isset($data['pilihAras'])) {
				if(strlen($data['pilihAras']) > 0) { $biliks = $biliks->where('aras',$data['pilihAras']); $Srhfield['pilihAras']=$data['pilihAras']; }
			}
			
		}

        return view('bilik.senarai',compact('biliks','Srhfield'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		$optBahagians = PLkpBahagian::get();

        return view('bilik.tambah', compact('optBahagians'));
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
			return redirect('bilik/tambah')->withInput();
			
		} else {
			
			// try {
				//if ada gambar
				if($request->hasFile('gambar_bilik')) {
					$file = $request->file('gambar_bilik');
					$destinationPath = 'uploads/bilik';
					$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				} else {
					$path = '';
				}


				$bilik = new LkpBilik();
				$bilik->bilik = $data['nama_bilik'];
				$bilik->id_bahagian  = $data['bahagian'];
				$bilik->aras = $data['aras'];
				$bilik->kapasiti_bilik = $data['kapasiti'];
				$bilik->kemudahan_bilik = $data['kemudahan'];
				$bilik->gambar_bilik =  $path;
				$bilik->save();

				$id_bilik = $bilik->max('id_bilik');
				

				$request->session()->flash('status', 'Maklumat bilik berjaya disimpan.');
				return redirect('bilik/butiran/'.$id_bilik);
			
			// } 
			// catch(Exception $e){
			// 	$request->session()->flash('failed', 'Maklumat bilik tidak berjaya disimpan.');
			// 	return redirect('bilik/tambah')->withInput();
			// }
			
		}
		
    }
	
    public function butiran($id)
    {
		
        $biliks  = LkpBilik::where(['id_bilik'=>$id])->first();	

		return view('bilik.butiran', compact('biliks'));
    }
	
    public function kemaskini($id)
    {
		$biliks = LkpBilik::where(['id_bilik'=>$id])->first();
		$optBahagians = PLkpBahagian::get();
		// $biliks = LkpBilik::join('personel.bahagian', 'personel.bahagian.id', '=', 'lkp_bilik.id_bahagian')
		// 		->where(['id_bilik', $id])
		// 		->first();
		
		
		return view('bilik.kemaskini', compact('biliks', 'optBahagians'));
    }
	
    public function simpan_kemaskini(Request $request, $id)
    {
		$data = $request->input();

		if ( isset($_POST['buang_gambar']) ) { //Buang Gambar
			LkpBilik::where('id_bilik', $id)
							->update([
								'bilik' => $data['nama_bilik'],
								'id_bahagian' => $data['bahagian'],
								'aras' => $data['aras'],
								'kapasiti_bilik' => $data['kapasiti'],
								'kemudahan_bilik' => $data['kemudahan'],
								'gambar_bilik' => '',
							]);
			
			return redirect('/bilik/kemaskini/'. $id);
		}
		
		$rules = [
			// 'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails()) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('bilik/butiran/'.$id)->withInput();
			
		} else {
			
			// try {
				
				if($request->hasFile('gambar_bilik')) {
					$file = $request->file('gambar_bilik');
					$destinationPath = 'uploads/bilik';
					$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				} else {
					$path = '';
				}
				
				if ($path == ""){
					LkpBilik::where('id_bilik', $id)
							->update([
								'bilik' => $data['nama_bilik'],
								'id_bahagian' => $data['bahagian'],
								'aras' => $data['aras'],
								'kapasiti_bilik' => $data['kapasiti'],
								'kemudahan_bilik' => $data['kemudahan'],
								//'gambar_bilik' => $path,
							]);
				}
				else {
					LkpBilik::where('id_bilik', $id)
							->update([
								'bilik' => $data['nama_bilik'],
								'id_bahagian' => $data['bahagian'],
								'aras' => $data['aras'],
								'kapasiti_bilik' => $data['kapasiti'],
								'kemudahan_bilik' => $data['kemudahan'],
								'gambar_bilik' => $path,
							]);
				}
				
				
				$request->session()->flash('status', 'Maklumat bilik berjaya disimpan.');
				return redirect('bilik/butiran/'.$id);
			
			//} 
			// catch(Exception $e){
			// 	$request->session()->flash('failed', 'Maklumat bilik tidak berjaya disimpan.');
			// 	return redirect('bilik/butiran/'.$id);
			// }
			
		}
    }
	
    public function hapus($id)
    {
        $biliks  = LkpBilik::where(['id_bilik'=>$id])->first();	

		return view('bilik.hapus', compact('biliks'));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			$bilik = new LkpBilik;
			$bilik->where('id_bilik', $id)
						->delete();
			
			$request->session()->flash('status', 'Maklumat bilik berjaya dihapuskan.');
			return redirect('bilik');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat bilik tidak berjaya dihapuskan.');
			return redirect('bilik/hapus/'.$id);
		}
    }
}
