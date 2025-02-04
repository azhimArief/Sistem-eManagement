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
    <title>Emel kepada Pentadbir</title>
</head>
<body>
    <p>Assalamualaikum dan Salam Perpaduan.<p>

    <p>Tuan/Puan,</p>

    <!-- <h3>PERKARA: Permohonan Tempahan Kenderaan Jabatan Kementerian Perpaduan Negara</h3> -->

    <justify>
    <p>Terdapat permohonan baru untuk tempahan kenderaan Jabatan Kementerian Perpaduan Negara. Maklumat tempahan adalah seperti berikut:</p>

    <p>
        <table width="400" border="0" style="border-collapse:collapse;  font-size:13px; text-align:left; margin:0px 0px 0px 10px;" cellpadding="3" >
            <tr>
                <th width="150">Kod Permohonan</th>
                <td width="250"><strong>: {{ $content->kod_permohonan }}</strong></td>
            </tr>
            <tr>
                <th>Nama Pemohon</th>
                <td><strong>: {{ $content->nama }}</strong></td>
            </tr>
            <tr>
                <th>Tarikh Permohonan</th>
                <td><strong>: {{ date('d.m.Y', strtotime($content->created_by)) }}</strong></td>
            </tr>
            <tr>
                <th>Tujuan</th>
                <td><strong>: {{ \App\LkpTujuan::find($content->id_tujuan)->tujuan }}</strong></td>
            </tr>
            <tr>
                <th>Jenis Perjalanan</th>
                <td><strong>: {{ \App\LkpJenisPerjalanan::find($content->id_jenis_perjalanan)->jenis_perjalanan }}</strong></td>
            </tr>
            <tr>
                <th>Tarikh Pergi</th>
                <td><strong>: {{  Carbon\Carbon::parse($content->tkh_pergi)->format('d.m.Y') }}</strong></td>
            </tr>
            <tr>
                <th>Tarikh Pulang</th>
                <td><strong>: {{ ($content->tkh_balik!='') ? Carbon\Carbon::parse($content->tkh_balik)->format('d.m.Y') : '-' }}</strong></td>
            </tr>
        </table>
        <!-- &emsp; ID Tempahan : {{ $content->kod_permohonan }} 
   <br> &emsp; Nama Pemohon : {{ $content->nama }}
   <br> &emsp; Tarikh Permohonan : {{ $content->created_by }}
   <br> &emsp; Tujuan : {{ \App\LkpTujuan::find($content->id_tujuan)->tujuan }}
   <br> &emsp; Jenis Perjalanan : {{ \App\LkpJenisPerjalanan::find($content->id_jenis_perjalanan)->jenis_perjalanan }}    
   <br> &emsp; Tarikh Pergi : {{ Carbon\Carbon::parse($content->tkh_pergi)->format('d.m.Y') }}    
   <br> &emsp; Tarikh Pulang : {{ ($content->tkh_balik!='') ? Carbon\Carbon::parse($content->tkh_balik)->format('d.m.Y') : '-' }}     -->
    </p>

    <p>Sila log masuk ke <a href="devaplikasi.perpaduan.gov.my/mybooking">Sistem MyBooking</a> untuk menyemak dan memproses permohonan tersebut.
    <!-- <p>Sebarang pertanyaan boleh dikemukakan dengan menyertakan ID Tempahan kepada Pegawai Kenderaan seperti berikut:</p> -->
    </justify>
  
    <p>Sekian, terima kasih.</p><br>
    <p><b> "WAWASAN KEMAKMURAN BERSAMA 2030" </b></p>
    <p><b> "BERKHIDMAT UNTUK NEGARA" </b></p>
    <p><h7>Unit Pengurusan Logistik
        <br> Seksyen Pentadbiran dan Aset
        <br> Bahagian Khidmat Pengurusan
        <br> Kementerian Perpaduan Negara
        <br>
        <br>Tel: 03-809 18150 / 18140
        <br>E-mel: mohdsaad@perpaduan.gov.my / azreeman@perpaduan.gov.my
    </h7></p>
</body>
</html>
