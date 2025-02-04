
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Emel Borang Penilaian</title>
</head>
<body style="font-family:Verdana; font-size:12px; text-align: justify">
  <p>Assalamualaikum dan Salam Perpaduan.<p>

  <p>YBhg. Datuk/Dato'/ Dr./Tuan/Puan,</p>

  <h3>PERKARA: Penilaian Perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara</h3>

  <justify>
    <p>Perkara di atas adalah dirujuk.</p>
    <p>2. &emsp;&emsp;Terima kasih kerana menggunakan perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara seperti berikut:</p>

    <p> 
        <table border="0" style="border-collapse:collapse;  font-size:13px; text-align:left; margin:0px 0px 0px 40px;" cellpadding="3" >
            <tr>
                <th width="150" style="text-align:left">ID Tempahan</th>
                <td width="250"><strong>: {{ $content->kod_permohonan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Jenis Perjalanan</th>
                <td><strong>: {{ \App\LkpJenisPerjalanan::find($content->id_jenis_perjalanan)->jenis_perjalanan }}</strong></td>
            </tr>
            <tr>
                <th style="text-align:left">Destinasi</th>
                <td><strong>: {{ $content->lokasi_tujuan }}, {{ \App\RLkpNegeri::find($content->id_negeri)->negeri }}</strong></td>
            </tr>
           @if($content->id_jenis_perjalanan!==4)
            <tr>
                <th style="text-align:left">Masa Pergi</th>
                <td><strong>: {{ ($content->masa_pergi!='') ? Carbon\Carbon::parse($content->masa_pergi)->format('g:i A') : '-' }} ({{ ($content->tkh_pergi!='') ? Carbon\Carbon::parse($content->tkh_pergi)->format('d/m/Y') : '' }})</strong></td>
            </tr>
			@endif
            @if($content->id_jenis_perjalanan!==1)
            <tr>
                <th style="text-align:left">Masa Balik</th>
                <td><strong>: {{ ($content->masa_balik!='') ? Carbon\Carbon::parse($content->masa_balik)->format('g:i A') : '-' }} ({{ ($content->tkh_balik!='') ? Carbon\Carbon::parse($content->tkh_balik)->format('d/m/Y') : '' }})</strong></td>
            </tr>
            @endif
            
        </table>
    </p>
    <p>3. &emsp;&emsp;Sukacita bersama-sama ini disertakan Borang Penilaian Perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara seperti pautan berikut:</p>
      <p>&emsp;&emsp;&emsp; <a href="{{ url('/pemohon/penilaian', $content->mykad) }}" target='_blank'><strong>BORANG MAKLUM BALAS</strong></a></p>

    <p>4. &emsp;&emsp;Sebarang pertanyaan boleh dikemukakan dengan menyertakan ID Tempahan kepada Pegawai Kenderaan seperti berikut:</p>
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
