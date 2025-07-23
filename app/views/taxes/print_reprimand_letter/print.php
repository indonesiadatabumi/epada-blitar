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
                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td colspan="2">Yth.</td>
                    </tr>
                    <tr>
                        <td width="24%">NAMA WAJIB PAJAK</td>
                        <td>: <?= $rows['nama_pemilik'] ?></td>
                    </tr>
                    <tr>
                        <td>ALAMAT WAJIB PAJAK</td>
                        <td>: <?= $rows['alamat_pemilik'] ?></td>
                    </tr>
                    <tr>
                        <td>NAMA OBJEK PAJAK </td>
                        <td>: <?= $rows['nama_wp'] ?></td>
                    </tr>
                    <tr>
                        <td>ALAMAT OBJEK PAJAK </td>
                        <td>: <?= $rows['alamat'] ?></td>
                    </tr>
                    <tr>
                        <td>N. P. W. P. D</td>
                        <td>: P.2.<?= $rows['npwpd'] ?></td>
                    </tr>
                </table>
                <br>
                <div style="text-align:center; font-weight:bold; "><span style="font-size:20px; ">SURAT TEGURAN</span> <br />
                </div>
                <hr />
                <table border="0" width="100%" align="center" style="font-size: 14px;">
                    <tr align="center">
                        <td>
                            <b> NOMOR : <?= $rows['no_surat'] ?></b>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            Menurut tata usaha kami, hingga saat ini Saudara masih mempunyai Utang Pajak Sebagai berikut:
                        </td>
                    </tr>
                </table>
                <br>
                <table border="1" border="1" cellpadding="2" cellspacing="0" style="width:100%; " style="font-size: 14px;">
                    <tr align="center">
                        <td>Jenis Pajak</td>
                        <td>Tahun Pajak</td>
                        <td>Nomor & Tanggal STPD/SKPKB/SKPKBT/SK Pembetulan/SK Keberatan/Putusan Banding/Putusan Peninjauan Kembali</td>
                        <td>Tanggal Jatuh Tempo Pembayaran</td>
                        <td>Jumlah (Rp.)</td>
                    </tr>
                    <tr>
                        <td><?= $rows['nama_pajak'] ?></td>
                        <td><?= $rows['st_periode'] ?></td>
                        <td><?= $rows['no_surat_stpd'] ?></td>
                        <!-- <td><?= indo_date_format($rows['st_jatuh_tempo'], 'longDate') ?></td> -->
                        <td></td>
                        <td align="right"><?= number_format($grand_total, 2, ",", ".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right">Jumlah Rp.</td>
                        <td align="right"><?= number_format($grand_total, 2, ",", ".") ?></td>
                    </tr>
                </table>
                <span style="font-size: 14px;">(Terbilang : <?= ucwords(NumToWords($grand_total)) ?> Rupiah)</span> <br> <br>
                <span style="font-size: 14px;">Untuk mencegah tindakan Penagihan Pajak dengan Surat Paksa berdasarkan PP No. 35 Tahun 2023 tentang Ketentuan Umum Pajak Daerah dan Retribusi Daerah maka diminta kepada Saudara agar melunasi Jumlah Utang Pajak dalam jangka waktu 21 (dua puluh satu) hari sejak disampaikannya Surat Teguran ini</span>
                <hr />
                <div>
                    <span style="font-size:16px; font-weight:bold;">Perhatian</span><br>
                    <span style="font-size: 14px;">UTANG PAJAK HARUS DILUNASI DALAM JANGKA WAKTU 21 (DUA PULUH SATU) HARI SEJAK DISAMPAIKANNYA SURAT TEGURAN INI. SESUDAH BATAS WAKTU ITU, TINDAKAN PENAGIHAN PAJAK DAPAT DILANJUTKAN DENGAN PENERBITAN SURAT PAKSA. JUMLAH POKOK PIUTANG BELUM TERMASUK DENDA/SANKSI ADMINISTRATIF<br>
                        (UU 1/2022) <br>
                        (PP 35/2023)</span>
                </div>
                <br />
                <div>
                    <table style="width:100%" style="font-size: 14px;">
                        <tr>
                            <td></td>
                            <td align="center">Blitar, <?= indo_date_format($rows['st_dibuat_tgl'], 'longDate') ?> </td>
                        </tr>
                        <tr>
                            <td width="50%" align="center">Scan Me</td>
                            <td align="center">KEPALA BADAN PENDAPATAN DAERAH <br> KABUPATEN BLITAR</td>
                        </tr>
                        <tr>
                            <td align="center"><img src="<?= $this->config->item('img_path'); ?>barcode_payment_blitar.png" width="150"></td>
                            <td height="150" valign="bottom" align="center">
                                <span style="text-decoration: underline; font-weight:bold;">ASMANINGAYU DEWI L., ST, MM</span><br>
                                <span align>Pembina Tingkat I</span> <br>
                                NIP. 19780426 200212 2 011
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <table width="100%" style="font-size: 14px;">
                <tr>
                    <td width="40%">
                        <hr>
                    </td>
                    <td valign="top" align="center">
                        <span style="font-size: 14px;">Potong disini</span>
                    </td>
                    <td width="40%">
                        <hr>
                    </td>
                </tr>
            </table>
        </div>
        <div style="border:1px solid #000000; width:100%; ">
            <div style="padding: 10px;">
                <table width="75%" style="font-size: 14px;">
                    <tr>
                        <td width="24%">NAMA WAJIB PAJAK</td>
                        <td>: <?= $rows['nama_wp'] ?></td>
                    </tr>
                    <tr>
                        <td>N. P. W. P. D</td>
                        <td>: P.2.<?= $rows['npwpd'] ?></td>
                    </tr>
                    <tr>
                        <td>MASA PAJAK</td>
                        <td>: <?= mix_2Date($rows['st_periode_jual1'], $rows['st_periode_jual2']) ?> <br /></td>
                    </tr>
                    <tr>
                        <td>NOMINAL</td>
                        <td>: Rp. <?= number_format($grand_total, 2, ",", ".") ?></td>
                    </tr>
                    <tr>
                        <td>KODE BILLING </td>
                        <td>: 3505<?= $kode_pajak['rek_bank'] ?><?= $rows['st_kode_billing'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>

    </html>