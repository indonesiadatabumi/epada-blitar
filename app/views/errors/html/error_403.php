
<div class="alert alert-danger">
	<?php
	$err_msg = "ERROR: Anda tidak memiliki akses untuk ";
	switch ($type) {
		case 'read':
			$err_msg.=" mengakses";
			break;
		case 'add':
			$err_msg.=" menambah";
			break;
		case 'edit':
			$err_msg.=" mengubah";
			break;
		case 'delete':
			$err_msg.=" menghapus";
			break;
		default:
			# code...
			break;
	}
	$err_msg .= " data ini!";
	echo $err_msg;
	?>
</div>