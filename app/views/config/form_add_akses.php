<form class="form-horizontal" id="form-user" action="<?= base_url() . "/config/add_akses"; ?>" method="POST">
    <input type="hidden" name="user_type_id" value="<?= $id_user_type; ?>">
    <input type="hidden" name="bundle_id" value="<?= $bundle_id; ?>">
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Read</th>
                            <th>Add</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <?php
                                foreach ($bundle_rows->result() as $row) { ?>
                            <tr>
                                <td><input type="text" name="menu_bundle_id" value="<?= $row->menu_bundle_id; ?>"></td>
                                <td><?= $row->title ?></td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="read_priv" value="1">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="add_priv" value="1">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="update_priv" value="1">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="delete_priv" value="1">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="print_priv" value="1">
                                    </div>
                                </td>
                                
                            </tr>
                        <?php } ?> -->
                        <tr>
                            <td>
                                <select class="form-control form-control-sm" name="menu_bundle_id" id="menu_bundle_id">
                                    <option value="" disabled selected>-Choose Menu-</option>
                                    <?php
                                    foreach ($bundle_rows->result() as $row) :
                                        var_dump($row);
                                    ?>
                                        <option value="<?= $row->menu_bundle_id; ?>"><?= $row->title; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="read_priv" value="1">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="add_priv" value="1">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="update_priv" value="1">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="delete_priv" value="1">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="print_priv" value="1">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="submit" class="btn btn-primary">
                    Tambah
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
        $("#input-tgl_kirim,#input-tgl_kembali").mask('99-99-9999');

        // START AND FINISH DATE
        $('#input-tgl_kirim,#input-tgl_kembali').datepicker({
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