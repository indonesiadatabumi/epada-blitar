<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="<?= $bundle_item_type; ?>" />
<input type="hidden" id="menu" value="<?= $menu; ?>" />

<table id="data-table-jq" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>Npwpd</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tgl Terima Surat Teguran</th>
            <th>Tgl Jatuh Tempo Teguran</th>
            <th>Status</th>
            <th>Panel Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        foreach ($list_teguran as $row) {

            $no++;
            echo "<tr>
					<td align='center'>" . $no . "</td>
					<td align='center'>" . $row['npwprd'] . "</td>
					<td>" . $row['nama'] . "</td>
					<td>" . $row['alamat'] . "</td>
					<td>" . indo_date_format($row['created_time'], 'shortDate') . "</td>
					<td>" . indo_date_format($row['jatuh_tempo'], 'shortDate') . "</td>";
            if ($row['jatuh_tempo'] == null) {
                echo "<td>Belum Ditetapkan</td>";
            } elseif ($today > $row['jatuh_tempo'] || $today == $row['jatuh_tempo']) {
                echo "<td>Habis</td>";
            } elseif ($today < $row['jatuh_tempo']) {
                echo "<td>Aktif</td>";
            }

            if ($row['jatuh_tempo'] == null) {
                echo "<input type='hidden' id='id_teguran' name='id_teguran' value='" . $row['id_teguran'] . "'/>";
                echo  "<td align='center'><button class='btn btn-default' type='button' data-toggle='modal' data-target='#modal_teguran' onclick='tetapkan()'>Tetapkan</button>
					</td>";
            } else {
                echo  "<td align='center'><button class='btn btn-default' type='button' onclick=\"fill_report_type(" . $row['id_teguran'] . ");\"><i class='fa fa-print'></i></button></td>";
            }
            echo    "</tr>";
        }
        ?>
    </tbody>
</table>

<!-- MODAL -->
<div class="modal fade" id="modal_teguran" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Input tgl terima surat teguran</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="loader-teguran" class="" align="center"><img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" /></div>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="content-teguran">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END OF MODAL -->
<script>
    base_url = $('#base_url').val();
    bundle_item_type = $('#bundle_item_type').val();
    menu = $('#menu').val();

    function tetapkan() {
        ajax_object.reset_object();
        data_ajax = ['id_teguran=' + $('#id_teguran').val()];
        ajax_object.set_plugin_datatable(true)
            .set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/insert_penetapan')
            .set_loading('#loader-teguran')
            .set_content('#content-teguran')
            .set_data_ajax(data_ajax)
            .request_ajax();
    }

    function fill_report_type(id_teguran) {
        $.ajax({
            type: "post",
            url: base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/cetak_surat',
            data: {
                id_teguran: id_teguran
            },
            dataType: "html",
            success: function(response) {
                var tab = window.open('about:blank', '_blank');
                tab.document.write(response);
                tab.document.close();
            }
        })
    }
</script>