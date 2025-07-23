<?php
	$no = 0;

	foreach($taxpayer_detail_rows as $row){

		$params = array($row['wp_wr_detil_id']);
		$dao->set_sql_params($params);
		$rows2 = $dao->execute(1)->result_array();			

		echo "
		<div class='panel panel-primary'>
			<div class='panel-heading'>".$row['nama_wp']." &raquo; <span class='label label-success'>Pajak</span> : ".$row['nama_pajak'].", <span class='label label-warning'>Kegiatan Usaha</span> : ".$row['nama_kegus']."</div>
			<div class='panel-body'>";
				if(count($rows2)>0){

					foreach($rows2 as $row2){
						$no++;
						echo "
						<div class='thumbnail-custom'>
						<img src='".$this->config->item('upload_path')."tax_objects/".$row2['gambar']."' alt=''/>";
							
							if($delete_priv=='1')
								echo "<button type='button' id='btn-delete3".$no."' class='btn btn-default btn-xs thumbnail-btn' onclick=\"if(confirm('Anda yakin?')){delete_taxobject_image(this.id)}\" title='Delete'>";
							else
								echo "<button type='button' class='btn btn-default btn-xs thumbnail-btn' onclick=\"alert('Anda tidak memiliki akses untuk menghapus data');\" title='Delete'>";
							
								echo "
								<input type='hidden' id='ajax-req-dt' name='id' value='".$row2['wp_wr_gambar_id']."'/>
								<input type='hidden' id='ajax-req-dt' name='filename' value='".$row2['gambar']."'/>
								<input type='hidden' id='ajax-req-dt' name='wp_wr_id' value='".$row2['wp_wr_id']."'/>
								<input type='hidden' id='ajax-req-dt' name='menu' value='".$menu."'/>
								<i class='fa fa-trash-o'></i>
							</a>						
						</div>";
					}
				}else{
					echo "<center><font color='red'>Gambar tidak tersedia</font></center>";
				}
			echo "</div>
		</div>";

	}

?>