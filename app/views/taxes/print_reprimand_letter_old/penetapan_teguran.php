<form class="form-horizontal" id="form-user" action="<?= base_url() . "/bundle/taxes/" . $bundle_item_type . "/" . $menu . "/update_penetapan"; ?>" method="POST">
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-3"><b>Tgl Terima Surat Teguran</b></label>
                    <div class="col-md-9">
                        <div class="input">
                            <input type="hidden" id="id_teguran" name="id_teguran" value="<?= $id_teguran ?>" />
                            <input class=" form-control" name="created_time" id="created_time" value="<?= date('d-m-Y') ?>" />
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
                <button type="button" class="btn btn-default" id="close-user-form" data-dismiss="modal">
                    Batal
                </button>
            </div>
        </div>
    </div>
</form>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#created_time").mask('99-99-9999');

        // START AND FINISH DATE
        $('#created_time').datepicker({
            dateFormat: 'dd-mm-yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });
    });

    var main_form_id = 'form-user';
    var $main_form = $('#' + main_form_id);
    var submit_noty = ('menambah');
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
                .set_loading('#loader-list-data')
                .enable_pnotify()
                .set_form($main_form)
                .submit_ajax_reload(submit_noty);
            $('#close-user-form').click();
            return false;
        }
    });
</script>