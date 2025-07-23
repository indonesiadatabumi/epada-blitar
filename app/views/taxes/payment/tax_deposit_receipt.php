<?php
echo "
	<div class='panel-group'>
		<div class='panel panel-default'>
			<div class='panel-body'>
				<h3 align='center' style='font-weight:bold;font-size:1.5em'><u>Rincian Setoran Pajak</u></h3>

				<div class='row'>
		    		<div class='col-md-6'>
		    			<table class='table table-bordered'>
		    				<tbody>
		    					<tr><td class='text_label'>NPWPD</td><td>" . $row['npwpd'] . "</td></tr>
		    					<tr><td class='text_label'>Nama WP</td><td>" . $row['nama_wp'] . "</td></tr>
		    					<tr><td class='text_label'>Alamat</td><td>" . $row['alamat'] . "</td></tr>
		    					<tr><td class='text_label'>Kelurahan, Kecamatan</td><td>" . $row['kelurahan'] . ", " . $row['kecamatan'] . "</td></tr>
		    				</tbody>
		    			</table>
		    		</div>
		    		<div class='col-md-6'>
		    			<table class='table table-bordered'>
		    				<tbody>
		    					<tr><td class='text_label'>Jenis Pajak</td><td>" . $row['nama_pajak'] . "</td></tr>
		    					<tr><td class='text_label'>Tahun Pajak</td><td>" . $row['tahun_pajak'] . "</td></tr>
		    					<tr><td class='text_label'>Masa Pajak</td><td>" . mix_2Date($row['masa_pajak1'], $row['masa_pajak2']) . "</td></tr>
		    					<tr><td class='text_label'>Jatuh Tempo</td><td>" . indo_date_format($row['tgl_jatuh_tempo'], 'longDate') . "</td></tr>
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>

		    	<div class='row'>
		    		<div class='col-md-8'>
		    			<table class='table table-bordered table-hover'>
		    				<thead><th>#</th><th>Jenis Pajak</th><th>Kegiatan Usaha</th><th>Jumlah</th></thead>
		    				<tbody>";
$no = 1;
echo "
		    					<tr>
		    					<td align='center'>" . $no . ".</td>
		    					<td>" . $row['nama_pajak'] . "</td><td>" . $row['nama_rekening'] . "</td>
		    					<td width='30%'>
		    					<input type='text' class='form-control' style='font-weight:bold;text-align:right' value='" . number_format($row['pajak']) . "' readonly/>		    					
		    					</td>
		    					</tr>
		    				</tbody>
		    				<tfoot>
		    					<tr><td colspan='3' align='right'><b>Pokok Pajak Rp.</b></td><td align='right'>
		    					<input type='text' class='form-control' style='font-weight:bold;text-align:right' value='" . number_format($row['pokok_pajak']) . "' readonly/></td></tr>
		    					<tr><td colspan='3' align='right'><b>Denda Rp.</b></td><td align='right'>
		    					<input type='text' class='form-control' style='font-weight:bold;text-align:right' value='" . number_format($row['denda']) . "' readonly/></td></tr>
		    					<tr><td colspan='3' align='right'><b>Total Rp.</b></td><td align='right'>
		    					<input type='text' class='form-control' style='font-weight:bold;text-align:right' value='" . number_format($row['total_bayar']) . "' readonly/></td></tr>
		    					</tfoot>
		    			</table>
		    			<input type='hidden' name='n_detail' value='" . $no . "'/>
		    		</div>
		    		<div class='col-md-4'>
		    			<table class='table'>
		    				<tbody>
		    					<tr><td>Kode Billing</td><td>" . $row['kode_billing'] . "</td></tr>
			    				<tr><td>Jenis Ketetapan</td><td>" . $row['singkatan_spt'] . "</td></tr>
			    				<tr><td>Penerima Setoran</td><td>" . $row['loket_pembayaran'] . "</td></tr>
			    				<tr><td>Tgl. Penyetoran</td><td>" . indo_date_format($row['tgl_bayar'], 'longDate') . "</td></tr>
			    				<tr><td>Jumlah Setoran</td><td>
			    				<input type='text' class='form-control' style='font-weight:bold;text-align:right' value='" . number_format($row['total_bayar']) . "' readonly/></td></tr>
			    				<tr>
			    				<td>&nbsp;</td><td>
			    				<a href='" . base_url() . "payment/print_sts?id=" . $row['spt_id'] . "' style='color:#fff;' target='_blank' class='btn btn-success'><i class='fa fa-print'></i> Cetak STS</a></td></tr>
			    				</tr>
			    			</tbody>
		    			</table>
		    		</div>
		    	</div>

			</div>
		</div>
	</div>";
