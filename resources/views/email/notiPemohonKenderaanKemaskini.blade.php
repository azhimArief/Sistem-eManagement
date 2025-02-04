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
    <p>2. &emsp;&emsp;Sukacita dimaklumkan bahawa Seksyen Pentadbiran dan Aset, Bahagian Khidmat Pengurusan telah menerima pengemaskinian tempahan Kenderaan Jabatan Kementerian Perpaduan Negara seperti berikut:</p>

    <p>
        <table width="400" border="0" style="border-collapse:collapse;  font-size:13px; text-align:left; margin:0px 0px 0px 40px;" cellpadding="3" >
            <tr>
                <th width="150" style="text-align:left">ID Tempahan</th>
                <td width="250"><strong>: {{ $content->kod_permohonan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Nama Pemohon</th>
                <td><strong>: {{ $content->nama }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Tarikh Permohonan</th>
                <td><strong>: {{ date('d/m/Y', strtotime($content->created_by)) }}</strong></td>
            </tr>
			<!-- Start Kemaskini 12/1/2023-->
			<tr>
                <th style="text-align:left; vertical-align: top;">Penumpang</th>
                <?php $penumpangs=\App\Penumpang::where('id_tempahan',$content->id_maklumat_permohonan)->get(); ?>
                <td><strong>: @foreach($penumpangs as $penumpang)</strong>
                     <strong>{{ $penumpang->nama }} </strong><br>&nbsp;
                        @endforeach
                </td>
            </tr>
			<!-- End Kemaskini 12/1/2023-->
            <tr>
                <th style="text-align:left">Tujuan</th>
                <td><strong>: {{ \App\LkpTujuan::find($content->id_tujuan)->tujuan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Jenis Perjalanan</th>
                <td><strong>: {{ \App\LkpJenisPerjalanan::find($content->id_jenis_perjalanan)->jenis_perjalanan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Lokasi/Tempat</th>
                <td><strong>: {{ $content->lokasi_tujuan }}, {{ \App\RLkpNegeri::find($content->id_negeri)->negeri }}</strong></td>
            </tr>
			@if($content->id_jenis_perjalanan!==4)
			<!-- perjalanan balik sahaja -->
            <tr>
                <th style="text-align:left">Masa Pergi</th>
                <td><strong>: {{ ($content->masa_pergi!='') ? Carbon\Carbon::parse($content->masa_pergi)->format('g:i A') : '-' }} ({{ ($content->tkh_pergi!='') ? Carbon\Carbon::parse($content->tkh_pergi)->format('d/m/Y') : '' }})</strong></td>
            </tr>
			@endif
            @if($content->id_jenis_perjalanan!==1)
            <!-- perjalanan pergi sahaja -->
            <tr>
                <th style="text-align:left">Masa Balik</th>
                <td><strong>: {{ ($content->masa_balik!='') ? Carbon\Carbon::parse($content->masa_balik)->format('g:i A') : '-' }} ({{ ($content->tkh_balik!='') ? Carbon\Carbon::parse($content->tkh_balik)->format('d/m/Y') : '' }})</strong></td>
            </tr>
            @endif
        </table>
    </p>

    <p>Permohonan anda sedang diproses dan makluman tempahan Kenderaan Jabatan boleh disemak melalui <a href="{{ url('') }}">Sistem eTempahan</a> dan e-mel.
    <p>3. &emsp;&emsp;Sebarang pertanyaan boleh dikemukakan dengan menyertakan ID Tempahan kepada Pegawai Kenderaan seperti berikut:</p>
    </justify>
   <!-- <p>&emsp;&emsp;&emsp; Nama : En. Mohd Saad bin Aghmat
    <br>&emsp;&emsp;&emsp; Tel : 03-809 18150
    <br>&emsp;&emsp;&emsp; E-mel : mohdsaad@perpaduan.gov.my </p>-->
    <p>&emsp;&emsp;&emsp; Nama : Nor Sa'adah Binti Hj Mohd Sidek
    <br>&emsp;&emsp;&emsp; Tel : 03-8091 8150
    <br>&emsp;&emsp;&emsp; E-mel : norsaadah@perpaduan.gov.my </p>
    <p>&emsp;&emsp;&emsp; Nama : Zulaiha Binti Mohd Jaafar
    <br>&emsp;&emsp;&emsp; Tel : 03-8091 8063
    <br>&emsp;&emsp;&emsp; E-mel : zulaihajaafar@perpaduan.gov.my </p>
    <p>Sekian, terima kasih.</p><br>
    <!-- <p><b> "WAWASAN KEMAKMURAN BERSAMA 2030" </b></p> -->
    <p><b> "MALAYSIA MADANI" </b></p>
    <p><b> "BERKHIDMAT UNTUK NEGARA" </b></p>
    <!-- <p><b> "<i>Merakyatkan Perpaduan Keluarga Malaysia</i>"</b></p> -->
    <p><h7>Unit Pengurusan Logistik
        <br> Seksyen Pentadbiran dan Aset
        <br> Bahagian Khidmat Pengurusan
        <br> Kementerian Perpaduan Negara
        <br>
        <br>Tel: 03-8091 8150 / 8063
        <br>E-mel: norsaadah@perpaduan.gov.my / zulaihajaafar@perpaduan.gov.my
		<!--<br>E-mel: mohdsaad@perpaduan.gov.my / azreeman@perpaduan.gov.my-->
    </h7></p>
    <p></p>
    <p><i>** E-mel ini dijana oleh Sistem eTempahan dan tidak perlu dibalas. **</i></p>
</body>
</html>