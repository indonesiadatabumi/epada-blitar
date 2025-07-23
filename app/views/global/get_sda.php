<?php
	echo "<option value=''></option>";
	foreach($rows as $row){
		echo "<option value='".$row['ref_kompkom_id']."'>".$row['peruntukan']."</option>";		
	}
