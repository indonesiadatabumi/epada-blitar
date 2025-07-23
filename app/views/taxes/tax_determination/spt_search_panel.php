<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" id="search_form2" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/form"; ?>" method="POST">
            <input type="hidden" name="menu" value="<?= $menu; ?>" />
            <input type="hidden" name="act" value="<?= $act; ?>" />
            <input type="hidden" name="showed" value="<?= $showed; ?>" />
            <?php
            foreach ($src_params as $key => $val) {
                echo "<input type='hidden' name='src-" . $key . "' value='" . $val . "'/>";
            }
            foreach ($src_daterange_params as $key => $val) {
                echo "<input type='hidden' name='src_date_range-" . $key . "' value='" . $val . "'>";
            }
            ?>

            <div class="form-group">
                <label class="control-label col-md-2">Jenis Pajak</label>
                <div class="col-md-4">
                    <div class="input">
                        <input class="form-control" type="text" value="<?= $bundle_name; ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Periode</label>
                <div class="col-md-1">
                    <div class="input">
                        <input class="form-control number" type="text" name="tahun_pajak" id="tahun_pajak" value="<?= date('Y'); ?>" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Tgl. Penetapan</label>
                <div class="col-md-2">
                    <div class="input">
                        <input class="form-control" id="tgl_penetapan" name="tgl_penetapan" value="<?= date('d-m-Y'); ?>" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Nomor SPT <font color="red">*</font></label>
                <div class="col-md-2">
                    <div class="input">
                        <input class="form-control number" type="text" name="nomor_spt_awal" id="nomor_spt_awal" placeholder="No. SPT Awal" required />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input">
                        <input class="form-control number" type="text" name="nomor_spt_akhir" id="nomor_spt_akhir" placeholder="No. SPT Akhir" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </div>
        </form>
        <br />
        <div id="loader-list-data2" style="display:none;" align="center">
            <img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
        </div>
        <div id="list-data2">
            <div class="alert alert-warning">
                Silahkan masukkan Nomor SPT Awal dan Akhir pada isian di atas !
            </div>
        </div>
    </div>
</div>

<div id="loader-form" style="display:none;" align="center">
    <img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
</div>

<div id="content-form">
</div>

<script type="text/javascript">
    var search_form2_id = 'search_form2';
    var $search_form2 = $('#' + search_form2_id);
    var search_form2_stat = $search_form2.validate({
        // Do not change code below
        errorPlacement: function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

    $search_form2.submit(function() {
        if (search_form2_stat.checkForm()) {
            ajax_object.reset_object();
            ajax_object.set_plugin_datatable(false)
                .set_content('#list-data2')
                .set_loading('#loader-list-data2')
                .disable_pnotify()
                .set_form($search_form2)
                .submit_ajax('');
            return false;
        }
    });

    function load_form2_content(id) {
        ajax_object.reset_object();

        ajax_object.set_url(base_url + 'bundle/taxes/' + bundle_item_type + '/' + menu + '/form')
            .set_id_input(id)
            .set_input_ajax('ajax-req-dt')
            .set_data_ajax(data_ajax)
            .set_loading('#loader-form')
            .set_content('#content-form')
            .request_ajax();

    }


    $(document).ready(function() {
        $(".number").inputmask({
            'alias': 'numeric',
            'mask': '9999',
            rightAlign: false
        });

        $("#tgl_penetapan").mask('99-99-9999');

        // START AND FINISH DATE
        $("#tgl_penetapan").datepicker({
            dateFormat: 'dd-mm-yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });
    });
</script>