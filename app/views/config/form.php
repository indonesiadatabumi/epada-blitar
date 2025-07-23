<form class="form-horizontal">
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
                        <?php foreach ($list_privileges->result() as $row) { ?>
                            <tr>
                                <td><?= $row->title ?></td>
                                <td><input id="read-<?= $row->privilege_id ?>" onclick="checkbox_clicked(<?= $row->privilege_id ?>, 'read')" type="checkbox" <?= $row->read_priv == 1 ? "checked" : "" ?> /></td>
                                <td><input id="add-<?= $row->privilege_id ?>" onclick="checkbox_clicked(<?= $row->privilege_id ?>, 'add')" type="checkbox" <?= $row->add_priv == 1 ? "checked" : "" ?> /></td>
                                <td><input id="update-<?= $row->privilege_id ?>" onclick="checkbox_clicked(<?= $row->privilege_id ?>, 'update')" type="checkbox" <?= $row->update_priv == 1 ? "checked" : "" ?> /></td>
                                <td><input id="delete-<?= $row->privilege_id ?>" onclick="checkbox_clicked(<?= $row->privilege_id ?>, 'delete')" type="checkbox" <?= $row->delete_priv == 1 ? "checked" : "" ?> /></td>
                                <td><input id="print-<?= $row->privilege_id ?>" onclick="checkbox_clicked(<?= $row->privilege_id ?>, 'print')" type="checkbox" <?= $row->print_priv == 1 ? "checked" : "" ?> /></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-default" id="close-modal-form" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-12" align="center">
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

    function checkbox_clicked(id, which) {
        $.ajax({
            url: base_url + "/config/updatePrivileges/" + id + "/" + which + "_priv/" + $("#" + which + "-" + id).is(":checked"),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(result) {
                console.log(result);
            }
        });
    }

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