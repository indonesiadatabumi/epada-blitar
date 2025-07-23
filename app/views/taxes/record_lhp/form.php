<form id="<?= $main_form_id; ?>" method="POST" action="<?= base_url() . "/bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/submit_form"; ?>" class="form-horizontal">
    <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
    <input type="hidden" name="id_value" value="<?= $id_value; ?>" />
    <input type="hidden" name="wp_wr_id" value="<?= $taxpayer_detail_row['wp_wr_id']; ?>" />
    <input type="hidden" name="wp_wr_detil_id" value="<?= $wp_wr_detil_id; ?>" />
    <input type="hidden" name="pajak_id" value="<?= $taxpayer_detail_row['pajak_id']; ?>" />
    <input type="hidden" name="kegus_id" value="<?= $taxpayer_detail_row['kegus_id']; ?>" />
    <input type="hidden" name="menu" value="<?= $menu; ?>" />

    <input type="hidden" id="curr_date" value="<?= date('d-m-Y'); ?>" />
    <input type="hidden" id="bundle_id" value="<?= $bundle_id; ?>" />
    <input type="hidden" id="interest_percent" value="<?= $taxpayer_detail_row['persen_denda']; ?>" />

    <?php
    echo "
    <input type='hidden' name='input-" . ($act == 'add' ? 'created' : 'modified') . "_by' value='" . $this->session->userdata('username') . "'/>
    <input type='hidden' name='input-" . ($act == 'add' ? 'created' : 'modified') . "_time' value='" . date('Y-m-d H:i:s') . "'/>";

    if ($act == 'add') {
        echo "
        <input type='hidden' name='input-modified_time' value='" . date('Y-m-d H:i:s') . "'/>
        <input type='hidden' name='input-wp_wr_id' value='" . $taxpayer_detail_row['wp_wr_id'] . "'/>";
    }
    ?>

    <input type="hidden" name="showed" value="<?= $showed; ?>" />

    <?php
    foreach ($src_params as $key => $val) {
        echo "<input type='hidden' name='src-" . $key . "' value='" . $val . "'/>";
    }
    foreach ($src_daterange_params as $key => $val) {
        echo "<input type='hidden' name='src_date_range-" . $key . "' value='" . $val . "'/>";
    }
    ?>

    <fieldset>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-info"></i> Profil Wajib Pajak
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">NPWPD</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" name="input-npwprd" value="<?= $taxpayer_detail_row['npwprd']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Pajak</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['kode_pajak'] . ' - ' . $taxpayer_detail_row['nama_pajak']; ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kegiatan Usaha</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['kode_kegus'] . ' - ' . $taxpayer_detail_row['nama_kegus']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Nama WP</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['nama_wp']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['kelurahan']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kelurahan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['kelurahan']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kecamatan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['kecamatan']; ?>" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-money"></i> Data Induk
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="control-label col-md-3">Sistem Pemungutan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['jenis_pemungutan']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Periode SPT</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" name="tahun_pajak" value="<?= ($act == 'add' ? date('Y') : $curr_data['tahun_pajak']); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">No. Pemeriksaan/Teguran <font color="red">*</font></label>
                            <div class='col-md-9'>
                                <div class='input'>
                                    <input class="form-control" name="input-no_pemeriksaan" id="input-no_pemeriksaan" value="<?= $curr_data['no_pemeriksaan'] ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Tgl. Pemeriksaan/Teguran <font color="red">*</font></label>
                            <div class="col-md-4">
                                <div class="input">
                                    <input class="form-control" name="input-tgl_pemeriksaan-date" id="input-tgl_pemeriksaan" value="<?= ($act == 'edit' ? indo_date_format($curr_data['tgl_pemeriksaan'], 'shortDate') : date('d-m-Y')); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Rekening <font color="red">*</font></label>
                            <div class="col-md-9">
                                <div class="input state-disabled">
                                    <select class="form-control" name="input-rekening_id" id="input-rekening_id" onchange="fill_tax_rate(this.value)" required>
                                        <option value=""></option>
                                        <?php
                                        if ($act == 'add') {
                                            foreach ($account_rows as $row) {
                                                $selected = ($row['ref_id'] == $taxpayer_detail_row['kegus_id'] && $row['jenis_rekening'] == 'A' ? 'selected' : '');
                                                echo "<option value='" . $row['rekening_id'] . "_" . $row['persen_tarif'] . "' " . $selected . ">" . $row['nama_rekening'] . " (" . $row['kode_rekening'] . ")</option>";
                                            }
                                        } else {
                                            foreach ($account_rows as $row) {
                                                $selected = ($row['ref_id'] == $curr_data['kegus_id'] && $row['jenis_rekening'] == 'A' ? 'selected' : '');
                                                echo "<option value='" . $row['rekening_id'] . "_" . $row['persen_tarif'] . "' " . $selected . ">" . $row['nama_rekening'] . " (" . $row['kode_rekening'] . ")</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Ketetapan <font color="red">*</font></label>
                            <div class="col-md-9">
                                <div class="input state-disabled">
                                    <select class="form-control" name="input-jenis_spt_id" id="input-jenis_spt_id" required>
                                        <option value=""></option>
                                        <?php
                                        foreach ($spt_type_rows as $row) {
                                            $selected = ($curr_data['jenis_spt_id'] == $row['ref_jenspt_id'] ? 'selected' : '');
                                            echo "<option value='" . $row['ref_jenspt_id'] . "' " . $selected . ">" . $row['keterangan'] . " (" . $row['singkatan'] . ")</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <textarea class="form-control" name="input-keterangan" id="input-keterangan" rows="2"><?= $curr_data['keterangan']; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Hasil Pemeriksaan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <textarea class="form-control" name="input-hasil_pemeriksaan" id="input-hasil_pemeriksaan" rows="2"><?= $curr_data['hasil_pemeriksaan']; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kesimpulan & Saran</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <textarea class="form-control" name="input-kesimpulan" id="input-kesimpulan" rows="2"><?= $curr_data['kesimpulan']; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Tarif (%)</label>
                            <div class="col-md-2">
                                <div class="input">
                                    <input class="form-control thousand_format" name="persen_tarif" id="persen_tarif" value="<?= $taxpayer_detail_row['persen_tarif']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered custom-table">
            <thead>
                <tr>
                    <td rowspan="2">SPT</td>
                    <td rowspan="2">Masa Pajak1</td>
                    <td rowspan="2">Masa Pajak2</td>
                    <td>Dasar Pengenaan</td>
                    <td>Pajak Terhutang</td>
                    <td>Kredit Pajak</td>
                    <td>Pokok Pajak</td>
                    <td>Sanksi</td>
                    <td width="10%">Jumlah Pajak</td>
                    <td rowspan="2"></td>
                </tr>
                <tr>
                    <td>(a)</td>
                    <td>(b)</td>
                    <td>(c)</td>
                    <td>(d)=(b-c)</td>
                    <td>(e)=(d) x 1,8% x jml. bulan</td>
                    <td>(f)=(d+e)</td>
                </tr>
            </thead>
            <tbody id="detail-tbody">
                <?php
                $i = 1;
                if ($act == 'add') {
                    echo "
                    <tr id='row-1'>
                        <td align='center'><button type='button' class='btn btn-default btn-xs'>...</button></td>
                        <td><input class='datepicker' name='input2-masa_pajak11' id='input2-masa_pajak11' style='width:100%' onblur=\"mix_function1(1)\" required/><br />dd-mm-yyyy</td>
                        <td><input class='datepicker' name='input2-masa_pajak21' id='input2-masa_pajak21' style='width:100%' required/><br />dd-mm-yyyy</td>
                        <td><input class='thousand_format' name='input2-nilai_terkena_pajak1' id='input2-nilai_terkena_pajak1' style='width:100%' onkeyup=\"mix_function2(1)\" required/></td>
                        <td><input class='thousand_format disabled' name='input2-pajak_terhutang1' id='input2-pajak_terhutang1' style='width:100%' readonly/></td>
                        <td>
                            <label>Setoran :</label><br /><input class='thousand_format' name='input2-setoran1' id='input2-setoran1' onkeyup=\"mix_function3(1)\" required/><br />
                            <label>Kompensasi :</label><br /><input class='thousand_format' name='input2-kompensasi1' id='input2-kompensasi1' onkeyup=\"mix_function3(1)\"/><br />
                            <label>Lain-lain :</label><br /><input class='thousand_format' name='input2-kredit_pajak_lain1' id='input2-kredit_pajak_lain1' onkeyup=\"mix_function3(1)\"/><br />
                            <hr style='margin:5px 2px!important;border-top:1px solid #000'></hr>
                            <label>Total :</label><br /><input class='thousand_format disabled' name='input2-total_kredit_pajak1' id='input2-total_kredit_pajak1' readonly/>
                        </td>

                        <td><input class='thousand_format disabled' name='input2-pokok_pajak1' id='input2-pokok_pajak1' style='width:100%' readonly/></td>
                        <td>
                            <label>Bunga :</label><br /><input class='thousand_format disabled' name='input2-bunga1' id='input2-bunga1' readonly/><br />
                            <label>Kenaikan :</label><br /><input class='thousand_format' name='input2-kenaikan1' id='input2-kenaikan1' onkeyup=\"mix_function4(1)\"/><br />
                            <hr style='margin:5px 2px!important;border-top:1px solid #000'></hr>
                            <label>Total :</label><br /><input class='thousand_format disabled' name='input2-total_sanksi1' id='input2-total_sanksi1' readonly/>
                        </td>
                        <td><input name='input2-pajak1' class='thousand_format disabled' id='input2-pajak1' style='width:100%' readonly/></td>
                        <td></td>
                    </tr>";
                } else {
                    $i = 0;
                    foreach ($curr_data2 as $row) {
                        $i++;
                        echo "
                        <tr id='row-" . $i . "'>
                            <td align='center'><button type='button' class='btn btn-default btn-xs'>...</button></td>
                            <td><input class='datepicker' name='input2-masa_pajak1" . $i . "' id='input2-masa_pajak1" . $i . "' style='width:100%' onblur=\"mix_function1(" . $i . ")\" value='" . indo_date_format($row['masa_pajak1'], 'shortDate') . "' required/><br />dd-mm-yyyy</td>
                            <td><input class='datepicker' name='input2-masa_pajak2" . $i . "' id='input2-masa_pajak2" . $i . "' style='width:100%' value='" . indo_date_format($row['masa_pajak2'], 'shortDate') . "' required/><br />dd-mm-yyyy</td>
                            <td><input class='thousand_format' name='input2-nilai_terkena_pajak" . $i . "' id='input2-nilai_terkena_pajak" . $i . "' value='" . number_format($row['nilai_terkena_pajak']) . "' style='width:100%' onkeyup=\"mix_function2(" . $i . ")\" required/></td>
                            <td><input class='thousand_format disabled' name='input2-pajak_terhutang" . $i . "' id='input2-pajak_terhutang" . $i . "' value='" . number_format($row['pajak_terhutang']) . "' style='width:100%' readonly/></td>
                            <td>
                                <label>Setoran :</label><br /><input class='thousand_format' name='input2-setoran" . $i . "' id='input2-setoran" . $i . "' value='" . number_format($row['setoran']) . "' onkeyup=\"mix_function3(" . $i . ")\" required/><br />
                                <label>Kompensasi :</label><br /><input class='thousand_format' name='input2-kompensasi" . $i . "' id='input2-kompensasi" . $i . "' value='" . ($row['kompensasi'] != '' ? number_format($row['kompensasi']) : '') . "' onkeyup=\"mix_function3(" . $i . ")\"/><br />
                                <label>Lain-lain :</label><br /><input class='thousand_format' name='input2-kredit_pajak_lain" . $i . "' id='input2-kredit_pajak_lain" . $i . "' value='" . ($row['kredit_pajak_lain'] != '' ? number_format($row['kredit_pajak_lain']) : '') . "' onkeyup=\"mix_function3(" . $i . ")\"/><br />
                                <hr style='margin:5px 2px!important;border-top:1px solid #000'></hr>
                                <label>Total :</label><br /><input class='thousand_format disabled' name='input2-total_kredit_pajak" . $i . "' id='input2-total_kredit_pajak" . $i . "' value='" . number_format($row['total_kredit_pajak']) . "' readonly/>
                            </td>

                            <td><input class='thousand_format disabled' name='input2-pokok_pajak" . $i . "' id='input2-pokok_pajak" . $i . "' value='" . number_format($row['pokok_pajak']) . "' style='width:100%' readonly/></td>
                            <td>
                                <label>Bunga :</label><br /><input class='thousand_format disabled' name='input2-bunga" . $i . "' id='input2-bunga" . $i . "' value='" . number_format($row['bunga']) . "' readonly/><br />
                                <label>Kenaikan :</label><br /><input class='thousand_format' name='input2-kenaikan" . $i . "' id='input2-kenaikan" . $i . "' value='" . ($row['kenaikan'] != '' ? number_format($row['kenaikan']) : '') . "' onkeyup=\"mix_function4(" . $i . ")\"/><br />
                                <hr style='margin:5px 2px!important;border-top:1px solid #000'></hr>
                                <label>Total :</label><br /><input class='thousand_format disabled' name='input2-total_sanksi" . $i . "' id='input2-total_sanksi" . $i . "' value='" . number_format($row['total_sanksi']) . "' readonly/>
                            </td>
                            <td><input name='input2-pajak" . $i . "' class='thousand_format disabled' id='input2-pajak" . $i . "' value='" . number_format($row['pajak']) . "' style='width:100%' readonly/></td>
                            <td>";
                        if ($i > 1) {
                            echo "<button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail_row(" . $i . ");\"><i class='fa fa-trash-o'></i></button>";
                        }
                        echo "</td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="center"><a href="javascript:;" style="color:#000;" onclick="add_detail_row()"><i class='fa fa-plus'></i> Tambah baris</a></td>
                    <td colspan="2" align="right"><b>TOTAL</b></td>
                    <td colspan="3"><input class="form-control" name="input-pajak-int" id="input-pajak" value="<?= ($act == 'edit' ? number_format($curr_data['pajak']) : ''); ?>" style="text-align:right;font-weight:bold;font-size:1.6em;color:#fff;background:#f9a602;border:2px solid #fcf63f;" readonly /></td>
                    <input type="hidden" id="n_detail_rows" name="n_detail_rows" value="<?= $i; ?>" />
                </tr>
            </tfoot>
        </table>
    </fieldset>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <button type="button" class="btn btn-default" id="close-modal-form" data-dismiss="modal">
                    Batal
                </button>
            </div>
        </div>
    </div>
</form>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#input-tgl_pemeriksaan").mask('99-99-9999');


        $('#input-tgl_pemeriksaan').datepicker({
            dateFormat: 'dd-mm-yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });

        init_jquery_plugin();

    });

    function init_jquery_plugin() {

        $('.datepicker').mask('99-99-9999');

        // $('.datepicker').datepicker({
        //     dateFormat : 'dd-mm-yy',
        //     prevText : '<i class="fa fa-chevron-left"></i>',
        //     nextText : '<i class="fa fa-chevron-right"></i>',


        // });

        $(".thousand_format").inputmask({
            'alias': 'numeric',
            rightAlign: true,
            'groupSeparator': '.',
            'autoGroup': true
        });
    }

    var main_form_id = '<?= $main_form_id; ?>';
    var $main_form = $('#' + main_form_id);
    var submit_noty = ($('#act').val() == 'add' ? 'menambah' : 'merubah');
    var main_form_stat = $main_form.validate({
        // Do not change code below
        errorPlacement: function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

    $main_form.submit(function() {
        if (main_form_stat.checkForm()) {
            ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true)
                .set_content('#list-data')
                .set_loading('#loader-list-data')
                .enable_pnotify()
                .set_form($main_form)
                .submit_ajax(submit_noty);
            $('#close-modal-form').click();
            return false;
        }
    });

    function delete_detail_row(order_num) {
        var $tr = $('#detail-tbody > tr');
        $tr.remove('#row-' + order_num);
        assess_grand_tax();
        init_jquery_plugin();
    }


    function add_detail_row() {

        var $tbody = $('#detail-tbody'),
            $lc_tbody = $('#detail-tbody tr:last-child'),
            $n_rows = $('#n_detail_rows');

        var last_row_id = $lc_tbody.attr('id');

        x = last_row_id.split('-');
        last_order = x[1];
        new_order = parseInt(last_order) + 1;

        new_row = "<tr id='row-" + new_order + "'><td><button type='button' class='btn btn-default btn-xs'>...</button></td>" +
            "<td><input class='datepicker' name='input2-masa_pajak1" + new_order + "' id='input2-masa_pajak1" + new_order + "' onblur=\"mix_function1(" + new_order + ")\" style='width:100%' required/><br />dd-mm-yyyy</td>" +
            "<td><input class='datepicker' name='input2-masa_pajak2" + new_order + "' id='input2-masa_pajak2" + new_order + "' style='width:100%' required/><br />dd-mm-yyyy</td>" +
            "<td><input class='thousand_format' name='input2-nilai_terkena_pajak" + new_order + "' id='input2-nilai_terkena_pajak" + new_order + "' style='width:100%' onkeyup=\"mix_function2(" + new_order + ")\" required/></td>" +
            "<td><input class='thousand_format' name='input2-pajak_terhutang" + new_order + "' id='input2-pajak_terhutang" + new_order + "' style='width:100%' readonly/></td>" +
            "<td><label>Setoran :</label><br /><input class='thousand_format' name='input2-setoran" + new_order + "' id='input2-setoran" + new_order + "' onkeyup=\"mix_function3(" + new_order + ")\" required/><br />" +
            "<label>Kompensasi :</label><br /><input class='thousand_format' name='input2-kompensasi" + new_order + "' id='input2-kompensasi" + new_order + "' onkeyup=\"mix_function3(" + new_order + ")\"/><br />" +
            "<label>Lain-lain :</label><br /><input class='thousand_format' name='input2-kredit_pajak_lain" + new_order + "' id='input2-kredit_pajak_lain" + new_order + "' onkeyup=\"mix_function3(" + new_order + ")\"/><br />" +
            "<hr style='margin:5px 2px!important;border-top:1px solid #000'></hr>" +
            "<label>Total :</label><br /><input class='thousand_format disabled' name='input2-total_kredit_pajak" + new_order + "' id='input2-total_kredit_pajak" + new_order + "' readonly/></td>" +
            "<td><input class='thousand_format disabled' name='input2-pokok_pajak" + new_order + "' id='input2-pokok_pajak" + new_order + "' style='width:100%' readonly/></td>" +
            "<td><label>Bunga :</label><br /><input class='thousand_format disabled' name='input2-bunga" + new_order + "' id='input2-bunga" + new_order + "' reaodnly/><br />" +
            "<label>Kenaikan :</label><br /><input class='thousand_format' name='input2-kenaikan" + new_order + "' id='input2-kenaikan" + new_order + "' onkeyup=\"mix_function4(" + new_order + ")\"/><br />" +
            "<hr style='margin:5px 2px!important;border-top:1px solid #000'></hr>" +
            "<label>Total :</label><br /><input class='thousand_format disabled' name='input2-total_sanksi" + new_order + "' id='input2-total_sanksi" + new_order + "' readonly/></td>" +
            "<td><input name='input2-pajak" + new_order + "' class='thousand_format disabled' id='input2-pajak" + new_order + "' style='width:100%' readonly/></td>" +
            "<td><button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail_row(" + new_order + ");\"><i class='fa fa-trash-o'></i></button></td></tr>";

        $n_rows.val(new_order);
        $tbody.append(new_row);

        init_jquery_plugin();

    }

    function assess_tax_payable(i) {
        var $base = $('#input2-nilai_terkena_pajak' + i),
            $percent = $('#persen_tarif'),
            $tax_payable = $('#input2-pajak_terhutang' + i);
        var base = gnv($base.val()),
            percent = gnv($percent.val()),
            tax_payable = 0;

        base = replaceall(base, ',', '');
        percent = replaceall(percent, ',', '');

        tax_payable = parseFloat(base) * (parseFloat(percent) / 100);
        tax_payable = (tax_payable == 0 ? 0 : number_format(tax_payable, 0, '.', ','));

        $tax_payable.val(tax_payable);
    }

    function sum_tax_credit(i) {

        var $deposit = $('#input2-setoran' + i),
            $compensation = $('#input2-kompensasi' + i),
            $other = $('#input2-kredit_pajak_lain' + i),
            $total_credit = $('#input2-total_kredit_pajak' + i);
        var deposit = gnv($deposit.val()),
            compensation = gnv($compensation.val()),
            other = gnv($other.val()),
            total_credit = 0;

        deposit = replaceall(deposit, ',', '');
        compensation = replaceall(compensation, ',', '');
        other = replaceall(other, ',', '');

        total_credit = parseFloat(deposit) + parseFloat(compensation) + parseFloat(other);

        total_credit = (total_credit == 0 ? 0 : number_format(total_credit, 0, '.', ','));

        $total_credit.val(total_credit);
    }

    function assess_pure_tax(i) {

        var $tax_payable = $('#input2-pajak_terhutang' + i),
            $total_credit = $('#input2-total_kredit_pajak' + i),
            $pure_tax = $('#input2-pokok_pajak' + i);
        var tax_payable = gnv($tax_payable.val()),
            total_credit = gnv($total_credit.val()),
            pure_tax = 0;

        tax_payable = replaceall(tax_payable, ',', '');
        total_credit = replaceall(total_credit, ',', '');

        pure_tax = parseFloat(tax_payable) - parseFloat(total_credit);

        pure_tax = (pure_tax == 0 ? 0 : number_format(pure_tax, 0, '.', ','));

        $pure_tax.val(pure_tax);
    }

    function sum_tax_penalty(i) {

        var $interest = $('#input2-bunga' + i),
            $increment = $('#input2-kenaikan' + i),
            $total_penalty = $('#input2-total_sanksi' + i);
        var interest = gnv($interest.val()),
            increment = gnv($increment.val()),
            total_penalty = 0;

        interest = replaceall(interest, ',', '');
        increment = replaceall(increment, ',', '');

        total_penalty = parseFloat(interest) - parseFloat(increment);

        total_penalty = (total_penalty == 0 ? 0 : number_format(total_penalty, 0, '.', ','));

        $total_penalty.val(total_penalty);
    }

    function assess_total_tax(i) {

        var $pure_tax = $('#input2-pokok_pajak' + i),
            $total_penalty = $('#input2-total_sanksi' + i),
            $total_tax = $('#input2-pajak' + i);
        var pure_tax = gnv($pure_tax.val()),
            total_penalty = gnv($total_penalty.val()),
            total_tax = 0;

        pure_tax = replaceall(pure_tax, ',', '');
        total_penalty = replaceall(total_penalty, ',', '');

        total_tax = parseFloat(pure_tax) + parseFloat(total_penalty);

        total_tax = (total_tax == 0 ? 0 : number_format(total_tax, 0, '.', ','));

        $total_tax.val(total_tax);
    }

    function assess_tax_interest(i) {

        var $curr_date = $('#curr_date'),
            $date1 = $('#input2-masa_pajak1' + i),
            // $pure_tax = $('#input2-pokok_pajak' + i),
            $pure_tax = $('#input2-pajak_terhutang' + i),
            $pure_tax2 = $('#input2-pokok_pajak' + i),
            $bundle_id = $('#bundle_id').val(),
            $interest = $('#input2-bunga' + i);
        var curr_date = $curr_date.val(),
            date1 = ($date1.val() != '' ? $date1.val() : curr_date),
            pure_tax = gnv($pure_tax.val()),
            pure_tax2 = gnv($pure_tax2.val()),
            interest_percent = $('#interest_percent').val(),
            interest = 0;

        pure_tax = replaceall(pure_tax, ',', '');
        pure_tax2 = replaceall(pure_tax2, ',', '');

        x_curr_date = curr_date.split('-');
        x_date1 = date1.split('-');
        starYear = parseInt(x_date1[2])
        starMonth = parseInt(x_date1[1])
        endYear = parseInt(x_curr_date[2])
        endMonth = parseInt(x_curr_date[1])
        // if (starMonth != 12) {
        //     starMonth = starMonth + 1
        // } else {
        //     starMonth = 1
        //     starYear = starYear + 1
        // }

        difYear = endYear - starYear
        difMonth = endMonth - starMonth

        if (difYear == 0 && difMonth > 0) {
            difMonth = difMonth - 1
        } else if (difYear == 1) {
            startToEnd = 12 - starMonth
            difMonth = startToEnd + endMonth - 1
        } else if (difYear > 1) {
            startToEnd = 12 - starMonth
            // yearsReaming = difYear - 1
            // remainingMonths = 12 * yearsReaming
            remainingMonths = 12 * difYear
            difMonth = startToEnd + remainingMonths - 4
        }


        if (difMonth > 24) {
            difMonth = 24
        }

        // n_month = (parseInt(x_curr_date[1]) - 1) - parseInt(x_date1[1]);
        // n_month = (n_month < 0 ? 0 : n_month);

        if ($bundle_id == '6') {
            interest = (parseFloat(pure_tax2) * parseFloat(interest_percent) / 100) * difMonth;
        } else {
            interest = (parseFloat(pure_tax2) * parseFloat(interest_percent) / 100) * difMonth;
        }

        interest = (interest == 0 ? 0 : number_format(interest, 0, '.', ','));

        $interest.val(interest);

    }

    function fill_tax_rate(val) {

        var $percent = $('#persen_tarif');

        var x_account = $('#input-rekening_id').val().split('_');

        $percent.val(x_account[1]);

    }

    function assess_grand_tax() {

        var n_rows = parseInt($('#n_detail_rows').val()),
            $total = $('#input-pajak');

        var total = 0;

        for (i = 1; i <= n_rows; i++) {
            $sub = $('#input2-pajak' + i);
            if ($sub.length) {
                sub = gnv($sub.val());
                sub = replaceall(sub, ',', '');
                total += parseFloat(sub);
            }
        }

        total = number_format(total, 0, '.', ',');

        $total.val(total);

    }

    function mix_function1(i) {
        assess_tax_interest(i);
        sum_tax_penalty(i);
        assess_total_tax(i);

        assess_grand_tax();
    }

    function mix_function2(i) {
        assess_tax_payable(i);
        assess_pure_tax(i);

        assess_tax_interest(i);
        sum_tax_penalty(i);
        assess_total_tax(i);

        assess_grand_tax();
    }

    function mix_function3(i) {
        sum_tax_credit(i);
        assess_pure_tax(i);
        assess_tax_interest(i);
        sum_tax_penalty(i);
        assess_total_tax(i);

        assess_grand_tax();
    }

    function mix_function4(i) {
        sum_tax_penalty(i);
        assess_total_tax(i);

        assess_grand_tax();
    }
</script>