<?php

namespace App\Http\Controllers;

use App\User;
use App\UserEkapp;
use App\Content;
use App\Answer;
use DB;
use PDF;
use App\Skor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class EkappController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // $user = User::all();
      
        // $data = userEkapp::select('user_id','created_at')->groupBy('user_id','created_at')->get();
       
        // // dd($data);

        // return view ('ekapp.index',compact ('data'));

        
        $user_ekapp = DB::table('user_ekapp')
        ->select(DB::raw('users.name as name'),DB::raw('users.id as id'),DB::raw('user_ekapp.user_id as user_id'),DB::raw('pertubuhan.nama as organization'), DB::raw('SUM(score) as total_score'),DB::raw('user_ekapp.created_at as created_at'), DB::raw("DATE_FORMAT(user_ekapp.created_at, '%Y-%m-%d') as date"))
        ->join('users','users.id','=','user_ekapp.user_id')
        ->join('pertubuhan','users.organization','=','pertubuhan.id')
        ->where('users.id','=',auth()->user()->id)
        ->groupBy('user_ekapp.user_id','date')
        ->orderBydesc('date')
        ->get();

       

        $count = $user_ekapp->count();

        $skor = Skor::get(['sum_skor','remarks']);

        return view('ekapp.index' ,compact('user_ekapp','count','skor'));
    
    }

    public function create(){
        // $data = userEkapp::select('user_id','created_at')->groupBy('user_id','created_at')->get();
        // $soalan = Content::where('id','>=','55')->where('id','<=','80')->get();
        $soalan = Content::where('id','>=','55')->where('id','<=','64')->get();
        $pilihan = Answer::all();

        // dd($pilihan);
        // $id = $soalan->get()->id;
        
        //    dd($soalan);
        // $pilihan = DB::table('answers')->where('content_id',);
     
        return view ('ekapp.create',compact ('soalan','pilihan'));
    }

    public function store(Request $request){
        
        foreach($request->content_id as  $i=>$t){

            $this->validate(request(), [
    
                'pili' => 'required',
    
            ]);
            $res = Answer::where('id','=',$request->pili[$i])->first()->name;

            if($res == $request->jawapan[$i] ){
                $score = 1;
            }else{
                $score = 0;
            }
            // dd($res,$request->jawapan[$i],$score);
            $data = UserEkapp::create([
                'content_id' => $t,
                'user_id' =>  auth()->user()->id,
                'score' =>  $score,
                // 'replacement_id' => $request->input('partreplacement_id'),
                'user_answer' => $request->pili[$i],
                // dd($t),

                ]);

        }

        return redirect('/admin/ekapp/create/2')->with('flash_message_success', 'Soalan 1-10 berjaya disimpan!');
    }

    public function create2(){
        // $data = userEkapp::select('user_id','created_at')->groupBy('user_id','created_at')->get();
        $soalan = Content::where('id','>=','65')->where('id','<=','74')->get();
        $pilihan = Answer::all();
     
        return view ('ekapp.create2',compact ('soalan','pilihan'));
    }

    public function store2(Request $request){

        foreach($request->content_id as  $i=>$t){
            $this->validate(request(), [
    
                'pili' => 'required',
    
            ]);
            $res = Answer::where('id','=',$request->pili[$i])->first()->name;

            if($res == $request->jawapan[$i] ){
                $score = 1;
            }else{
                $score = 0;
            }

            $data = UserEkapp::create([
                'content_id' => $t,
                'user_id' =>  auth()->user()->id,
                'score' =>  $score,
                'user_answer' => $request->pili[$i],

                ]);
        }

        return redirect('/admin/ekapp/create/3')->with('flash_message_success', 'Soalan 11-20 berjaya disimpan!');
    }

    public function create3(){
        // $data = userEkapp::select('user_id','created_at')->groupBy('user_id','created_at')->get();
        $soalan = Content::where('id','>=','75')->where('master_id','=','4')->get();
        $pilihan = Answer::all();
     
        return view ('ekapp.create3',compact ('soalan','pilihan'));
    }

    public function store3(Request $request){

        foreach($request->content_id as  $i=>$t){

            $this->validate(request(), [
    
                'pili' => 'required',
    
            ]);
            $res = Answer::where('id','=',$request->pili[$i])->first()->name;

            if($res == $request->jawapan[$i] ){
                $score = 1;
            } else{
                $score = 0;
            }

            $data = UserEkapp::create([
                'content_id' => $t,
                'user_id' =>  auth()->user()->id,
                'score' =>  $score,
                'user_answer' => $request->pili[$i],

                ]);
        }
        
        return redirect('/admin/ekapp')->with('flash_message_success', 'Soalan 21-26 berjaya disimpan!');
    }
   
    public function show(){
        // $data = userEkapp::select('user_id','created_at')->groupBy('user_id','created_at')->get();
        $soalan = Content::all();
        $pilihan = Answer::all();
        // dd($pilihan);
        // $id = $soalan->get()->id;
        
//    dd($soalan);
        // $pilihan = DB::table('answers')->where('content_id',);
     
        return view ('ekapp.index',compact ('soalan','pilihan'));
    }

   
	public function generatePDF($id)
    {
        $user = User::findOrFail($id);
        $name =auth()->user()->name;
        $ic = auth()->user()->staff_ic;
        $pdf = PDF::loadView('pdf.sijil', compact('name','ic'));
            return $pdf->stream('Sijil.pdf');
    }
}
