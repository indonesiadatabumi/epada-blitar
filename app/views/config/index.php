<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
<input type="hidden" id="bundle_item_type" value="config" />
<input type="hidden" id="showed" value="0" />

<section class="portfolio-showcase-block min-height-maincontent" style="margin-top:50px!important">
	<div class="box">
		<div class="row">
			<div class="col-md-6">
				<h5>
					<i class="fa fa-gears"></i> Pengaturan
				</h5>
			</div>
			<div class="col-md-6">
				<ul class="breadcrumb">
					<li><a href="#">Pengaturan</a></li>
					<li>Rekam Setoran Pajak</li>
				</ul>
			</div>
		</div>
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<ul id="nav-tabs-wrapper" class="nav nav-tabs nav-pills nav-stacked well">
								<li class="active"><a href="#vtab1" data-toggle="tab">User</a></li>
								<li><a href="#vtab2" data-toggle="tab">User Type</a></li>
								<li><a href="#vtab3" data-toggle="tab">Golongan Hotel</a></li>
								<li><a href="#vtab4" data-toggle="tab">Golongan Ruang</a></li>
								<li><a href="#vtab5" data-toggle="tab">Harga AIr Baku</a></li>
								<li><a href="#vtab6" data-toggle="tab">Indeks Kawasan</a></li>
								<li><a href="#vtab7" data-toggle="tab">Indeks Kelas Jalan</a></li>
								<li><a href="#vtab8" data-toggle="tab">Indeks Ketinggian</a></li>
								<li><a href="#vtab9" data-toggle="tab">Indeks Sudut Pandang</a></li>
								<li><a href="#vtab10" data-toggle="tab">Jabatan Pejabat Daerah</a></li>
								<li><a href="#vtab11" data-toggle="tab">Jenis Kamar Hotel</a></li>
								<li><a href="#vtab12" data-toggle="tab">Jenis MBLB</a></li>
								<li><a href="#vtab13" data-toggle="tab">Jenis Pemungutan</a></li>
								<li><a href="#vtab14" data-toggle="tab">Jenis Restoran</a></li>
								<li><a href="#vtab15" data-toggle="tab">Jenis SAT</a></li>
								<li><a href="#vtab16" data-toggle="tab">Kelas Jalan</a></li>
								<li><a href="#vtab17" data-toggle="tab">Komponen Air Tanah</a></li>
								<li><a href="#vtab18" data-toggle="tab">Loket Pembayaran</a></li>
								<li><a href="#vtab19" data-toggle="tab">UPTD</a></li>
								<li><a href="#vtab20" data-toggle="tab">Kegiatan Usaha</a></li>
								<li><a href="#vtab21" data-toggle="tab">Target Pajak</a></li>
								<li><a href="#vtab22" data-toggle="tab">Target WP</a></li>
								<li><a href="#vtab23" data-toggle="tab">Nama Pejabat Daerah</a></li>
							</ul>
						</div>
						<div class="col-sm-9">
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="vtab1">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<button onclick="load_form_user_content()" class='btn btn-success' type='button' id='btn-create-user' data-toggle='modal' data-target='#formModal'>
													<i class='fa fa-create'></i>
													CREATE USER
												</button>
												<table class='table table-bordered table-hover'>
													<thead>
														<tr>
															<th>Username</th>
															<th>Fullname</th>
															<th>Phone</th>
															<th>Email</th>
															<th>NIP</th>
															<th>Created By</th>
															<th>Created At</th>
															<th>Type</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($user_data->result() as $row) { ?>
															<tr>
																<td><?= $row->username ?></td>
																<td><?= $row->fullname ?></td>
																<td><?= $row->phone ?></td>
																<td><?= $row->email ?></td>
																<td><?= $row->nip ?></td>
																<td><?= $row->created_by ?></td>
																<td><?= $row->created_time ?></td>
																<td>
																	<select class="form-select" name="type" id="type" onchange="change_type_id(this, <?= $row->user_id ?>)">
																		<?php foreach ($user_type_data->result() as $rowType) { ?>
																			<option value="<?= $rowType->user_type_id ?>" <?= $row->user_type_id == $rowType->user_type_id ? "selected" : "" ?>><?= $rowType->name ?></option>
																		<?php } ?>
																	</select>
																</td>
																<td>
																	<button class="form-select" name="status-user" id="statys" onclick="change_status_id(<?= ($row->status == 'true' ? 'false' : 'true') ?>, <?= $row->user_id ?>)">
																		<?= $row->status == 'true' ? 'DEACTIVED' : 'ACTIVATE' ?>
																	</button>
																</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab2">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<button class='btn btn-success' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_create_user_type()">
													<i class='fa fa-create'></i>
													CREATE USER TYPE
												</button>
												<ul class="nav nav-tabs" role="tablist">
													<?php foreach ($user_type_data->result() as $row) { ?>
														<li role="presentation">
															<a href="#<?= $row->user_type_id ?>" aria-controls="main" role="tab" data-toggle="tab">
																<?= $row->name ?>
																<button class='btn btn-link' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_user_type(<?= $row->user_type_id ?>)">
																	<i class='fa fa-edit'></i>
																</button>
																<button class='btn btn-link' type='button' id='btn-delete' onclick="delete_user_type(<?= $row->user_type_id ?>)">
																	<i class='fa fa-remove'></i>
																</button>
															</a>
														</li>
													<?php } ?>
												</ul>
												<div class="tab-content">
													<?php foreach ($user_type_data->result() as $row) { ?>
														<div role="tabpanel" class="tab-pane" id="<?= $row->user_type_id ?>">
															<fieldset>
																<div class="row">
																	<div class="col-md-12">
																		<table class='table table-bordered table-hover'>
																			<thead>
																				<tr>
																					<th>Nama Paret</th>
																					<th>Type</th>
																					<th>Status</th>
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php foreach ($bundle_rows->result() as $rowBundle) { ?>
																					<tr>
																						<td><?= $rowBundle->nama_paret ?></td>
																						<td><?= $rowBundle->tipe ?></td>
																						<td><?= $rowBundle->status ?></td>
																						<td>
																							<button onclick="load_form_add_akses_content(<?= $row->user_type_id ?>,<?= $rowBundle->bundel_id ?>)" class='btn btn-primary' type='button' id='btn-update' data-toggle='modal' data-target='#formModal'>
																								<i class='fa fa-plus'></i>
																								Add Privileges
																							</button>
																							<button onclick="load_form_content(<?= $row->user_type_id ?>,<?= $rowBundle->bundel_id ?>)" class='btn btn-success' type='button' id='btn-update' data-toggle='modal' data-target='#formModal'>
																								<i class='fa fa-edit'></i>
																								Update Privileges
																							</button>
																						</td>
																					</tr>
																				<?php } ?>
																			</tbody>
																		</table>
																	</div>
																</div>
															</fieldset>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab3">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_gol_hotel_content()" class='btn btn-sm btn-success' type='button' id='btn-create-gol_hotel' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Golongan Hotel</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($gol_hotel->result() as $row) { ?>
																<tr>
																	<td><?= $row->golongan ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_gol_hotel(<?= $row->ref_kode ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_gol_hotel(<?= $row->ref_kode ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab4">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_gol_ruang_content()" class='btn btn-sm btn-success' type='button' id='btn-create-gol_ruang' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Golongan Ruang</th>
																<th>Pangkat</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($gol_ruang->result() as $row) { ?>
																<tr>
																	<td><?= $row->gol_ruang ?></td>
																	<td><?= $row->pangkat ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_gol_ruang(<?= $row->ref_goru_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_gol_ruang(<?= $row->ref_goru_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab5">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_harga_air_content()" class='btn btn-sm btn-success' type='button' id='btn-create-harga_air' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Deskripsi</th>
																<th>Harga Satuan</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($harga_air->result() as $row) { ?>
																<tr>
																	<td><?= $row->deskripsi ?></td>
																	<td><?= "Rp " . number_format($row->harga_satuan, 2, ",", "."); ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_harga_air(<?= $row->ref_hrgab_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_harga_air(<?= $row->ref_hrgab_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab6">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-8">
													<button onclick="load_form_indeks_kawasan_content()" class='btn btn-sm btn-success' type='button' id='btn-create-indeks_kawasan' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Kawasan</th>
																<th>Skor</th>
																<th>Indeks</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($indeks_kawasan->result() as $row) { ?>
																<tr>
																	<td><?= $row->kawasan ?></td>
																	<td><?= $row->skor; ?></td>
																	<td><?= $row->indeks; ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_indeks_kawasan(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_indeks_kawasan(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab7">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_indeks_kelasjalan_content()" class='btn btn-sm btn-success' type='button' id='btn-create-indeks_kelasjalan' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Kelas Jalan</th>
																<th>Skor</th>
																<th>Indeks</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($indeks_kelasjalan->result() as $row) { ?>
																<tr>
																	<td><?= $row->kelas_jalan ?></td>
																	<td><?= $row->skor; ?></td>
																	<td><?= $row->indeks; ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_indeks_kelasjalan(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_indeks_kelasjalan(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab8">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_indeks_ketinggian_content()" class='btn btn-sm btn-success' type='button' id='btn-create-indeks_ketinggian' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Ketinggian</th>
																<th>Skor</th>
																<th>Indeks</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($indeks_ketinggian->result() as $row) { ?>
																<tr>
																	<td><?= $row->ketinggian ?></td>
																	<td><?= $row->skor; ?></td>
																	<td><?= $row->indeks; ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_indeks_ketinggian(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_indeks_ketinggian(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab9">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_indeks_sudutpandang_content()" class='btn btn-sm btn-success' type='button' id='btn-create-indeks_sudutpandang' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Sudut Pandang</th>
																<th>Skor</th>
																<th>Indeks</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($indeks_sudutpandang->result() as $row) { ?>
																<tr>
																	<td><?= $row->sudut_pandang ?></td>
																	<td><?= $row->skor; ?></td>
																	<td><?= $row->indeks; ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_indeks_sudutpandang(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_indeks_sudutpandang(<?= $row->ref_indeks_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab10">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_jabatan_pejabatdaerah_content()" class='btn btn-sm btn-success' type='button' id='btn-create-jabatan_pejabatdaerah' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Nama Jabatan</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($jabatan_pejabatdaerah->result() as $row) { ?>
																<tr>
																	<td><?= $row->nama_jabatan_id ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_jabatan_pejabatdaerah(<?= $row->ref_japeda_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_jabatan_pejabatdaerah(<?= $row->ref_japeda_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab11">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_jenis_kamarhotel_content()" class='btn btn-sm btn-success' type='button' id='btn-create-jenis_kamarhotel' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis Kamar Hotel</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($jenis_kamarhotel->result() as $row) { ?>
																<tr>
																	<td><?= $row->jenis_martel ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_jenis_kamarhotel(<?= $row->ref_jenmartel_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_jenis_kamarhotel(<?= $row->ref_jenmartel_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab12">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_jenis_mblb_content()" class='btn btn-sm btn-success' type='button' id='btn-create-jenis_mblb' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis MBLB</th>
																<th>Tarif Kubik</th>
																<th>Tarif Ton</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($jenis_mblb->result() as $row) { ?>
																<tr>
																	<td><?= $row->jenis_mblb ?></td>
																	<td><?= $row->tarif_kubik ?></td>
																	<td><?= $row->tarif_ton ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_jenis_mblb(<?= $row->ref_mblb_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_jenis_mblb(<?= $row->ref_mblb_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="vtab13">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_jenis_pemungutan_content()" class='btn btn-sm btn-success' type='button' id='btn-create-jenis_pemungutan' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis Pemungutan</th>
																<th>Jenis SPT</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($jenis_pemungutan->result() as $row) { ?>
																<tr>
																	<td><?= $row->jenis_pemungutan ?></td>
																	<td><?= $row->singkatan ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_jenis_pemungutan(<?= $row->ref_jenput_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_jenis_pemungutan(<?= $row->ref_jenput_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab14">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_jenis_restoran_content()" class='btn btn-sm btn-success' type='button' id='btn-create-jenis_restoran' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis Restoran</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($jenis_restoran->result() as $row) { ?>
																<tr>
																	<td><?= $row->jenis_restoran ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_jenis_restoran(<?= $row->ref_kode ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_jenis_restoran(<?= $row->ref_kode ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab15">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_jenis_sat_content()" class='btn btn-sm btn-success' type='button' id='btn-create-jenis_sat' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis SAT</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($jenis_sat->result() as $row) { ?>
																<tr>
																	<td><?= $row->jenis_sat ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_jenis_sat(<?= $row->ref_jensat_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_jenis_sat(<?= $row->ref_jensat_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab16">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_kelas_jalan_content()" class='btn btn-sm btn-success' type='button' id='btn-create-kelas_jalan' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Kelas Jalan</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($kelas_jalan->result() as $row) { ?>
																<tr>
																	<td><?= $row->kelas_jalan ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_kelas_jalan(<?= $row->ref_kelas_jalan_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_kelas_jalan(<?= $row->ref_kelas_jalan_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab17">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-8">
													<button onclick="load_form_komponen_airtanah_content()" class='btn btn-sm btn-success' type='button' id='btn-create-komponen_airtanah' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Komponen</th>
																<th>Bobot</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($komponen_airtanah->result() as $row) { ?>
																<tr>
																	<td><?= $row->komponen ?></td>
																	<td><?= $row->bobot ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_komponen_airtanah(<?= $row->ref_komponen_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_komponen_airtanah(<?= $row->ref_komponen_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab18">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_loket_pembayaran_content()" class='btn btn-sm btn-success' type='button' id='btn-create-loket_pembayaran' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Loket Pembayaran</th>
																<th>No Rekening</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($loket_pembayaran->result() as $row) { ?>
																<tr>
																	<td><?= $row->loket_pembayaran ?></td>
																	<td><?= $row->no_rekening ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_loket_pembayaran(<?= $row->ref_lokemba_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_loket_pembayaran(<?= $row->ref_lokemba_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab19">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<button onclick="load_form_uptd_content()" class='btn btn-sm btn-success' type='button' id='btn-create-uptd' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Nama UPTD</th>
																<th>Alamat UPTD</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($uptd->result() as $row) { ?>
																<tr>
																	<td><?= $row->nama ?></td>
																	<td><?= $row->uptd_alamat ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_uptd(<?= $row->ref_uptd_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_uptd(<?= $row->ref_uptd_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="vtab20">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col">
													<button onclick="load_form_kegiatan_usaha_content()" class='btn btn-sm btn-success' type='button' id='btn-create-kegiatan_usaha' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis Pajak</th>
																<th>Nama Kegiatan Usaha</th>
																<th>Tarif(%)</th>
																<th>Tarif Dasar</th>
																<th>Tarif Tambahan</th>
																<th>Volume Dasar</th>
																<th>Kode Rekening</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($kegiatan_usaha->result() as $row) { ?>
																<tr>
																	<td><?= $row->nama_paret ?></td>
																	<td><?= $row->nama_kegus ?></td>
																	<td><?= $row->persen_tarif ?></td>
																	<td><?= $row->tarif_dasar ?></td>
																	<td><?= $row->tarif_tambahan ?></td>
																	<td><?= $row->volume_dasar ?></td>
																	<td><?= $row->kode_rekening ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_kegiatan_usaha(<?= $row->ref_kegus_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_kegiatan_usaha(<?= $row->ref_kegus_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div role="tabpanel" class="tab-pane fade in" id="vtab21">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis Pajak</th>
																<th>Target Pajak</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($target_pajak->result() as $row) { ?>
																<tr>
																	<td><?= $row->nama_pajak ?></td>
																	<td><?= number_format($row->target_pajak, 0, '.', ',') ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_target_pajak(<?= $row->id_target ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div role="tabpanel" class="tab-pane fade in" id="vtab22">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-md-6">
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Jenis Pajak</th>
																<th>Target WP</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($target_wp->result() as $row) { ?>
																<tr>
																	<td><?= $row->nama_pajak ?></td>
																	<td><?= $row->target_wp ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_target_wp(<?= $row->id_target ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div role="tabpanel" class="tab-pane fade in" id="vtab23">
									<div class="panel-group">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col">
													<button onclick="load_form_pejabat_daerah_content()" class='btn btn-sm btn-success' type='button' id='btn-create-uptd' data-toggle='modal' data-target='#formModal'>
														CREATE NEW
													</button>
													<table class='table table-bordered table-hover'>
														<thead>
															<tr>
																<th>Nama</th>
																<th>Jabatan</th>
																<th>Golongan</th>
																<th>NIP</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($pejabat_daerah->result() as $row) { ?>
																<tr>
																	<td><?= $row->nama ?></td>
																	<td><?= $row->jabatan ?></td>
																	<td><?= $row->pangkat ?></td>
																	<td><?= $row->nip ?></td>
																	<td>
																		<button class='btn btn-sm btn-info' type='button' id='btn-update' data-toggle='modal' data-target='#formModal' onclick="load_form_update_pejabat_daerah(<?= $row->pejda_id ?>)">
																			<i class='fa fa-edit'></i>
																		</button>
																		<button class='btn btn-sm btn-danger' type='button' id='btn-delete' onclick="delete_pejabat_daerah(<?= $row->pejda_id ?>)">
																			<i class='fa fa-remove'></i>
																		</button>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>



				</div>
			</div>
		</div>

		<div id="loader-list-data" style="display:none;" align="center">
			<img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
		</div>


		<!-- LIST DATA CONTENT -->
		<div id="list-data">
		</div>
		<!-- END OF LIST DATA CONTENT -->


		<!-- MODAL -->
		<div class="modal fade" id="formModal" role="dialog">
			<div class="modal-dialog modal-lg" style="width:1200px!important;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="defModalHead">List Privileges</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12" id="content-formModal">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END OF MODAL -->
	</div>
</section>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	base_url = $('#base_url').val();

	$(document).ready(function() {

		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir").mask('99-99-9999');

		// START AND FINISH DATE
		$("#src-tgl_bayar_awal,#src-tgl_bayar_akhir").datepicker({
			dateFormat: 'dd-mm-yy',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>'
		});

		$(".number").inputmask({
			'alias': 'numeric',
			'mask': '9999999999999999',
			rightAlign: false
		});
	});


	var search_form1_id = 'search_form1';
	var search_form2_id = 'search_form2';
	var $search_form1 = $('#' + search_form1_id);
	var $search_form2 = $('#' + search_form2_id);
	var search_stat1 = $search_form1.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	function checkbox_clicked(id, which) {
		$.ajax({
			url: base_url + "/config/updatePrivileges/" + id + "/" + which + "_priv/" + $("#" + which + "-" + id).is(":checked"),
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
			}
		});
	}

	function change_type_id(val, id) {
		$.ajax({
			url: base_url + "/config/update_user_type/" + id + "/" + val.value,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
			}
		});
	}

	function change_status_id(val, id) {
		$.ajax({
			url: base_url + "/config/update_user_status/" + id + "/" + val,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function delete_user_type(id) {
		$.ajax({
			url: base_url + "/config/delete_type/" + id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}


	function load_form_add_akses_content(idUserType, id) {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_add_akses/' + idUserType + "/" + id)
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_content(idUserType, id) {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form/' + idUserType + "/" + id)
			.set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			.set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_user_type(userTypeId) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_user_types/' + userTypeId)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}


	function load_form_create_user_type() {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_user_types')
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_user_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_user')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_gol_hotel_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_gol_hotel')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_gol_hotel(ref_kode) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_gol_hotel/' + ref_kode)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_gol_hotel(ref_kode) {
		$.ajax({
			url: base_url + "/config/delete_gol_hotel/" + ref_kode,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_gol_ruang_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_gol_ruang')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_gol_ruang(ref_goru_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_gol_ruang/' + ref_goru_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_gol_ruang(ref_goru_id) {
		$.ajax({
			url: base_url + "/config/delete_gol_ruang/" + ref_goru_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_harga_air_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_harga_air')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_harga_air(ref_hrgab_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_harga_air/' + ref_hrgab_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_harga_air(ref_hrgab_id) {
		$.ajax({
			url: base_url + "/config/delete_harga_air/" + ref_hrgab_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_indeks_kawasan_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_kawasan')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_indeks_kawasan(ref_indeks_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_kawasan/' + ref_indeks_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_indeks_kawasan(ref_indeks_id) {
		$.ajax({
			url: base_url + "/config/delete_indeks_kawasan/" + ref_indeks_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_indeks_kelasjalan_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_kelasjalan')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_indeks_kelasjalan(ref_indeks_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_kelasjalan/' + ref_indeks_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_indeks_kelasjalan(ref_indeks_id) {
		$.ajax({
			url: base_url + "/config/delete_indeks_kelasjalan/" + ref_indeks_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_indeks_ketinggian_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_ketinggian')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_indeks_ketinggian(ref_indeks_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_ketinggian/' + ref_indeks_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_indeks_ketinggian(ref_indeks_id) {
		$.ajax({
			url: base_url + "/config/delete_indeks_ketinggian/" + ref_indeks_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_indeks_sudutpandang_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_sudutpandang')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_indeks_sudutpandang(ref_indeks_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_indeks_sudutpandang/' + ref_indeks_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_indeks_sudutpandang(ref_indeks_id) {
		$.ajax({
			url: base_url + "/config/delete_indeks_sudutpandang/" + ref_indeks_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_jabatan_pejabatdaerah_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jabatan_pejabatdaerah')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_jabatan_pejabatdaerah(ref_japeda_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jabatan_pejabatdaerah/' + ref_japeda_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_jabatan_pejabatdaerah(ref_japeda_id) {
		$.ajax({
			url: base_url + "/config/delete_jabatan_pejabatdaerah/" + ref_japeda_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_jenis_kamarhotel_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_kamarhotel')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_jenis_kamarhotel(ref_jenmartel_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_kamarhotel/' + ref_jenmartel_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_jenis_kamarhotel(ref_jenmartel_id) {
		$.ajax({
			url: base_url + "/config/delete_jenis_kamarhotel/" + ref_jenmartel_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_jenis_mblb_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_mblb')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_jenis_mblb(ref_mblb_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_mblb/' + ref_mblb_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_jenis_mblb(ref_mblb_id) {
		$.ajax({
			url: base_url + "/config/delete_jenis_mblb/" + ref_mblb_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_jenis_pemungutan_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_pemungutan')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_jenis_pemungutan(ref_jenput_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_pemungutan/' + ref_jenput_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_jenis_pemungutan(ref_jenput_id) {
		$.ajax({
			url: base_url + "/config/delete_jenis_pemungutan/" + ref_jenput_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_jenis_restoran_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_restoran')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_jenis_restoran(ref_kode) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_restoran/' + ref_kode)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_jenis_restoran(ref_kode) {
		$.ajax({
			url: base_url + "/config/delete_jenis_restoran/" + ref_kode,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_jenis_sat_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_sat')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_jenis_sat(ref_jensat_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_jenis_sat/' + ref_jensat_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_jenis_sat(ref_jensat_id) {
		$.ajax({
			url: base_url + "/config/delete_jenis_sat/" + ref_jensat_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_kelas_jalan_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_kelas_jalan')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_kelas_jalan(ref_kelas_jalan_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_kelas_jalan/' + ref_kelas_jalan_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_kelas_jalan(ref_kelas_jalan_id) {
		$.ajax({
			url: base_url + "/config/delete_kelas_jalan/" + ref_kelas_jalan_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_komponen_airtanah_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_komponen_airtanah')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_komponen_airtanah(ref_komponen_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_komponen_airtanah/' + ref_komponen_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_komponen_airtanah(ref_komponen_id) {
		$.ajax({
			url: base_url + "/config/delete_komponen_airtanah/" + ref_komponen_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_loket_pembayaran_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_loket_pembayaran')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_loket_pembayaran(ref_lokemba_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_loket_pembayaran/' + ref_lokemba_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_loket_pembayaran(ref_lokemba_id) {
		$.ajax({
			url: base_url + "/config/delete_loket_pembayaran/" + ref_lokemba_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_uptd_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_uptd')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_uptd(ref_uptd_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_uptd/' + ref_uptd_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_uptd(ref_uptd_id) {
		$.ajax({
			url: base_url + "/config/delete_uptd/" + ref_uptd_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_kegiatan_usaha_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_kegiatan_usaha')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_kegiatan_usaha(ref_kegus_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_kegiatan_usaha/' + ref_kegus_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_kegiatan_usaha(ref_kegus_id) {
		$.ajax({
			url: base_url + "/config/delete_kegiatan_usaha/" + ref_kegus_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	function load_form_update_target_pajak(id_target) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_target_pajak/' + id_target)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_target_wp(id_target) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_target_wp/' + id_target)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_pejabat_daerah_content() {
		ajax_object.reset_object();

		showed = $('#showed').val();

		data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_pejabat_daerah')
			//    .set_id_input(id)
			.set_input_ajax('ajax-req-dt')
			//    .set_data_ajax(data_ajax)
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function load_form_update_pejabat_daerah(ref_kegus_id) {
		ajax_object.reset_object();

		showed = $("#showed").val();

		$data_ajax = ['showed=' + showed];

		ajax_object.set_url(base_url + '/config/form_pejabat_daerah/' + ref_kegus_id)
			.set_input_ajax('ajax-req-dt')
			.set_loading('#loader-formModal')
			.set_content('#content-formModal')
			.request_ajax();
	}

	function delete_pejabat_daerah(ref_kegus_id) {
		$.ajax({
			url: base_url + "/config/delete_pejabat_daerah/" + ref_kegus_id,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(result) {
				console.log(result);
				window.location.reload();
			}
		});
	}

	var search_stat2 = $search_form1.validate({
		// Do not change code below
		errorPlacement: function(error, element) {
			error.addClass('error');
			error.insertAfter(element.parent());
		}
	});

	$search_form1.submit(function() {
		if (search_stat1.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_content('#content-billing_data')
				.set_loading('#loader-billing_data')
				.disable_pnotify()
				.set_form($search_form1)
				.submit_ajax('');
			return false;
		}
	});

	$search_form2.submit(function() {
		if (search_stat1.checkForm()) {
			ajax_object.reset_object();
			ajax_object.set_plugin_datatable(true)
				.set_content('#list-data')
				.set_loading('#loader-list-data')
				.disable_pnotify()
				.set_form($search_form2)
				.submit_ajax('');
			return false;
		}
	});
</script>