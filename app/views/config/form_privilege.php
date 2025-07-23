<form class="form-horizontal">
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>Nama Paret</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th></th>
                        </tr>									
                    </thead>
                    <tbody>
                    <?php foreach ($bundle_rows->result() as $row){ ?>
                            <tr>
                                <td><?=$row->nama_paret?></td>
                                <td><?=$row->tipe?></td>
                                <td><?=$row->status?></td>
                                <td>
                                    <button
                                        onclick="load_form_content(<?=$row->bundel_id?>)" 
                                        class='btn btn-success' 
                                        type='button' 
                                        id='btn-update' 
                                        data-toggle='modal' 
                                        data-target='#formModal'>
                                            <i class='fa fa-edit'></i> 
                                            Update Privileges
                                    </button>
                                </td>
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

<!-- MODAL -->
<div class="modal" id="formModal2" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1200px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">List Privileges</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="content-formModal2">
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- END OF MODAL -->

<script src="<?=$this->config->item('js_path');?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        $("#input-tgl_kirim,#input-tgl_kembali").mask('99-99-9999');     

        // START AND FINISH DATE
        $('#input-tgl_kirim,#input-tgl_kembali').datepicker({
            dateFormat : 'dd-mm-yy',
            prevText : '<i class="fa fa-chevron-left"></i>',
            nextText : '<i class="fa fa-chevron-right"></i>'            
        });
    });
    var main_form_id = '<?=$main_form_id;?>';
    var $main_form = $('#'+main_form_id);
    var submit_noty = ($('#act').val()=='add'?'menambah':'merubah');
    var main_form_stat = $main_form.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

    function load_form_content(id){
		// ajax_object.reset_object();
		
		showed = $('#showed').val();
		
		data_ajax = ['showed='+showed];

        ajax_object.set_url(base_url+'/config/form/'+id)
        		   .set_id_input(id)
        		   .set_input_ajax('ajax-req-dt')
        		   .set_data_ajax(data_ajax)
        		   .set_loading('#loader-formModal2')
        		   .set_content('#content-formModal2')
        		   .request_ajax();
	}

    function checkbox_clicked(id, which){
        console.log(id+" "+which+" "+$("#"+id).is(":checked"));
        $.ajax({
			url: base_url+"/config/updatePrivileges/"+id+"/"+which+"/"+$("#"+id).is(":checked"),
			headers: {'X-Requested-With': 'XMLHttpRequest'},
			success: function(result){
				console.log(result);
			}
		});
    }

    $main_form.submit(function(){
        if(main_form_stat.checkForm())
        {           
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