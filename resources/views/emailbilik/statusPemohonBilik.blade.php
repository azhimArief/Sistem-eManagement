<!DOCTYPE html>
<html>
<style>
    body {
        font-family: "Arial", sans-serif;
        font-size:14px;
        text-align: justify;
    }
</style>
<head>
    <title>Emel kepada Pemohon</title>
</head>
<body>
    <p>Assalamualaikum dan Salam Perpaduan.<p>

    <p>YBhg. Datuk/Dato'/ YBrs. Dr/Tuan/Puan,</p>

    <!-- <h3>PERKARA: Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara</h3> -->

    <justify>
    <p>2. &emsp;&emsp;Adalah dimaklumkan status tempahan Bilik Mesyuarat Jabatan Kementerian Perpaduan Negara adalah seperti berikut:</p>

    <p> 
        <table width="900" border="0" style="border-collapse:collapse;  font-size:13px; text-align:left; margin:0px 0px 0px 40px;" cellpadding="3" >
            <tr>
                <th width="150" style="text-align:left">ID Tempahan</th>
                <td width="600"><strong>: {{ $content->kod_permohonan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Nama Pemohon</th>
                <td><strong>: {{ $content->nama }}</strong></td>
            </tr>
            <tr>
                
                <th style="text-align:left">Tarikh Permohonan</th>
                <td><strong>: {{ date('d/m/Y', strtotime($content->created_at)) }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Tujuan</th>
                <td><strong>: {{ \App\LkpTujuan::find($content->id_tujuan)->tujuan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Nama Bilik</th>
                @php  $biliks = \App\LkpBilik::where('id_bilik',$content->id_bilik)->first(); @endphp
                <td><strong>: {{ $biliks->bilik }}, Aras {{ $biliks->aras }} 
                    ({{ \App\PLkpBahagian::find( $biliks->id_bahagian )->bahagian }})</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Tarikh & Masa Mula</th> 
                <td><strong>: {{ Carbon\Carbon::parse($content->tkh_mula)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($content->masa_mula)->format('g:i A') }})</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Tarikh & Masa Tamat</th>
                <td><strong>: {{ Carbon\Carbon::parse($content->tkh_hingga)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($content->masa_hingga)->format('g:i A') }})</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Status Permohonan</th>
                <td><strong>: {{  \App\LkpStatus::find($content->id_status)->status }}</strong></td>
            </tr>
            @if($content->tempah_makan == 1)
                <tr>
                    <th style="text-align:left">Status Tempahan Makanan</th>
                    @php  $statusMakan = \App\Tindakan::where('id_permohonan', $content->id_permohonan_bilik)
                                                        ->orderBy('created_by', 'desc')
                                                        ->first(); 
                    @endphp
                    <td><strong>: {{  \App\LkpStatus::find($statusMakan->id_status_makan)->status }}</strong></td>
                </tr>
                <tr>
                    <th style="text-align:left; vertical-align: top;">Menu Makan  </th>
                    <?php 
                        //$menumakans = \App\MenuMakan::where('id_tempah_makan',$content->id_tempah_makan)->get(); 
                        $menuPagis = \App\MenuMakan::where('id_tempah_makan',$content->id_tempah_makan)->where('jenis_makan', 1)->get(); 
                        $menuTengaharis = \App\MenuMakan::where('id_tempah_makan',$content->id_tempah_makan)->where('jenis_makan', 2)->get(); 
                        $menuPetangs = \App\MenuMakan::where('id_tempah_makan',$content->id_tempah_makan)->where('jenis_makan', 3)->get(); 
                        $menuMalams = \App\MenuMakan::where('id_tempah_makan',$content->id_tempah_makan)->where('jenis_makan', 4)->get(); 
                    ?>
                    <td>
                        @if ($content->makan_pagi == 1)
                            <strong>: Makan Pagi</strong> <br> 
                            {{-- @foreach($menumakans as $menumakan)
                                @if ($menumakan->jenis_makan == 1)
                                    &nbsp;{{ $menumakan->menu }}, 
                                @endif     
                            @endforeach --}}
                             @foreach($menuPagis as $menuPagi)
                                @if ($loop->first)
                                    &nbsp;
                                @endif    
                                @if (($loop->iteration)+ 1 != $loop->last)
                                    {{ $menuPagi->menu }}, 
                                @endif     
                                @if (($loop->iteration)+ 1 == $loop->last)
                                    {{ $menuPagi->menu }}. 
                                @endif     
                            @endforeach
                            <br>
                        @endif
                        @if ($content->makan_tghari == 1)
                            <strong>: Makan Tengahari</strong> <br>
                            {{-- @foreach($menumakans as $menumakan)
                                @if ($menumakan->jenis_makan == 2)
                                    &nbsp;{{ $menumakan->menu }}, 
                                @endif     
                            @endforeach --}}
                            @foreach($menuTengaharis as $menuTengahari)
                                @if ($loop->first)
                                    &nbsp;
                                @endif    
                                @if (($loop->iteration)+ 1 != $loop->last)
                                    {{ $menuTengahari->menu }}, 
                                @endif     
                                @if (($loop->iteration)+ 1 == $loop->last)
                                    {{ $menuTengahari->menu }}. 
                                @endif    
                            @endforeach
                            <br>
                        @endif
                        @if ($content->minum_petang == 1)
                            <strong>: Minum Petang</strong> <br>
                            {{-- @foreach($menumakans as $menumakan)
                                @if ($menumakan->jenis_makan == 3)
                                    &nbsp;{{ $menumakan->menu }}, 
                                @endif     
                            @endforeach --}}
                           @foreach($menuPetangs as $menuPetang)
                                @if ($loop->first)
                                    &nbsp;
                                @endif    
                                @if (($loop->iteration)+ 1 != $loop->last)
                                    {{ $menuPetang->menu }}, 
                                @endif     
                                @if (($loop->iteration)+ 1 == $loop->last)
                                    {{ $menuPetang->menu }}. 
                                @endif   
                            @endforeach
                            <br>
                        @endif
                        @if ($content->makan_malam == 1)
                            <strong>: Makan Malam</strong> <br>
                            {{-- @foreach($menumakans as $menumakan)
                                @if ($menumakan->jenis_makan == 4)
                                    &nbsp;{{ $menumakan->menu }}, 
                                @endif     
                            @endforeach --}}
                            @foreach($menuMalams as $menuMalam)
                                @if ($loop->first)
                                    &nbsp;
                                @endif    
                                @if (($loop->iteration)+ 1 != $loop->last)
                                    {{ $menuMalam->menu }}, 
                                @endif     
                                @if (($loop->iteration)+ 1 == $loop->last)
                                    {{ $menuMalam->menu }}. 
                                @endif   
                            @endforeach
                            <br>
                        @endif
                    </td>
                </tr>
            @endif

        </table>
    </p>
  
    <p>Status tempahan Bilik Mesyuarat Jabatan juga boleh disemak melalui <a href="{{ url('') }}">Sistem eTempahan</a>.
    {{-- <p>Status tempahan Bilik Mesyuarat Jabatan juga boleh disemak melalui 
    <a href="{{ url('/pemohon/tempahanbilik/butiran/'. $content->id_permohonan_bilik .'/'. $content->id_pemohon ) }}">Sistem eTempahan</a>. --}}
    
    <p>3. &emsp;&emsp;Sebarang pertanyaan boleh dikemukakan dengan menyertakan ID Tempahan kepada Pegawai Bilik Mesyuarat seperti berikut:</p>
    </justify>
     <p>&emsp;&emsp;&emsp; Nama : Noraini Binti Yasin
    <br>&emsp;&emsp;&emsp; Tel : 03-8091 8119
    <br>&emsp;&emsp;&emsp; E-mel : norainiyasin@perpaduan.gov.my </p>
    <p>&emsp;&emsp;&emsp; Nama : Ahmad Shahiruddin Bin Kamaruddin
    <br>&emsp;&emsp;&emsp; Tel : 03-8091 8145
    <br>&emsp;&emsp;&emsp; E-mel : shahiruddin@perpaduan.gov.my </p>
    <p>Sekian, terima kasih.</p><br>
    <p><b> "MALAYSIA MADANI" </b></p>
    <p><b> "BERKHIDMAT UNTUK NEGARA" </b></p>
    <p><h7>
            Seksyen Pengurusan Kualiti dan Inovasi
        <br> Bahagian Khidmat Pengurusan
        <br> Kementerian Perpaduan Negara
        <br>
        <br>Tel: 03-8091 8119 / 8145
        <br>E-mel: norainiyasin@perpaduan.gov.my / shahiruddin@perpaduan.gov.my
    </h7></p>
    <p></p>
    <p><i>** E-mel ini dijana oleh Sistem eTempahan dan tidak perlu dibalas. **</i></p>
</body>
</html>