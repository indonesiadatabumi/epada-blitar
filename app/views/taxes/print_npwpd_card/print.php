<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6];?> | Kartu NPWPD</title>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('css_path');?>report-style.css"/>
		<style type="text/css">@import "<?=$this->config->item('css_path');?>report-table-style.css";</style>
		<style type="text/css">
			.card{
				width:320px;
				float:left;
				margin-right:5px;
				margin-bottom:5px;
				padding:10px;
				border:1px solid #000;
			}
			table.card-content{
				width:100%;
				border:none;
			}
			table.card-content td{
				font-size:0.9em;
			}
		</style>
	</head>
	<body>
		<div style="margin:10px;">
			<?php
			foreach($rows as $row){
				echo "
				<div class='card'>
					<div style='float:left;text-align:center;width:20%'>
						<img src='".$this->config->item('img_path')."logo_pemda.png' style='width:48px;'/>
					</div>
					<div style='text-align:center;padding-bottom:5px;padding-top:5px;float:left;width:78%;border-bottom:1px solid #000'>
						<h5>PEMERINTAH ".strtoupper($system_params[7]." ".$system_params[6])."</h5>
						<h4>".strtoupper($system_params[2])."</h4>
						<h5>KARTU N P W P D</h5>
					</div>
					<div style='clear:both'></div>
					<div style='padding-left:10px'>
						<table class='card-content'>
							<tr><td valign='top'>NAMA</td><td width='1%' valign='top'>:</td><td>".$row['nama']."</td></tr>
							<tr><td valign='top'>ALAMAT</td><td valign='top'>:</td><td>".$row['alamat']."<br />KEC. ".$row['kecamatan']."</td></tr>
							<tr><td valign='top'>NPWPD</td><td valign='top'>:</td><td>".$row['npwprd']."</td></tr>
						</table>
					</div>
					<table border=0 width='100%'>
						<tr>
							<td width='50%'>&nbsp;</td>
							<td align='center'>".$system_params[6]."</td>
						</tr>
					</table>
				</div>";
			}
			?>
		</div>
	</body>
</html>