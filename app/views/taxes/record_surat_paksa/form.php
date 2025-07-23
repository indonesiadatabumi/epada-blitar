<form id="<?= $main_form_id; ?>" method="POST" action="<?= base_url() . "/bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/submit_form"; ?>" class="form-horizontal">
    <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
    <input type="hidden" name="id_value" value="<?= $id_value; ?>" />
    <input type="hidden" name="wp_wr_id" value="<?= $taxpayer_detail_row['wp_wr_id']; ?>" />
    <input type="hidden" name="pajak_id" value="<?= $taxpayer_detail_row['pajak_id']; ?>" />
    <!-- <input type="hidden" name="jatuh_tempo" value="<?= $jatuh_tempo; ?>" /> -->
    <input type="hidden" name="korek_id" value="<?= $taxpayer_detail_row['kode_rekening']; ?>" />
    <input type="hidden" name="masa_pajak1" value="<?= $taxpayer_detail_row['masa_pajak1']; ?>" />
    <input type="hidden" name="masa_pajak2" value="<?= $taxpayer_detail_row['masa_pajak2']; ?>" />
    <input type="hidden" name="kode_billing" value="<?= $taxpayer_detail_row['kode_billing']; ?>" />
    <input type="hidden" name="menu" value="<?= $menu; ?>" />

    <input type="hidden" id="curr_date" value="<?= date('d-m-Y'); ?>" />
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
                                    <input class="form-control" value="<?= $taxpayer_detail_row['npwpd']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Pajak</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['nama_pajak'] ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kegiatan Usaha</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['nama_rekening'] ?>" readonly />
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
                                    <input class="form-control" name="periode" id="periode" value="<?= $taxpayer_detail_row['tahun_pajak']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Masa Pajak</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= indo_date_format($taxpayer_detail_row['masa_pajak1'], 'longDate'); ?> - <?= indo_date_format($taxpayer_detail_row['masa_pajak2'], 'longDate') ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Jatuh Tempo</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" name="jatuh_tempo" id="jatuh_tempo" value="<?= date('d-m-Y') ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Tgl. Proses <font color="red">*</font></label>
                            <div class="col-md-4">
                                <div class="input">
                                    <input class="form-control" name="tgl_proses" id="tgl_proses" value="<?= ($act == 'edit' ? indo_date_format($curr_data['tgl_pemeriksaan'], 'shortDate') : date('d-m-Y')); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Billing</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= $taxpayer_detail_row['kode_billing']; ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Dasar Pengenaan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= number_format($taxpayer_detail_row['nilai_terkena_pajak'], 0, '.', ',') ?>" readonly />
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

                        <div class="form-group">
                            <label class="control-label col-md-3">Pajak</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= number_format($taxpayer_detail_row['pajak'], 0, '.', ',') ?>" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">No. Surat</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" name="no_surat" />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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
</script>