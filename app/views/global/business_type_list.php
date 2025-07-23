<?php

	echo "<option value=''>".($type=='1'?'- Semua Kelurahan -':'')."</option>";
	foreach($business_type_rows as $row){
		echo "<option value='".$row['ref_kegus_id']."'>".$row['nama_kegus']."</option>";
	}
?>