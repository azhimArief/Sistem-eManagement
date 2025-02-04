<?php

namespace App\Http\Controllers;

use App\User;
use App\PInfoJawatan;
use App\PPersonel;
use App\PLkpBahagian;
use App\LkpStatus;
use App\LkpAccess;
use Illuminate\Http\Request;
use Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$Srhfield = ['status'=>''];
		$optStatusUsers = LkpStatus::whereIn('id_status', ['9','10'])->get();
		$users  = User::orderBy('nama')->get();
		
		if(isset($_POST['tapis_pengguna'])) {
		
			$data = $request->input();
			
			if(strlen($data['status']) > 0) { $users = $users->where('status_akaun',$data['status']); $Srhfield['status']=$data['status']; }
		}

        return view('pengguna.senarai',compact('users','optStatusUsers','Srhfield'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
		$optStatusUsers = LkpStatus::whereIn('id_status', ['9','10'])->get();
		$optAccesss = LkpAccess::get();
		
        return view('pengguna.tambah', compact('optStatusUsers','optAccesss'));
    }
	
    public function simpan_tambah(Request $request)
    {
		$data = $request->input();

		if(isset($_POST['semak_mykad'])) {
			
			$users=User::where(['mykad'=>$data['mykad']])->first();
			
			if(strlen($users)==0) {
				$personel=PPersonel::where(['nokp'=>$data['mykad']])->first();
				
				if(strlen($personel)==0) {
					$request->session()->flash('failed', 'No. Mykad tiada dalam pangkalan data');
					return redirect('pengguna/tambah')->withInput();
				} else {
					
					//$xemel = explode('@',$personel['emel']);
					$newdata = array(
						//'nama'=>PPersonel::find($personel['nokp'])->name,
						'nama'=>$personel->name,
						'bahagian'=>PLkpBahagian::find($personel['bahagian_id'])->bahagian,
						'jawatan'=>$personel['jawatan'],
						'gred'=>$personel['gred'],
						'emel'=>$personel['email'],
						'mykad'=>$data['mykad']
					);
					$data = array_replace($data,$newdata);
					
					return redirect('pengguna/tambah')->withInput($data);
				}
			} else {
				$request->session()->flash('failed', 'No. Mykad telah wujud.');
				return redirect('pengguna/tambah')->withInput();
			}
			
			
		} elseif(isset($_POST['submit_pengguna'])) {

			$rules = [
				'mykad' => 'required|string|min:3|max:255'
				//'email' => 'required|string|email|max:255'
			];
			
			$validator = Validator::make($request->all(),$rules);
			
			if ($validator->fails()) {
				
				$request->session()->flash('failed',"Ruangan bertanda * wajib diisi.");
				return redirect('pengguna/tambah')->withInput();
				
			} else {
				
				try {
					
					$users = new User;
					//$users->id_pengguna = $data['id_pengguna'];
					$users->mykad = $data['mykad'];
					$users->nama = $data['nama'];
					$users->bahagian = $data['bahagian'];
					$users->email = $data['emel'];
					$users->jawatan = $data['jawatan'];
					$users->gred = $data['gred'];
					$users->password = Hash::make($data['kata_laluan']);
					$users->status_akaun = $data['status'];
		         	$users->id_access = $data['peranan'];	
					$users->updated_at = Carbon\Carbon::now();
					$users->created_at = Carbon\Carbon::now();
					$users->save();
					
					$id_user = $users->max('id');
					
					$request->session()->flash('status', 'Maklumat pengguna berjaya disimpan.');
					return redirect('pengguna/butiran/'.$id_user);
				
				} catch(Exception $e){
					$request->session()->flash('failed', 'Maklumat pengguna tidak berjaya disimpan.');
					return redirect('pengguna/tambah')->withInput();
				}
				
			}
		}
    }
	
    public function butiran($id)
    {
        $user  = User::where(['id'=>$id])->first();	
						
		return view('pengguna.butiran', compact('user'));
    }
	
    public function kemaskini($id)
    {
		$user  = User::where(['id'=>$id])->first();	
		
        $optStatusUsers = LkpStatus::whereIn('id_status', ['9','10'])->get();
		$optAccesss = LkpAccess::get();
		
        return view('pengguna.kemaskini', compact('user','optStatusUsers','optAccesss'));
    }
	
    public function simpan_kemaskini(Request $request, $id)
    {
		$data = $request->input();
		
		try {
			
			if($data['kata_laluan'] != '') {
				$updPass = Hash::make($data['kata_laluan']);
			} else {
				$updPass = User::find($id)->password;
			}
			
			User::where('id', $id)
						->update([
							'password' => $updPass,
							'status_akaun' => $data['status'],
							'id_access' => $data['peranan'],
							'updated_at' => Carbon\Carbon::now()
						]);
			
			$request->session()->flash('status', 'Maklumat Pengguna berjaya disimpan.');
			return redirect('pengguna/butiran/'.$id);
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat Pengguna tidak berjaya disimpan.');
			return redirect('pengguna/tambah');
		}
    }
	
    public function hapus($id)
    {
        $user  = User::where(['id'=>$id])->first();	
						
		return view('pengguna.hapus', compact('user'));
    }
	
    public function simpan_hapus(Request $request, $id)
    {
		try {			
			User::where('id', $id)->delete();
			
			$request->session()->flash('status', 'Maklumat Pengguna berjaya dihapuskan.');
			return redirect('pengguna');
		
		} catch(Exception $e){
			$request->session()->flash('failed', 'Maklumat Pengguna tidak berjaya dihapuskan.');
			return redirect('pengguna/hapus/'.$id);
		}
    }
}
