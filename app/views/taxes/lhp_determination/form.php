<form id="<?=$main_form_id;?>" method="POST" action="<?=base_url()."/bundle/".$bundle_type."/".$bundle_item_type."/".$menu."/submit_form";?>">
    <input type="hidden" name="tahun_pajak" value="<?=$tax_year;?>"/>
    <input type="hidden" name="tgl_penetapan" value="<?=$determination_date;?>"/>
    <input type="hidden" name="menu" value="<?=$menu;?>"/>
    <input type="hidden" name="act" value="<?=$act;?>"/>
    <input type="hidden" name="showed" value="<?=$showed;?>"/>
    <?php
        foreach($src_params as $key=>$val){
            echo "<input type='hidden' name='src-".$key."' value='".$val."'/>";
        }
        foreach($src_daterange_params as $key=>$val){
            echo "<input type='hidden' name='src_date_range-".$key."' value='".$val."'/>";
        }
    ?>

    <div class="row">
        <div class="col-md-6" align="right">
            <?php
                echo count($rows)." LHP ditemukan !";
            ?>
        </div>
        <div class="col-md-6" align="left">
            <button type="submit" class="btn btn-primary">Tetapkan</button>
            <button type="button" class="btn btn-default" id="close-modal-form" data-dismiss="modal">Batal</button>
        </div>
    </div>
    
    <table class="table table-bordered table-striped table-hover" style="margin-top:10px!important">
        <thead>
            <th>#</th>
            <th>NPWPD</th>
            <th>Nama WP</th>            
            <th>Ketetapan</th>
            <th>Pajak</th>
            <th>Tgl. Pemeriksaan</th>
            <th><i class="fa fa-check"</i></th>
        </thead>
        <tbody>
        	<?php
        		$no = 0;
        		foreach($rows as $row){
        			$no++;
        			echo "<tr>
        			<td align='center'>".$no."</td>
        			<td align='center'>".$row['npwprd']."</td>
        			<td>".$row['nama_wp']."</td>        			
        			<td>".$row['keterangan_spt']."</td>
        			<td align='right'>".number_format($row['pajak'])."</td>
        			<td align='center'>".$row['tgl_pemeriksaan']."</td>
        			<td align='center'>
        				<input type='radio' name='index' value='".$no."' checked/>
                        <input type='hidden' name='input-lhp_id".$no."' value='".$row['lhp_id']."'/>
                        <input type='hidden' name='input-jenis_spt_id".$no."' value='".$row['jenis_spt_id']."'/>
                        <input type='hidden' name='input-rekening_id".$no."' value='".$row['rekening_id']."'/>
        			</td>
        			</tr>";
        		}
        	?>
        </tbody>
        <input type="hidden" name="n_lhp" value="<?=$no;?>"/>
    </table>
</form>

<script type="text/javascript">
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