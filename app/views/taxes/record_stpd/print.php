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
                <div style="text-align:center; font-weight:bold; "><span style="font-size:20px; ">SURAT TAGIHAN PAJAK DAERAH</span> <br />
                    <span style="font-size:20px; "><?= $rows['nama_pajak'] ?></span>
                </div>
                <hr />
                <table border="0" width="100%" align="center" style="font-size: 14px;">
                    <tr>
                        <td>
                            Nomor
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?= $rows['no_surat'] ?>
                        </td>
                        <td>
                            Tahun Pajak : <?= $rows['stpd_periode'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tanggal Penerbitan
                        </td>
                        <td>
                            :
                        </td>
                        <td colspan="2">
                            <?= indo_date_format($rows['stpd_dibuat_tgl'], 'longDate') ?>
                        </td>
                    </tr>
                </table>
                <hr />
                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td width="24%">NAMA WAJIB PAJAK</td>
                        <td>: <?= $rows['nama_wp'] ?></td>
                    </tr>
                    <tr>
                        <td>N. P. W. P. D</td>
                        <td>: P.2.<?= $rows['npwpd'] ?></td>
                        </td>
                    </tr>
                    <tr>
                        <td>KODE BILLING </td>
                        <td>: 3505<?= $kode_pajak['rek_bank'] ?><?= $rows['stpd_kode_billing'] ?></td>
                    </tr>
                </table>
                <hr />
                <span style="font-size:16px; font-weight:bold;">Perincian pajak yang terutang</span>
                <table border="1" border="1" cellpadding="2" cellspacing="0" style="width:100%; " style="font-size: 14px;">
                    <tr align="center">
                        <td width="30%">&nbsp;</td>
                        <td>Jumlah Pembayaran dan Pajak Terhutang</td>
                    </tr>
                    <tr>
                        <td>
                            a. Masa Pajak <br />
                            b. Dasar Pengenaan <br />
                            c. Tarif Pajak (Sesuai Perda) <br />
                            d. Pajak Terhutang (bxc) <br />
                            e. Denda <br />
                            f. Total Bayar (d + e)
                        </td>
                        <td style="padding-left:8px; ">
                            <?= mix_2Date($rows['stpd_periode_jual1'], $rows['stpd_periode_jual2']) ?> <br />
                            Rp. <?= number_format($rows['nilai_terkena_pajak'], 2, ",", ".") ?> <br />
                            <?= $rows['persen_tarif'] ?> % <br />
                            Rp. <?= number_format($rows['pajak'], 2, ",", ".") ?> <br />
                            Rp. <?= number_format($denda, 2, ",", ".") ?> <br />
                            Rp. <?= number_format($grand_total, 2, ",", ".") ?>
                        </td>
                    </tr>
                </table>
                <hr />
                <div>
                    <span style="font-size:16px; font-weight:bold;">Perhatian</span><br>
                    <span style="font-size: 14px;">1. Surat Tagihan Pajak Daerah (STPD) ini harus dilunasi paling lambat 1 (satu) bulan sejak tanggal diterima. <br>
                        2. Apabila setelah lewat tanggal jatuh tempo utang pajak belum dilunasi, maka tindakan penagihan akan dilanjutkan dengan penerbitan Surat Paksa, pelaksanaan sita dan lelang.</span>
                </div>
                <br />
                <div>
                    <table style="width:100%" style="font-size: 14px;">
                        <tr>
                            <td></td>
                            <td align="center">Blitar, <?= indo_date_format($rows['stpd_dibuat_tgl'], 'longDate') ?> </td>
                        </tr>
                        <tr>
                            <td width="50%" align="center">Scan Me</td>
                            <td align="center">KEPALA BADAN PENDAPATAN DAERAH <br> KABUPATEN BLITAR</td>
                        </tr>
                        <tr>
                            <td align="center"><img src="<?= $this->config->item('img_path'); ?>barcode_payment_blitar.png" width="90px"></td>
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
                        <td>: <?= mix_2Date($rows['stpd_periode_jual1'], $rows['stpd_periode_jual2']) ?> <br /></td>
                    </tr>
                    <tr>
                        <td>NOMINAL</td>
                        <td>: Rp. <?= number_format($grand_total, 2, ",", ".") ?></td>
                    </tr>
                    <tr>
                        <td>KODE BILLING </td>
                        <td>: 3505<?= $kode_pajak['rek_bank'] ?><?= $rows['stpd_kode_billing'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>

    </html>