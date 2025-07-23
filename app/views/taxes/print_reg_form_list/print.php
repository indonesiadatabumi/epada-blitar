<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6];?> | Daftar Formulir Pendaftaran</title>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('css_path');?>report-style.css"/>
		<style type="text/css">@import "<?=$this->config->item('css_path');?>report-table-style.css";</style>
	</head>
	<body>
		<div style="margin:10px;">
			<h3 align="center"><u>DAFTAR FORMULIR PENDAFTARAN</u><br />
				<font style="font-weight:normal"><?=$tax_name;?></font>
			</h3><br />
			<table class="report" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>No.</th><th>No. Formulir</th><th>Nama</th><th>Keg. Usaha</th>
						<th>Alamat Lengkap</th><th>Tgl. Dikirim</th><th>Tgl. Kembali</th><th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;
						foreach($rows as $row){
							$no++;
							echo "<tr>
								<td align='center'>".$no."</td>
								<td>".$row['no_form']."</td>
								<td>".$row['nama']."</td>
								<td>".$row['nama_kegus']."</td>
								<td>".$row['alamat']."</td>
								<td align='center'>".$row['tgl_dikirim']."</td>
								<td align='center'>".$row['tgl_kembali']."</td>
								<td></td>
							</tr>";
						}
					?>
				</tbody>
			</table><br /><br />
			<table border=0 width="100%">
				<tr>
					<td align="center">
						Mengetahui<br />
						<?php
							if(count($legalitator_row)>0){
								echo $legalitator_row['nama_jabatan']."
								<br /><br /><br /><br /><br />
								<b><u>".$legalitator_row['nama']."</u></b>
								<br />".$legalitator_row['pangkat']."
								<br />NIP. ".$legalitator_row['nip'];
							}
						?>
					</td>
					<td align="center">
						Diperiksa Oleh<br />
						<?php
							if(count($evaluator_row)>0){
								echo $evaluator_row['nama_jabatan']."
								<br /><br /><br /><br /><br />
								<b><u>".$evaluator_row['nama']."</u></b>
								<br />".$evaluator_row['pangkat']."
								<br />NIP. ".$evaluator_row['nip'];
							}
						?>
					</td>
					<td>
						<br />
						Tanggal dibuat : <?=indo_date_format($print_date,'longDate');?>
						<br />
						Nama : <?=$this->session->userdata('fullname');?>
						<br /><br />
						Tanda Tangan : 
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>