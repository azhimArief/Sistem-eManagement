<?php

namespace App\Http\Controllers;

use App\PermohonanKenderaan;
use App\LkpPenerbitan;
use App\LkpStatusRisi;
use Illuminate\Http\Request;
use Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// $Srhfield = ['jenis'=>''];
		// $optionJenisPenerbitans = LkpPenerbitan::get();		
		// $penerbitans = Penerbitan::get();
						
		// if(isset($_POST['tapis_penerbitan'])) {
		
		// 	$data = $request->input();
			
		// 	if(strlen($data['jenis']) > 0) { $penerbitans = $penerbitans->where('jenis_penerbitan',$data['jenis']); $Srhfield['jenis']=$data['jenis']; }
		// }

		$getEvents = PermohonanKenderaan::select('id_maklumat_permohonan', 'tkh_pergi', 'tkh_balik')->get();
		$events = [];

		foreach ($getEvents as $values) {
			$start_time_format = $values->tkh_pergi;
			$end_time_format = $values->tkh_balik;
			$event = [];
			$event['title'] = $values->id_maklumat_permohonan;
			$event['start'] = $start_time_format;
			$event['end'] = $end_time_format;
			$events[] = $event;
			Debugbar::info($events);
		}

		return $events;
        // return view('pemantauan.senarai',compact('penerbitans','optionJenisPenerbitans','Srhfield'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		$optionJenisPenerbitans = LkpPenerbitan::get();		
		$optionStatuss = LkpStatusRisi::whereIn('id_status_risi', ['4','5'])->get();
		
        return view('pemantauan.tambah', compact('optionJenisPenerbitans','optionStatuss'));
    }
	
    public function simpan_tambah(Request $request)
    {
		$data = $request->input();
		
		if($request->hasFile('dokumen')){
			$file = $request->file('dokumen');			
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
			'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi dan dokumen tidak sah.");
			return redirect('pemantauan/tambah')->withInput();
			
		} elseif ($validator->fails() && $dokumenIns==1) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('pemantauan/tambah')->withInput();
			
		} elseif (!$validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed', 'dokumen tidak sah.');
			return redirect('pemantauan/tambah')->withInput();
			
		} else {
			
			try {
			
				if($request->hasFile('dokumen')) {
					$destinationPath = 'uploads\penerbitan';
					$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				} else {
					$path = '';
				}
				
				$penerbitan = new Penerbitan;
				$penerbitan->tajuk_penerbitan = $data['tajuk'];
				$penerbitan->no_siri = $data['no_siri'];
				$penerbitan->jenis_penerbitan = $data['jenis'];
				$penerbitan->keterangan = $data['keterangan'];
				$penerbitan->tarikh_kuatkuasa = Carbon\Carbon::parse($data['tkh_kuatkuasa'])->format('Y-m-d');
				$penerbitan->tkh_kemaskini = Carbon\Carbon::now();
				$penerbitan->kemaskini_oleh = 1;
				$penerbitan->path = $path;
				$penerbitan->save();
				
				$id_penerbitan = $penerbitan->max('id_penerbitan');
				$request->session()->flash('status', 'Maklumat Penerbitan berjaya disimpan.');
				return redirect('pemantauan/butiran/'.$id_penerbitan);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat Penerbitan tidak berjaya disimpan.');
				return redirect('pemantauan/tambah');
			}
			
		}
    }
	
    public function butiran($id)
    {
        $penerbitan = new Penerbitan;
		$penerbitan  = $penerbitan
						->select('*', 'risi.penerbitan.jenis_penerbitan AS id_jenis_penerbitan')
						->where(['id_penerbitan'=>$id])
						->leftjoin('lkp_penerbitan', 'risi.penerbitan.jenis_penerbitan', '=', 'risi.lkp_penerbitan.id_jenis_penerbitan')
						->first();
		return view('pemantauan.butiran', compact('penerbitan'));
    }
	
    public function kemaskini($id)
    {
		$LkpPenerbitan = new LkpPenerbitan;
		$options  = $LkpPenerbitan->get();
		
        $penerbitan = new Penerbitan;
		$penerbitan  = $penerbitan
						->where(['id_penerbitan'=>$id])
						->first();
						
		return view('pemantauan.kemaskini', compact('penerbitan','options'));
    }
	
    public function simpan_kemaskini(Request $request, $id)
    {
		$data = $request->input();
		
		if($request->hasFile('dokumen')){
			$file = $request->file('dokumen');			
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
			'tajuk' => 'required|string|min:3|max:255'
			//'email' => 'required|string|email|max:255'
		];
		
		$validator = Validator::make($request->all(),$rules);
		
		if ($validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi dan dokumen tidak sah.");
			return redirect('pemantauan/tambah')->withInput();
			
		} elseif ($validator->fails() && $dokumenIns==1) {
			
			$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
			return redirect('pemantauan/tambah')->withInput();
			
		} elseif (!$validator->fails() && $dokumenIns==0) {
			
			$request->session()->flash('failed', 'dokumen tidak sah.');
			return redirect('pemantauan/tambah')->withInput();
			
		} else {
			
			try {
			
				if($request->hasFile('dokumen')) {
					$destinationPath = 'uploads\penerbitan';
					$path = $file->move($destinationPath,Str::random(10).'_'.$file->getClientOriginalName());
				} else {
					$path = '';
				}
				
				$penerbitan = new Penerbitan;
				
				if($path=='') { $path = $penerbitan->where(['id_penerbitan'=>$id])->first()->path; }
				
				$penerbitan->where('id_penerbitan', $id)
							->update([
								'tajuk_penerbitan' => $data['tajuk'],
								'no_siri' => $data['no_siri'],
								'jenis_penerbitan' => $data['jenis'],
								'keterangan' => $data['keterangan'],
								'tarikh_kuatkuasa' => Carbon\Carbon::parse($data['tkh_kuatkuasa'])->format('Y-m-d'),
								'tkh_kemaskini' => Carbon\Carbon::now(),
								'kemaskini_oleh' => '1',
								'path' => $path
							]);
				
				$request->session()->flash('status', 'Maklumat Penerbitan berjaya disimpan.');
				return redirect('pemantauan/butiran/'.$id);
			
			} catch(Exception $e){
				$request->session()->flash('failed', 'Maklumat Penerbitan tidak berjaya disimpan.');
				return redirect('pemantauan/tambah');
			}
			
		}
    }
	
    public function hapus($id)
    {
        $penerbitan = new Penerbitan;
		$penerbitan  = $penerbitan
						->select('*', 'risi.penerbitan.jenis_penerbitan AS id_jenis_penerbitan')
						->where(['id_penerbitan'=>$id])
						->leftjoin('lkp_penerbitan', 'risi.penerbitan.jenis_penerbitan', '=', 'risi.lkp_penerbitan.id_jenis_penerbitan')
						->first();
		return view('pemantauan.hapus', compact('penerbitan'));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			$penerbitan = new Penerbitan;
			$penerbitan->where('id_penerbitan', $id)
						->delete();
			
			$request->session()->flash('status', 'Maklumat Penerbitan berjaya dihapuskan.');
			return redirect('penerbitan');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat Penerbitan tidak berjaya dihapuskan.');
			return redirect('pemantauan/hapus/'.$id);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
