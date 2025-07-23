<div class="row">
    <div class="col-md-12">
        <form id="search_form2" action="<?=base_url()."/bundle/taxes/".$bundle_item_type."/".$menu."/load_taxpayer_list";?>" method="POST">
            <input type="hidden" name="menu" value="<?=$menu;?>"/>
            <input type="hidden" name="act" value="<?=$act;?>"/>
            <input type="hidden" name="showed" value="<?=$showed;?>"/>
            <?php
                foreach($src_params as $key=>$val){
                    echo "<input type='hidden' name='src-".$key."' value='".$val."'/>";
                }
                foreach($src_daterange_params as $key=>$val){
                    echo "<input type='hidden' name='src_date_range-".$key."' value='".$val."'>";
                }
            ?>
            <div class="input-group">
                <input class="form-control" type="text" name="src_form-key" id="src_form-key" placeholder="NPWPD atau Nama Wajib Pajak" required/>
                <div class="input-group-btn">
                    <button class="btn btn-default btn-primary" type="submit">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
        <br />
        <div id="loader-list-data2" style="display:none;" align="center">
            <img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
        </div>
        <div id="list-data2">
            <div class="alert alert-warning">
                Silahkan cari Wajib Pajak yang dimaksud dengan memasukkan kata kunci yang diminta pada kotak pencarian di atas!
            </div>
        </div>
    </div>
</div>

<div id="loader-form" style="display:none;" align="center">
    <img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
</div>

<div id="content-form">
</div>

<script type="text/javascript">
    var search_form2_id = 'search_form2';
    var $search_form2 = $('#'+search_form2_id);    
    var search_form2_stat = $search_form2.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

    $search_form2.submit(function(){
        if(search_form2_stat.checkForm())
        {
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

    function load_form2_content(id){
        ajax_object.reset_object();        

        ajax_object.set_url(base_url+'bundle/taxes/'+bundle_item_type+'/'+menu+'/form')
                   .set_id_input(id)
                   .set_input_ajax('ajax-req-dt')
                   .set_data_ajax(data_ajax)
                   .set_loading('#loader-form')
                   .set_content('#content-form')
                   .request_ajax();

    }

</script>
