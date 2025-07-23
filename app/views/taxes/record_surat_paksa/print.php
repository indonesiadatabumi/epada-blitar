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
                    <span style="font-size:16px; ">Surat Paksa</span> <br />
                    <span style="font-size:16px; ">Nomor : <?= $rows['no_surat'] ?></span> <br>
                    <span style="font-size:16px; ">DEMI KEADILAN BERDASARKAN KETUHANAN YANG MAHA ESA</span>
                </div>
                <!-- <hr />
                <table border="0" width="100%" align="center">
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
                            Tahun Pajak : <?= $rows['srt_paksa_periode'] ?>
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
                            <?= indo_date_format($rows['srt_paksa_dibuat_tgl'], 'longDate') ?>
                        </td>
                    </tr>
                </table> -->
                <hr />
                <table width="100%" style="font-size:14px; ">
                    <tr>
                        <td colspan="2">
                            Menimbang bahwa Penanggung Pajak atas Wajib Pajak :
                        </td>
                    </tr>
                    <tr>
                        <td width="24%">Nama Wajib Pajak</td>
                        <td>: <?= $rows['nama_pemilik'] ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Subyek Pajak</td>
                        <td>: <?= $rows['alamat_pemilik'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Objek Pajak</td>
                        <td>: <?= $rows['nama_wp'] ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Objek Pajak</td>
                        <td>: <?= $rows['alamat'] ?></td>
                    </tr>
                    <tr>
                        <td>N. P. W. P. D</td>
                        <td>: P.2.<?= $rows['npwpd'] ?></td>
                    </tr>
                    <tr>
                        <td>KODE BILLING </td>
                        <td>: 3505<?= $kode_pajak['rek_bank'] ?><?= $rows['srt_paksa_kode_billing'] ?></td>
                    </tr>
                </table>
                <hr />
                <span style="font-size:14px; ">bertanggung jawab atas pembayaran Pajak dari Utang Pajak yang dimiliki Wajib Pajak sebagaimana tercantum sebagai berikut :</span>
                <table border="1" border="1" cellpadding="2" cellspacing="0" style="width:100%; " style="font-size:14px; ">
                    <!-- <tr align="center">
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
                            <?= mix_2Date($rows['srt_paksa_periode_jual1'], $rows['srt_paksa_periode_jual2']) ?> <br />
                            Rp. <?= number_format($rows['nilai_terkena_pajak'], 2, ",", ".") ?> <br />
                            <?= $rows['persen_tarif'] ?> % <br />
                            Rp. <?= number_format($rows['pajak'], 2, ",", ".") ?> <br />
                            Rp. <?= number_format($denda, 2, ",", ".") ?> <br />
                            Rp. <?= number_format($grand_total, 2, ",", ".") ?>
                        </td>
                    </tr> -->
                    <tr>
                        <td>Jenis Pajak</td>
                        <td>Tahun Pajak</td>
                        <td>Nomor & Tanggal STPD/SKPKB/SKPKBT/SK Pembetulan/SK Keberatan/Putusan Banding/Putusan Peninjauan Kembali</td>
                        <td>Jumlah (Rp.)</td>
                    </tr>
                    <tr>
                        <td><?= $rows['nama_pajak'] ?></td>
                        <td><?= $rows['srt_paksa_periode'] ?></td>
                        <td><?= $rows['no_surat_st'] ?></td>
                        <td align="right"><?= number_format($grand_total, 2, ",", ".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">Jumlah Rp.</td>
                        <td align="right"><?= number_format($grand_total, 2, ",", ".") ?></td>
                    </tr>
                </table>
                <span style="font-size:14px; ">(Terbilang : <?= ucwords(NumToWords($grand_total)) ?> Rupiah)</span> <br>
                <span style="font-size:14px; ">Dengan ini:</span> <br>
                <span style="font-size:14px; ">1. memerintahkan Penanggung Pajak untuk membayar jumlah Utang Pajak tersebut ditambah dengan Biaya Bunga/Denda ke Kas Daerah dalam jangka waktu 2x24 (dua kali dua puluh empat) jam sesudah pemberitahuan Surat Paksa ini;</span> <br>
                <span style="font-size:14px; ">2. memerintahkan kepada Jurusita Pajak yang melaksanakan Surat Paksa ini atau Jurusita Pajak lain yang ditunjuk untuk melanjutkan pelaksanaan Surat Paksa, jika diperlukan untuk melaksanakan Penyitaan barang-barang milik Penanggung Pajak apabila dalam jangka waktu 2x24 (dua kali dua puluh empat) jam Surat Paksa ini tidak dipenuhi.</span> <br>
                <span style="font-size:14px; ">3. atas pemberitahuan Surat Paksa dapat dikenakan Biaya Penagihan Pajak yang akan ditagih sesuai dengan ketentuan peraturan perundang-undangan.</span>
                <hr />
                <div>
                    <span style="font-size:16px; font-weight:bold;">Perhatian</span><br>
                    <span style="font-size: 14px;">UTANG PAJAK HARUS DILUNASI DALAM JANGKA WAKTU 2 (DUA) HARI SEJAK DISAMPAIKANNYA SURAT PAKSA INI. SESUDAH BATAS WAKTU ITU, TINDAKAN PENAGIHAN PAJAK DAPAT DILANJUTKAN DENGAN PENYITAAN. JUMLAH POKOK PIUTANG BELUM TERMASUK DENDA/SANKSI ADMINISTRATIF<br>
                        (Pasal 81 ayat (7) PP 35/2023)</span>
                </div>
                <br />
                <div align="right">
                    <table style="font-size: 14px;">
                        <tr>
                            <td></td>
                            <td align="center">Blitar, <?= indo_date_format($rows['srt_paksa_dibuat_tgl'], 'longDate') ?> </td>
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
                        <td width="24%">Nama Wajib Pajak</td>
                        <td>: <?= $rows['nama_wp'] ?></td>
                    </tr>
                    <tr>
                        <td>N. P. W. P. D</td>
                        <td>: P.2.<?= $rows['npwpd'] ?></td>
                        </td>
                    </tr>
                    <tr>
                        <td>No. Surat Paksa (SP)</td>
                        <td>: <?= $rows['no_surat'] ?></td>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit Surat Paksa</td>
                        <td>: <?= indo_date_format($rows['srt_paksa_dibuat_tgl'], 'longDate') ?></td>
                        </td>
                    </tr>
                    <tr>
                        <td>Total Pajak</td>
                        <td>: <?= number_format($rows['pajak'], 2, ",", ".") ?></td>
                        </td>
                    </tr>
                    <tr>
                        <td>KODE BILLING </td>
                        <td>: 3505<?= $kode_pajak['rek_bank'] ?><?= $rows['srt_paksa_kode_billing'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>

    </html>