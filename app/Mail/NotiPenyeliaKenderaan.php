<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotiPenyeliaKenderaan extends Mailable
{
    use Queueable, SerializesModels;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        // dd($details);
    } 

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from('pentadbirsistem.mybooking@perpaduan.gov.my')->subject('Permohonan Kenderaan')->view('email.notiPenyeliaKenderaan')->with('data', $this->data);
    }
}
