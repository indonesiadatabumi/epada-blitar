<?php
echo "<input type='hidden' id='base_url' value='" . base_url() . "'/>";
if ($ads_type_id == '') {
	echo "<div class='alert alert-warning'>
            Silahkan pilih Jenis Reklame pada Kotak Pilihan di sebelah kiri!
        </div>";
} else {
	$ads_type_class1 = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 19);

	echo "<div class='row'>";
	echo "<input type='hidden' name='input2-satuan_jangka_waktu" . $order_num . "' value='" . strtolower($ads_type_row['satuan_jangka_waktu']) . "'/>";

	if (in_array($ads_type_id, $ads_type_class1)) {
		echo "
			<div class='col-md-6'>
				<div class='form-group'>
					<div class='col-md-12'>
						<table class='table table-bordered'>
							<thead><tr><td colspan='2'>Jenis Indeks</td><td>Indeks</td></tr></thead>
							<tbody>
								<tr>
								<td>Kawasan</td>
								<td>
								<select class='form-control' name='input2-indeks_kawasan_id" . $order_num . "' id='input2-indeks_kawasan_id" . $order_num . "' onchange=\"adstax_execute_multifunction1(" . $order_num . ")\" required>
									<option value='' selected></option>";
		foreach ($index1_rows as $row) {
			$selected = ($curr_data['indeks_kawasan_id'] == $row['ref_indeks_id'] ? 'selected' : '');
			echo "<option value='" . $row['ref_indeks_id'] . "_" . $row['indeks'] . "' " . $selected . ">" . $row['kawasan'] . "</option>";
		}
		echo "</select>
								</td>
								<td><input type='text' class='form-control' name='input2-indeks_kawasan" . $order_num . "' value='" . number_format(coalesce($curr_data['indeks_kawasan'], 0), 2, '.', ',') . "' id='input2-indeks_kawasan" . $order_num . "' style='text-align:right' readonly/></td>
								</tr>
								<tr>
								<td>Sudut Pandang</td>
								<td>
								<select class='form-control' name='input2-indeks_sudut_pandang_id" . $order_num . "' id='input2-indeks_sudut_pandang_id" . $order_num . "' onchange=\"adstax_execute_multifunction1(" . $order_num . ")\" required>
									<option value='' selected></option>";
		foreach ($index2_rows as $row) {
			$selected = ($curr_data['indeks_sudut_pandang_id'] == $row['ref_indeks_id'] ? 'selected' : '');
			echo "<option value='" . $row['ref_indeks_id'] . "_" . $row['indeks'] . "' " . $selected . ">" . $row['sudut_pandang'] . "</option>";
		}
		echo "</select>
								</td>
								<td><input type='text' class='form-control' name='input2-indeks_sudut_pandang" . $order_num . "' value='" . number_format(coalesce($curr_data['indeks_sudut_pandang'], 0), 2, '.', ',') . "' id='input2-indeks_sudut_pandang" . $order_num . "' style='text-align:right' readonly/></td>
								</tr>
								<tr>
								<td>Kelas Jalan</td>
								<td>
								<select class='form-control' name='input2-indeks_kelas_jalan_id" . $order_num . "' id='input2-indeks_kelas_jalan_id" . $order_num . "' onchange=\"adstax_execute_multifunction1(" . $order_num . ")\" required>
									<option value='' selected></option>";
		foreach ($index3_rows as $row) {
			$selected = ($curr_data['indeks_kelas_jalan_id'] == $row['ref_indeks_id'] ? 'selected' : '');
			echo "<option value='" . $row['ref_indeks_id'] . "_" . $row['indeks'] . "' " . $selected . ">" . $row['kelas_jalan'] . "</option>";
		}
		echo "</select>
								</td>
								<td><input type='text' class='form-control' name='input2-indeks_kelas_jalan" . $order_num . "' value='" . number_format(coalesce($curr_data['indeks_kelas_jalan'], 0), 2, '.', ',') . "' id='input2-indeks_kelas_jalan" . $order_num . "' style='text-align:right' readonly/></td>
								</tr>
								<tr>
								<td>Ketinggian</td>
								<td>
								<select class='form-control' name='input2-indeks_ketinggian_id" . $order_num . "' id='input2-indeks_ketinggian_id" . $order_num . "' onchange=\"adstax_execute_multifunction1(" . $order_num . ")\" required>
									<option value='' selected></option>";
		foreach ($index4_rows as $row) {
			$selected = ($curr_data['indeks_ketinggian_id'] == $row['ref_indeks_id'] ? 'selected' : '');
			echo "<option value='" . $row['ref_indeks_id'] . "_" . $row['indeks'] . "' " . $selected . ">" . $row['ketinggian'] . "</option>";
		}
		echo "</select>
								</td>
								<td><input type='text' class='form-control' name='input2-indeks_ketinggian" . $order_num . "' value='" . number_format(coalesce($curr_data['indeks_ketinggian'], 0), 2, '.', ',') . "' id='input2-indeks_ketinggian" . $order_num . "' style='text-align:right' readonly/></td>
								</tr>
								<tr>
									<td colspan='2' align='right'><b>NSL</b></td><td><input type='text' class='form-control thousand_format' name='input2-nsl" . $order_num . "' value='" . number_format(coalesce($curr_data['nsl'], 0), 2, '.', ',') . "' id='input2-nsl" . $order_num . "' readonly/></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class='col-md-6'>
				<div class='form-group'>
					<div class='col-md-12'>
						<table class='table table-bordered'>
							<thead>
								<tr><td>Ukuran (" . $ads_type_row['satuan_ukuran'] . ")</td><td>Jangka Waktu (" . $ads_type_row['satuan_jangka_waktu'] . ")</td><td>Jumlah</td></tr>
							</thead>
							<tbody>
								<tr>
									<td><input type='text' class='form-control thousand_format' name='input2-ukuran" . $order_num . "' value='" . $curr_data['ukuran'] . "' id='input2-ukuran" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" value='" . number_format(coalesce($curr_data['ukuran'], 0)) . "' required/></td>
									<td><input type='text' class='form-control thousand_format' name='input2-jangka_waktu" . $order_num . "' value='" . $curr_data['jangka_waktu'] . "' id='input2-jangka_waktu" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" value='" . number_format(coalesce($curr_data['jangka_waktu'], 0)) . "' required/></td>
									<td><input type='text' class='form-control thousand_format' name='input2-jumlah" . $order_num . "' value='" . $curr_data['jumlah'] . "' id='input2-jumlah" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" value='" . number_format(coalesce($curr_data['jumlah'], 0)) . "' required/></td>
								</tr>
								<tr>
									<td align='right'>Harga Satuan Rp.</td><td colspan='2'><input type='text' class='form-control thousand_format' id='input2-harga_satuan" . $order_num . "' name='input2-harga_satuan" . $order_num . "' value='" . number_format($ads_type_row['tarif_dasar']) . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'>Nilai Sewa Reklame Rp.</td><td colspan='2'><input type='text' class='form-control thousand_format' id='input2-nilai_sewa_reklame" . $order_num . "' value='" . number_format(coalesce($curr_data['nilai_sewa_reklame'], 0)) . "' name='input2-nilai_sewa_reklame" . $order_num . "' value='" . number_format(coalesce($curr_data['nilai_satuan_reklame'], 0)) . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'>Tarif Pajak (%)</td><td colspan='2'><input type='text' class='form-control thousand_format' id='input2-persen_tarif" . $order_num . "' name='input2-persen_tarif" . $order_num . "' value='" . number_format($tax_percentage, 2, '.', ',') . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'><b>Pajak Rp.</b></td><td colspan='2'><input type='text' class='form-control thousand_format' id='input2-pajak" . $order_num . "' name='input2-pajak" . $order_num . "' value='" . number_format(coalesce($curr_data['pajak'], 0)) . "' readonly/></td></tr>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>";
	} else if ($ads_type_id == 16 or ($ads_type_id >= 20 and $ads_type_id <= 23)) {
		echo "<div class='col-md-12'>
				<div class='form-group'>
					<div class='col-md-12'>
						<table class='table table-bordered'>
							<thead>
								<tr><td></td><td>Frekuensi (" . $ads_type_row['satuan_jangka_waktu'] . ")</td><td>Jumlah (" . $ads_type_row['satuan_ukuran'] . ")</td></tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td><input type='text' class='form-control' name='input2-jangka_waktu" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" id='input2-jangka_waktu" . $order_num . "' value='" . number_format(coalesce($curr_data['jangka_waktu'], 0)) . "' required/></td>
									<td>
									<input type='text' class='form-control' name='input2-jumlah" . $order_num . "' id='input2-jumlah" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" value='" . number_format(coalesce($curr_data['jumlah'], 0)) . "' required/>
									<input type='hidden' class='form-control' name='input2-ukuran" . $order_num . "' id='input2-ukuran" . $order_num . "' value='1'/>
									<input type='hidden' class='form-control' name='input2-nsl" . $order_num . "' id='input2-nsl" . $order_num . "' value='1'/>
									</td>
								</tr>
								<tr>
									<td align='right'>Harga Satuan Rp.</td><td colspan='2'><input type='text' class='form-control' id='input2-harga_satuan" . $order_num . "' name='input2-harga_satuan" . $order_num . "' value='" . number_format($ads_type_row['tarif_dasar']) . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'>Nilai Sewa Reklame Rp.</td><td colspan='2'><input type='text' class='form-control' id='input2-nilai_sewa_reklame" . $order_num . "' name='input2-nilai_sewa_reklame" . $order_num . "' value='" . number_format(coalesce($curr_data['nilai_sewa_reklame'], 0)) . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'>Tarif Pajak (%)</td><td colspan='2'><input type='text' class='form-control' id='input2-persen_tarif" . $order_num . "' name='input2-persen_tarif" . $order_num . "' value='" . number_format($tax_percentage, 2, '.', ',') . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'><b>Pajak Rp.</b></td><td colspan='2'><input type='text' class='form-control' id='input2-pajak" . $order_num . "' name='input2-pajak" . $order_num . "' value='" . number_format(coalesce($curr_data['pajak'], 0)) . "' readonly/></td></tr>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>";
	} else if ($ads_type_id == 17 or $ads_type_id == 18) {

		echo "<div class='col-md-12'>
				<div class='form-group'>
					<div class='col-md-12'>
						<table class='table table-bordered'>
							<thead>
								<tr><td></td><td>Ukuran (" . $ads_type_row['satuan_ukuran'] . ")</td><td>Frekuensi (" . $ads_type_row['satuan_jangka_waktu'] . ")</td></tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td>
									<input type='text' class='form-control' name='input2-ukuran" . $order_num . "' id='input2-ukuran" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" value='" . number_format(coalesce($curr_data['ukuran'], 0)) . "' required/>
									<input type='hidden' class='form-control' name='input2-jumlah" . $order_num . "' id='input2-jumlah" . $order_num . "' value='1'/>
									<input type='hidden' class='form-control' name='input2-nsl" . $order_num . "' id='input2-nsl" . $order_num . "' value='1'/>
									</td>
									<td><input type='text' class='form-control' name='input2-jangka_waktu" . $order_num . "' id='input2-jangka_waktu" . $order_num . "' onkeyup=\"adstax_execute_multifunction2(" . $order_num . ")\" value='" . number_format(coalesce($curr_data['jangka_waktu'], 0)) . "' required/></td>
								</tr>
								<tr>
									<td align='right'>Harga Satuan Rp.</td><td colspan='2'><input type='text' class='form-control' id='input2-harga_satuan" . $order_num . "' name='input2-harga_satuan" . $order_num . "' value='" . number_format($ads_type_row['tarif_dasar']) . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'>Nilai Sewa Reklame Rp.</td><td colspan='2'><input type='text' class='form-control' id='input2-nilai_sewa_reklame" . $order_num . "' name='input2-nilai_sewa_reklame" . $order_num . "' value='" . number_format(coalesce($curr_data['nilai_sewa_reklame'], 0)) . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'>Tarif Pajak (%)</td><td colspan='2'><input type='text' class='form-control' id='input2-persen_tarif" . $order_num . "' name='input2-persen_tarif" . $order_num . "' value='" . number_format($tax_percentage, 2, '.', ',') . "' readonly/></td></tr>
								</tr>
								<tr>
									<td align='right'><b>Pajak Rp.</b></td><td colspan='2'><input type='text' class='form-control' id='input2-pajak" . $order_num . "' name='input2-pajak" . $order_num . "' value='" . number_format(coalesce($curr_data['pajak'], 0)) . "' readonly/></td></tr>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>";
	}
	echo "</div>";
}

?>

<script type="text/javascript">
	$(document).ready(function() {
		$(".thousand_format").inputmask({
			'alias': 'numeric',
			rightAlign: true,
			'groupSeparator': '.',
			'autoGroup': true
		});

		$(".number").inputmask({
			'alias': 'numeric',
			'mask': '9999',
			rightAlign: true
		});
	});

	function load_class_road_value(class_id, ads_type_id) {

		$.ajax({

			type: 'POST',
			url: base_url + 'bundle/taxes/advertisement/record_tax_object_data/load_class_road_value',
			data: 'class_id=' + class_id + '&ads_type_id=' + ads_type_id + '&menu=' + menu,
			beforeSend: function() {

			},
			complete: function() {

			},
			success: function(data) {

				$('#input2-nilai_tarif').val(data);

			}

		})
	}
</script>