    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>

    <head>
        <title><?= $rows['nama_pajak'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="shortcut icon" type="images/x-icon" href="images/fav.ico" />
        <style>
            hr {
                border: 0.5px solid black;
            }
        </style>
    </head>

    <body>
        <div style="border:1px solid #000000; width:100%; ">
            <div style="padding: 10px;">
                <table width="100%">
                    <tr>
                        <td width="10"><img src="<?= $this->config->item('img_path'); ?>logo_pemda.png" width="75"></td>
                        <td valign="top" align="center"><span style="font-size: 20px; font-weight:bold;">PEMERINTAH KABUPATEN BLITAR</span> <br>
                            <span style="font-size: 20px; font-weight:bold;">BADAN PENDAPATAN DAERAH</span><br>
                            <span style="font-size: 14px;">Jl. WR. Soepratman 09 Blitar Telp. (0342) 802596 Fax. (0342) 815197 email : bapenda@blitarkab.go.id / website : bapenda.blitarkab.go.id</span>
                        </td>
                    </tr>
                </table>

                <hr />
                <div style="text-align:center; font-weight:bold; ">
                    <span style="font-size:17px; ">BERITA ACARA PEMBERITAHUAN SURAT PAKSA</span> <br />
                    <span style="font-size:17px; ">Nomor : <?= $rows['no_surat'] ?></span> <br>
                </div>
                <br>
                <div style="text-align:center;">
                    <span style="font-size:15px; ">Pada Hari ini <?= get_dayName(date('Y-m-d')) ?> Tanggal <?= date('d') ?> Bulan <?= get_monthName(date('m'), $lang = 'id', $type = 'long') ?> Tahun <?= date('Y') ?> atas perintah Kepala Bapenda
                        Kabupaten Blitar, sesuai surat Nomor <?= $rows['no_surat'] ?>, Saya Jurusita Pajak pada Bapenda Kabupaten
                        Blitar, bertempat kedudukan di Jl. WR. Supratman No. 9 Bendogerit Kec. Sananwetan Kota Blitar.</span>
                </div>
                <br>
                <div style="text-align:center;">
                    <span style="font-size:17px; "><b>MEMBERITAHUKAN DENGAN RESMI</b></span>
                </div>
                <div>
                    <span style="font-size:15px; ">kepada Saudara yang namanya tertera pada Surat Paksa Nomor <?= $rows['no_surat'] ?> Tanggal <?= indo_date_format($rows['srt_paksa_tgl_proses'], 'longDate') ?> Dan saya, Jurusita
                        Pajak, berdasarkan kekuatan Paksa tersebut memerintahkan kepada Wajib Pajak atau Wajib Pajak dan Penanggung
                        Pajak supaya dalam jangka waktu 2x24 (dua kali dua puluh empat) jam, memenuhi isi Surat Paksa dan oleh karena itu
                        harus menyetor ke Kas Daerah sejumlah Rp <?= number_format($grand_total, 2, ",", ".") ?><br>
                        (Terbilang: <?= ucwords(NumToWords($grand_total)) ?>) <br>
                        dengan tidak mengurangi kewajiban untuk membayar Biaya Penagihan Pajak. Dalam hal Penanggung Pajak tidak
                        membayar dalam jangka waktu yang telah ditentukan, maka harta bendanya baik yang berupa barang bergerak maupun
                        barang tidak bergerak dapat disita dan dilakukan penjualan secara lelang/penjualan yang dikecualikan dari penjualan
                        secara lelang dan hasil penjualannya digunakan untuk membayar Utang Pajak dan Biaya Penagihan Pajak ini.</span>
                </div>
                <br>
                <br>
                <div style="text-align:center;">
                    <span style="font-size:15px; ">Surat Paksa ini dapat dilanjutkan dengan tindakan PENCEGAHAN dan PENYANDERAAN.</span>
                </div>
                <br>
                <br>
                <div style="text-align:center;">
                    <span style="font-size:15px; ">Saya, Juru Sita Pajak, telah/tidak dapat*) menyerahkan salinan Surat Paksa ini**):</span>
                </div>
                <br>
                <div>
                    <span style="font-size:15px; ">Kepada .................... Selaku......................... Bertempat di...................................................... <br>
                        Disebabkan.............................................................................. Adapun <br>
                        kondisi pada pada Surat Paksa diserahkan sebagaimana diuraikan berikut ini: <br>
                        ...................................................................................................................................... <br>
                        ...................................................................................................................................... <br>
                        ...................................................................................................................................... <br>
                        dengan meninggalkan salinan Surat Paksa karena Penanggung Pajak menolak untuk menerima Surat Paksa dan Surat Paksa dianggap telah diberitahukan.</span>
                </div>
                <br>
                <br>
                <div>
                    <span style="font-size:15px; "> Demikian Berita Acara ini dibuat dengan sebenarnya untuk dipergunakan seperlunya.</span>
                </div>
                <br>
                <br>
                <div>
                    <table width="100%" style="font-size:15px; ">
                        <tr>
                            <td width="40%">Mengetahui</td>
                            <td width="20%"></td>
                            <td width="40%">Jurusita Pajak</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Bapenda Kabupaten Blitar</td>
                        </tr>
                        <tr>
                            <td>1. ......................................</td>
                            <td>.........................</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2. ......................................</td>
                            <td>.........................</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3. ......................................</td>
                            <td>.........................</td>
                            <td>............................................</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div style="height:100%; ">&nbsp;</div>

    </body>

    </html>