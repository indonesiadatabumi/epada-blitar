<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->config->item('sys_name_acr').' '.$system_params[7].' '.$system_params[6];?> | Daftar Kartu Data <?=strtoupper($tax_name);?></title>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('css_path');?>report-style.css"/>
		<style type="text/css">@import "<?=$this->config->item('css_path');?>report-table-style.css";</style>
	</head>
	<body>
		<div style="margin:10px;">

			<h3 align="center"><u>DAFTAR KARTU DATA <?=strtoupper($tax_name);?></u><br />
				<font style="font-weight:normal">TAHUN : <?=$tax_year;?></font>
			</h3><br />
			
			<table class="report" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th rowspan="2">No.</th><th colspan="2">SPTPD</th><th rowspan="2">Wajib Pajak/Pemilik</th>
						<th rowspan="2">Alamat</th><th rowspan="2">NPWPD</th><th rowspan="2">Masa Pajak</th>
						<th rowspan="2">Tarif (%)</th><th rowspan="2">Omzet (Rp.)</th>
						<th rowspan="2">Pajak</th>
					</tr>
					<tr>
						<th>Tanggal</th><th style="border-right:none">No. Urut</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;
						$total1 = 0;
						$total2 = 0;
						foreach($rows as $row){
							$no++;

							$x_date = explode('-',$row['masa_pajak1']);
							$masa_pajak = get_monthName($x_date[1]).' '.$x_date[2];
							$total1 += $row['nilai_terkena_pajak'];
							$total2 += $row['pajak'];

							echo "<tr>
								<td align='center'>".$no."</td>
								<td align='center' align='center'>".$row['tgl_proses']."</td>
								<td align='center'>".$row['nomor_spt']."</td>
								<td>".$row['nama']."</td>
								<td>".$row['alamat']."</td>
								<td align='center'>".$row['npwprd']."</td>
								<td align='center'>".$masa_pajak."</td>
								<td align='right'>".$row['persen_tarif']."</td>
								<td align='right'>".(!empty($row['nilai_terkena_pajak'])?number_format($row['nilai_terkena_pajak']):'')."</td>
								<td align='right'>".(!empty($row['pajak'])?number_format($row['pajak']):'')."</td>
							</tr>";
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="8" align="right"><b>TOTAL : </b></td>
						<td align="right"><b><?=number_format($total1);?></b></td>
						<td align="right"><b><?=number_format($total2);?></b></td>
					</tr>
				</tfoot>
			</table><br /><br />
			<?php
			if($show_signature){
				echo "
				<table border=0 width='100%'>
					<tr>
						<td align='center'>
							Mengetahui<br />";
								if(count($legalitator_row)>0){
									echo $legalitator_row['nama_jabatan']."
									<br /><br /><br /><br /><br />
									<b><u>".$legalitator_row['nama']."</u></b>
									<br />".$legalitator_row['pangkat']."
									<br />NIP. ".$legalitator_row['nip'];
								}							
						echo "</td>
						<td align='center'>
							Diperiksa Oleh<br />";							
								if(count($evaluator_row)>0){
									echo $evaluator_row['nama_jabatan']."
									<br /><br /><br /><br /><br />
									<b><u>".$evaluator_row['nama']."</u></b>
									<br />".$evaluator_row['pangkat']."
									<br />NIP. ".$evaluator_row['nip'];
								}							
						echo "</td>
						<td>
							<br />";
							echo $system_params[6].", ".indo_date_format($print_date,'longDate');
							echo "
							<table>
								<tr><td>Nama</td><td>: ".$this->session->userdata('fullname')."</td></tr>
								<tr><td>Jabatan</td><td>: ".$this->session->userdata('fullname')."</td></tr>
								<tr><td colspan='2'>&nbsp;<br /><br /><br /></td></tr>
								<tr><td>Tanda Tangan</td><td>:</td></tr>
							</table>
						</td>
					</tr>
				</table>";
			}else{
				echo "<div align='right'>".$system_params[6].", ".indo_date_format($print_date,'longDate')."</div>";
			}
			?>
		</div>
	</body>
</html>