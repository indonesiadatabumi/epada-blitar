<?php
	echo "<option value=''></option>";
	foreach($rows as $row){
		echo "<option value='".$row['ref_kompsda_id']."'>".$row['kriteria']."</option>";		
	}
?>