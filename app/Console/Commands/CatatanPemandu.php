<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use DB;
use App\Penumpang;
use App\PermohonanKenderaan;
use App\LkpPemandu;
use App\Kenderaan;
use App\Tindakan;

class CatatanPemandu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendPemandu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Catatan Pemandu';

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
        

		$perjalanans=DB::select('SELECT t.kenderaan_pergi, t.kenderaan_balik, pk.tkh_pergi, pk.tkh_balik, pk.masa_pergi, pk.masa_balik, pk.id_jenis_perjalanan, pk.id_maklumat_permohonan, pk.kod_permohonan, pk.lokasi_tujuan, pk.id_negeri
        from permohonan_kenderaan pk
        join tindakan t on (pk.id_maklumat_permohonan=t.id_permohonan 
        and t.id_tindakan = (SELECT MAX(t1.id_tindakan) FROM tindakan t1 WHERE t1.id_permohonan = pk.id_maklumat_permohonan and t1.id_status_tempah in (3,11)))  
        where pk.tkh_pergi=CURRENT_DATE');

		foreach($perjalanans as $perjalanan){
			if($perjalanan->id_jenis_perjalanan==1 || $perjalanan->kenderaan_pergi==$perjalanan->kenderaan_balik){
				//pergi sahaja or pemandu sama
                
                // $contentEmel=$perjalanan;
				$pemandu=Kenderaan::where('id_kenderaan',$perjalanan->kenderaan_pergi)
									->join('lkp_pemandu','lkp_pemandu.mykad','=','kenderaan.pemandu')
									->first();
									
				//emel catatan
                Mail::send('email/catatan', ['content' => $perjalanan], function ($header) use ($perjalanan,$pemandu)
                {
                    $header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
                    $header->to('asnidamj@perpaduan.gov.my', $pemandu->nama_pemandu); 
                    // SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
                    $header->subject('PERKARA: Maklum Balas Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
                });
				
			}else{
                // $contentEmel=$perjalanan;
				$pemanduPergi=Kenderaan::where('id_kenderaan',$perjalanan->kenderaan_pergi)
									->join('lkp_pemandu','lkp_pemandu.mykad','=','kenderaan.pemandu')
									->first();

			
                //emel catatanPergi
                Mail::send('email/catatanPergi', ['content' => $perjalanan], function ($header) use ($perjalanan,$pemanduPergi)
                {
                    $header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
                    $header->to('asnidamj@perpaduan.gov.my', $pemanduPergi->nama_pemandu); 
                    // SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
                    $header->subject('PERKARA: Maklum Balas Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
                });
					
				$pemanduBalik=Kenderaan::where('id_kenderaan',$perjalanan->kenderaan_balik)
					->join('lkp_pemandu','lkp_pemandu.mykad','=','kenderaan.pemandu')
					->first();

                //emel catatanBalik
                Mail::send('email/catatanBalik', ['content' => $perjalanan], function ($header) use ($perjalanan,$pemanduBalik)
                {
                    $header->from('no_reply@perpaduan.gov.my', 'Sistem eTempahan');
                    $header->to('asnidamj@perpaduan.gov.my', $pemanduBalik->nama_pemandu); 
                    // SUBJECT boleh hardcode terus, xperlu request input (di bawah ni contoh saja)
                    $header->subject('PERKARA: Maklum Balas Pemandu Kenderaan Jabatan Kementerian Perpaduan Negara');
                });
				
			}
			
		}

        return 0;
    }
}
