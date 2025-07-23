<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />
<input type="hidden" id="menu" value="<?= $menu; ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Form</th>
            <th>Nama</th>
            <th>Kegiatan Usaha</th>
            <th>Alamat</th>
            <th>Kelurahan<br />Kecamatan</th>
            <th>Status</th>
            <th>Tgl. Kirim<br />Tgl. Kembali</th>
            <th>Panel Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        foreach ($list_nonnpwpd as $row) {

            $no++;
            echo "<tr>
					<td align='center'>" . $no . "</td>
					<td align='center'>" . $row['no_form'] . "</td>
					<td>" . $row['nama'] . "</td>
					<td>" . $row['nama_kegus'] . "</td>
					<td>" . $row['alamat'] . "</td>
					<td>" . $row['kelurahan'] . "<br />" . $row['kecamatan'] . "</td>
					<td>" . $row['status'] . "</td>
					<td>" . $row['tgl_kirim'] . "<br />" . $row['tgl_kembali'] . "</td>					
					<td align='center'>";


            echo "
						<button class='btn btn-default' type='button' onclick=\"add_wp_wr(" . $row['wp_wr_form_id'] . ")\">Tambahkan</button>
					</td>
				</tr>";
        }
        ?>
    </tbody>
</table>
<script>
    function add_wp_wr(id) {
        base_url = $('#base_url').val();
        bundle_item_type = $('#bundle_item_type').val();
        menu = $('#menu').val();
        data_ajax = ['id=' + id];
        ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/addnonnpwpd')
            .set_data_ajax(data_ajax)
            .request_ajax();
    }
</script>