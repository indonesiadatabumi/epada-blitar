<input type="hidden" id="src_params2-pajak_id" value="<?=(isset($src_params['a.golongan'])?$src_params['a.golongan']:'');?>"/>
<input type="hidden" id="src_params2-golongan" value="<?=(isset($src_params['a.pajak_id'])?$src_params['a.pajak_id']:'');?>"/>
<input type="hidden" id="src_params2-status" value="<?=(isset($src_params['a.status'])?$src_params['a.status']:'');?>"/>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <th>No.</th>
        <th>NPWPD</th>
        <th>Pajak/Keg. Usaha</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Kelurahan</th>
        <th>Kecamatan</th>
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
    			<td>".$row['nama_paret']."/".$row['nama_kegus']."</td>
    			<td>".$row['nama']."</td>
    			<td>".$row['alamat']."</td>
    			<td>".$row['kelurahan']."</td>
    			<td>".$row['kecamatan']."</td>
    			<td align='center'>
    				<button type='button' id='btn-open-form".$no."' class='btn btn-default btn-xs' onclick=\"load_form2_content(this.id);\">
    				<input type='hidden' id='ajax-req-dt' name='id' value=''>
    				<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'>
    				<input type='hidden' id='ajax-req-dt' name='act' value='".$act."'>
    				<input type='hidden' id='ajax-req-dt' name='showed' value='".$showed."'>
    				<input type='hidden' id='ajax-req-dt' name='wp_wr_detil_id' value='".$row['wp_wr_detil_id']."'>";
                    foreach($src_params as $key=>$val){
                        echo "<input type='hidden' id='ajax-req-dt' name='src-".$key."' value='".$val."'/>";
                    }
    				echo "<i class='fa fa-check'></i>
    				</button>
    			</td>
    			</tr>";
    		}
    	?>
    </tbody>
</table>