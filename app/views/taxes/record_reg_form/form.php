<form id="<?=$main_form_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/submit_form";?>" class="form-horizontal">
    <input type="hidden" name="act" id="act" value="<?=$act;?>"/>
    <input type="hidden" name="id_value" value="<?=$id_value;?>"/>    
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
            echo "<input type='hidden' name='src-".$key."' value='".$val."'/>";
        }
    ?>

    <fieldset>
        <div class="row">
            <div class="col-md-12">
                
                <div class="form-group">
                    <label class="control-label col-md-3"><b>Jenis Pajak</b></label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" value="<?=$bundle_name;?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3"><b>Kegiatan Usaha</b> <?=($act=='add'?"<font color='red'>*</font>":"");?></label>
                    <div class="col-md-9">
                        <div class="input state-disabled">
                            <select name="input-kegus_id" id="input-kegus_id" class="form-control" <?=($act=='add'?"required":"disabled");?>>
                                <option value="" selected></option>
                                <?php
                                    foreach($business_type_rows as $row){
                                        $selected = ($row['ref_kegus_id']==$curr_data['kegus_id']?'selected':'');
                                        echo "<option value='".$row['ref_kegus_id']."_".$row['kode_kegus']."' ".$selected.">".$row['nama_kegus']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Nama <font color="red">*</font></label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" name="input-nama" id="input-nama" value="<?=$curr_data['nama'];?>" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Alamat <font color="red">*</font></label>
                    <div class="col-md-9">
                        <div class="input">
                            <textarea class="form-control" name="input-alamat" id="input-alamat" rows="2" required><?=$curr_data['alamat'];?></textarea>
                        </div>
                        <div class="note">
                            Jalan/No. RT/RW/RK
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Kecamatan <font color="red">*</font></label>
                    <div class="col-md-9">
                        <div class="input state-disabled">
                            <select name="input-kecamatan" id="input-kecamatan" class="form-control" onchange="get_villages(this.value,'input-kelurahan','loader_input_kelurahan','2')" required>
                                <option value="" selected></option>
                                <?php
                                    foreach($district_rows as $row){
                                        $selected = ($row['kecamatan_id']==$curr_data['kecamatan_id']?'selected':'');
                                        echo "<option value='".$row['kecamatan_id']."_".$row['nama_kecamatan']."_".$row['kode_kecamatan']."' ".$selected.">".$row['nama_kecamatan']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Kelurahan <font color="red">*</font></label>
                    <div class="col-md-9">
                        <div class="input state-disabled">
                            <div id="loader_input_kelurahan" style="display:none">
                                <img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
                            </div>                                                      
                            <select class="form-control" name="input-kelurahan" id="input-kelurahan" required>
                                <option value="" selected>- Silahkan pilih Kecamatan lebih dulu -</option>
                                <?php
                                    if($act=='edit'){
                                        foreach($village_rows as $row){
                                            $selected = ($row['kelurahan_id']==$curr_data['kelurahan_id']?'selected':'');
                                            echo "<option value='".$row['kelurahan_id']."_".$row['nama_kelurahan']."_".$row['kode_kelurahan']."' ".$selected.">".$row['nama_kelurahan']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Kabupaten</label>
                    <div class="col-md-9">
                        <div class="input">
                            <input class="form-control" name="input-kabupaten" id="input-kabupaten" value="<?=$system_params[6];?>" readonly/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Status</label>
                    <div class="col-md-3">
                        <div class="input state-disabled">
                            <select class="form-control" name="input-status" id="input-status" required>
                                <option value=""></option>
                                <?php
                                    $opts = array("Dikirim","Kembali","Tidak kembali");
                                    foreach($opts as $key=>$val){
                                        $selected = ($curr_data['status']==$key?'selected':'');
                                        echo "<option value='".$key."' ".$selected.">".$val."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl. Kirim <font color="red">*</font></label>
                    <div class="col-md-4">
                        <div class="input">
                            <input class="form-control datepicker" name="input-tgl_kirim-date" id="input-tgl_kirim" value="<?=indo_date_format($curr_data['tgl_kirim'],'shortDate');?>" required/>
                        </div>                      
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl. Kembali <font color="red">*</font></label>
                    <div class="col-md-4">
                        <div class="input">
                            <input class="form-control datepicker" name="input-tgl_kembali-date" id="input-tgl_kembali" value="<?=indo_date_format($curr_data['tgl_kembali'],'shortDate');?>" required/>
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