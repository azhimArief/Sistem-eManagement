<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Penumpang;
use App\PermohonanKenderaan;

class BorangPenilaian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendPenilaian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Borang Penilaian';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $penumpangs = Penumpang::join('permohonan_kenderaan', 'permohonan_kenderaan.id_maklumat_permohonan', '=', 'penumpang.id_tempahan')
                    ->where('permohonan_kenderaan.tkh_pergi', date("Y-m-d"))
                    ->whereIn('permohonan_kenderaan.id_status',[3,11])
                    ->get();
  
        if ($penumpangs->count() > 0) {
            foreach ($penumpangs as $penumpang) {
                // $contentEmel=PermohonanKenderaan::where('id_maklumat_permohonan',$penumpang->id_tempahan)->first();
                // $contentEmel=PermohonanKenderaan::select('permohonan_kenderaan.*','penumpang.mykad')
                //     ->join('penumpang','permohonan_kenderaan.id_maklumat_permohonan','penumpang.id_tempahan')
                //     ->where('id_maklumat_permohonan',$penumpang->id_tempahan)
                //     ->where('mykad',$penumpang->mykad)
                //     ->first();
                // dd($contentEmel);
                Mail::send('email/penilaian', ['content' => $penumpang], function ($header) use ($penumpang)
                {
                    $header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
                    $header->to($penumpang->emel, $penumpang->nama); //emel penumpang
                    // SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
                    $header->subject('PERKARA: Penilaian Perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara');
                });

            
                // Mail::to($penumpang->emel)->send(new BirthDayWish($penumpang));
            }
        }

        

        return 0;
    }
}
