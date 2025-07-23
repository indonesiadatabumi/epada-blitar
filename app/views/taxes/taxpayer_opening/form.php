<form id="<?=$main_form_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/submit_form";?>" class="form-horizontal">
    <input type="hidden" name="act" id="act" value="<?=$act;?>"/>
    <input type="hidden" name="id_value" value="<?=$id_value;?>"/>
    <input type="hidden" name="wp_wr_detil_id" value="<?=$wp_wr_detil_id;?>"/>
    <input type="hidden" name="menu" value="<?=$menu;?>"/>    
    
    <?php
    echo "
    <input type='hidden' name='input-".($act=='add'?'created':'modified')."_by' value='".$this->session->userdata('username')."'/>
    <input type='hidden' name='input-".($act=='add'?'created':'modified')."_time' value='".date('Y-m-d H:i:s')."'/>";
    if($act=='add'){
        echo "<input type='hidden' name='input-modified_time' value='".date('Y-m-d H:i:s')."'/>";
    }
    ?>

    <input type="hidden" name="showed" value="<?=$showed;?>"/>

    <?php
        foreach($src_params as $key=>$val){
            echo "<input type='hiddens' name='src-".$key."' value='".$val."'/>";
        }
    ?>

    <fieldset>
        <div class="row">
            <div class="col-md-12">
                
                <div class="form-group">
                    <label class="control-label col-md-3"><b>Jenis Pajak</b></label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['nama_paret'];?>" readonly/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3"><b>Kegiatan Usaha</b></label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['nama_kegus'];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">NPWPD</label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['npwprd'];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nama WP</label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['nama'];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['kelurahan'];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Kelurahan</label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['kelurahan'];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Kecamatan</label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$taxpayer_detail_row['kecamatan'];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">No./Tgl. Berita Acara <font color="red">*</font></label>
                    <div class="col-md-3">
                        <div class="input">
                            <input class="form-control" name="input-no_berita_acara" id="input-no_berita_acara" value="<?=$curr_data['no_berita_acara'];?>" required/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input">
                            <input class="form-control datepicker" name="input-tgl_berita_acara-date" id="input-tgl_berita_acara" value="<?=indo_date_format($curr_data['tgl_berita_acara'],'shortDate');?>" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Isi Berita Acara</label>
                    <div class="col-md-9">
                        <div class="input">
                            <textarea class="form-control" name="input-isi_berita_acara" id="input-isi_berita_acara" rows="2" required><?=$curr_data['isi_berita_acara'];?></textarea>
                        </div>
                    </div>
                </div>
                

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl. Buka <font color="red">*</font></label>
                    <div class="col-md-3">
                        <div class="input">
                            <input class="form-control datepicker" name="input-tgl_buka-date" id="input-tgl_buka" value="<?=indo_date_format($curr_data['tgl_buka'],'shortDate');?>" required/>
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

<script src="<?=$this->config->item('js_path');?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        $("#input-tgl_berita_acara,#input-tgl_buka").mask('99-99-9999');     

        // START AND FINISH DATE
        $('#input-tgl_berita_acara,#input-tgl_buka').datepicker({
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