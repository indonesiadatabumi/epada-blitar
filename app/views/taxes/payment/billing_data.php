<?php
echo "
	<div class='panel-group'>
		<div class='panel panel-default'>
		    <div class='panel-body'>
		    	<h3 align='center' style='font-weight:bold;font-size:1.5em'><u>Rincian Setoran Pajak</u></h3>
		    	<form id='form-tax_transaction' method='POST' action='" . base_url() . "payment/submit_form'>
		    		<input type='hidden' name='input-spt_id' value='" . $row['ketetapan_id'] . "'/>
		    		<input type='hidden' name='input-pajak_id' value='" . $row['pajak_id'] . "'/>
		    		<input type='hidden' name='input-wp_wr_id' value='" . $row['wp_wr_id'] . "'/>
		    		<input type='hidden' name='input-wp_wr_detil_id' value='" . $row['wp_wr_detil_id'] . "'/>
		    		<input type='hidden' name='input-jenis_spt_id' value='" . $row['jenis_spt_id'] . "'/>
		    		<input type='hidden' name='input-tahun_pajak' value='" . $row['tahun_pajak'] . "'/>
		    		<input type='hidden' name='input-masa_pajak1' value='" . $row['masa_pajak1'] . "'/>
		    		<input type='hidden' name='input-masa_pajak2' value='" . $row['masa_pajak2'] . "'/>
		    		<input type='hidden' id='tgl_jatuh_tempo' name='input-tgl_jatuh_tempo' value='" . $row['tgl_jatuh_tempo'] . "'/>
		    		<input type='hidden' name='input-loket_pembayaran_id' value='1'/>
		    		<input type='hidden' name='jenis_ketetapan' value='" . $row['jenis_ketetapan'] . "'/>
		    		<input type='hidden' name='kode_billing' value='" . $row['kode_billing'] . "'/>

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
				    					<input type='text' class='form-control' style='font-weight:bold;text-align:right' value='" . number_format($row['tot_pajak_terhutang']) . "' readonly/>
				    					<input type='hidden' name='input2-rekening_id' value='" . $row['rekening_id'] . "'/>
				    					<input type='hidden' name='input2-jumlah_pajak' value='" . $row['tot_pajak_terhutang'] . "'/>
				    					<input type='hidden' name='input2-rekening_id_denda' value='" . $row['rekening_id_denda'] . "'/>
			    					</td>
			    					</tr>";
echo "</tbody>
			    				<tfoot>
			    					<tr><td colspan='3' align='right'><b>Pokok Pajak Rp.</b></td><td align='right'><input type='text' class='form-control currency-text bg-green' id='input-pokok_pajak' name='input-pokok_pajak-int' value='" . number_format($row['tot_pajak_terhutang']) . "' readonly/></b></td></tr>
			    					<tr><td colspan='3' align='right'><b>Denda Rp.</b></td><td align='right'><input type='text' class='form-control currency-text bg-red' id='input-denda' name='input-denda-int' value='" . number_format($row['fine']) . "' readonly/></td></tr>
			    					<tr><td colspan='3' align='right'><b>Total Rp.</b></td><td align='right'><input type='text' class='form-control currency-text bg-yellow' id='input-total_bayar' name='input-total_bayar-int' value='" . number_format($row['grand_total']) . "' readonly/></b></td></tr>
			    				</tfoot>
			    			</table>
			    			
			    		</div>
			    		<div class='col-md-4'>
			    			<table class='table'>
			    				<tbody>
			    					<tr><td>Kode Billing</td><td><input type='text' class='form-control' value='" . $row['kode_billing'] . "' readonly/></td></tr>
				    				<tr><td>Jenis Ketetapan</td><td><input type='text' class='form-control' value='" . $row['singkatan_spt'] . "' readonly/></td></tr>
				    				<tr><td>Penerima Setoran</td><td><input type='text' class='form-control' value='" . $this->session->userdata('role') . "' readonly/></td></tr>
				    				<tr><td>Tgl. Penyetoran</td><td><input type='text' id='input-tgl_bayar-date' name='tgl_bayar' class='form-control' value='" . indo_date_format($tgl_setor, 'shortDate') . "'/></td></tr>
									<tr><td>No. Urut STS</td><td><input type='text' name='no_urut_sts' class='form-control' required/></td></tr>			    				
				    				<tr><td>Jumlah Setoran</td><td><input type='text' class='form-control currency-text bg-gold' style='color:#fff;border:2px solid #fcf63f;' value='" . number_format($row['grand_total']) . "' readonly/></td></tr>
				    				<tr><td></td><td><button type='submit' class='btn btn-success'><i class='fa fa-money'></i> Bayar</button></td></tr>
				    			</tbody>
			    			</table>
			    		</div>
			    	</div>
			    </form>

		    </div>
		</div>
	</div>";
?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#input-tgl_bayar-date").mask('99-99-9999');

		// START AND FINISH DATE
		$('#input-tgl_bayar-date').datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});
	});


	var $tax_transaction_form = $('#form-tax_transaction');

	var tax_transaction_stat = $tax_transaction_form.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	$tax_transaction_form.submit(function() {
		if (tax_transaction_stat.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_content('#content-billing_data')
				.set_loading('#loader-billing_data')
				.enable_pnotify()
				.set_form($tax_transaction_form)
				.submit_ajax('menambah data');
			return false;
		}
	});
</script>