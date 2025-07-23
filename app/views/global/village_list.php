<?php

	echo "<option value=''>".($type=='1'?'- Semua Kelurahan -':'')."</option>";
	foreach($village_rows as $row){
		echo "<option value='".$row['kelurahan_id'].($with_name?"_".$row['nama_kelurahan']:"").($with_code?"_".$row['kode_kelurahan']:"")."'>".$row['nama_kelurahan']."</option>";
	}
?>