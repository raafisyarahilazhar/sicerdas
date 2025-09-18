<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili</title>
    <style>
        /* CSS sederhana untuk styling surat */
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 2.5cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 30px; }
        .kop-surat h1 { font-size: 18pt; margin: 0; }
        .kop-surat h2 { font-size: 16pt; margin: 0; }
        .kop-surat p { font-size: 11pt; margin: 0; }
        .judul-surat { text-align: center; font-weight: bold; text-decoration: underline; font-size: 14pt; margin-bottom: 20px; }
        .isi-surat { text-align: justify; line-height: 1.5; }
        .isi-surat p { text-indent: 4em; margin: 0 0 1em 0; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        table td { padding: 4px 0; vertical-align: top; }
        .penutup { margin-top: 40px; }
        .tanda-tangan { margin-top: 80px; width: 300px; float: right; text-align: center; }
        .tanda-tangan .nama { font-weight: bold; text-decoration: underline; margin-top: 70px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PEMERINTAH KABUPATEN BANDUNG BARAT</h1>
        <h2>KECAMATAN CIHAMPELAS</h2>
        <p>Jalan Cihampelas Raya No. 123, Desa Mekarjaya, Kode Pos 40562</p>
    </div>

    <div class="judul-surat">
        SURAT KETERANGAN DOMISILI
    </div>
    <div style="text-align:center; margin-top:-15px; margin-bottom: 30px;">
        Nomor: 470 / ...... / Pem
    </div>

    <div class="isi-surat">
        <p>
            Yang bertanda tangan di bawah ini, Kepala Desa Mekarjaya, Kecamatan Cihampelas, Kabupaten Bandung Barat, menerangkan dengan sebenarnya bahwa:
        </p>

        <table>
            <tr>
                <td style="width: 30%;">Nama Lengkap</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;"><strong>{{ $data['nama_pemohon'] ?? $resident->name }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $resident->nik }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $resident->place_of_birth }}, {{ \Carbon\Carbon::parse($resident->date_of_birth)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $resident->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $data['alamat'] ?? $resident->address }}</td>
            </tr>
        </table>

        <p>
            Berdasarkan data yang ada pada kami, nama tersebut di atas adalah benar penduduk yang berdomisili di Desa Mekarjaya, Kecamatan Cihampelas, Kabupaten Bandung Barat.
        </p>
        <p>
            Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.
        </p>
    </div>

    <div class="penutup">
        <div class="tanda-tangan">
            Mekarjaya, {{ now()->isoFormat('D MMMM Y') }}<br>
            Kepala Desa Mekarjaya,
            <div class="nama">
                ( NAMA KEPALA DESA )
            </div>
            NIP. ............................
        </div>
    </div>

</body>
</html>