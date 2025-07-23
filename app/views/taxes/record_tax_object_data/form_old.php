<form id="<?= $main_form_id; ?>" method="POST" action="<?= base_url() . "/bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/submit_form"; ?>" class="form-horizontal">
    <input type="hidden" name="act" id="act" value="<?= $act; ?>" />
    <!-- <input type="hidden" name="act" id="act" value="<?= base_url() . "/bundle/" . $bundle_type . "/" . $bundle_item_type . "/" . $menu . "/submit_form"; ?>" /> -->
    <input type="hidden" name="id_value" value="<?= $id_value; ?>" />
    <input type="hidden" name="wp_wr_detil_id" id="wp_wr_detil_id" value="<?= $wp_wr_detil_id; ?>" />
    <input type="hidden" name="persen_tarif" id="persen_tarif" value="<?= $tax_percentage; ?>" />
    <input type="hidden" name="menu" id="menu" value="<?= $menu; ?>" />
    <input type="hidden" name="pajak_id" id="pajak_id" value="<?= $bundle_id; ?>" />

    <?php
    if ($taxpayer_info_available) {
        echo "
        <input type='hidden' name='kode_pajak' value='" . $taxpayer_detail_row['kode_pajak'] . "'/>
        <input type='hidden' name='jenis_spt_id' value='" . $taxpayer_detail_row['jenis_spt_id'] . "'/>
        <input type='hidden' name='kegus_id' value='" . $taxpayer_detail_row['kegus_id'] . "'/>
        <input type='hidden' name='kode_kegus' value='" . $taxpayer_detail_row['kegus_id'] . "'/>";
    } else {
        echo "
        <input type='hidden' name='kode_pajak' value='" . $tax_code . "'/>
        <input type='hidden' name='jenis_spt_id' value='" . $spt_type_id . "'/>
        <input type='hidden' name='kegus_id' value='" . $business_id . "'/>
        <input type='hidden' name='kode_kegus' value='" . $business_code . "'/>";
    }
    ?>

    <input type="hidden" id="base_url" value="<?= base_url(); ?>" />
    <input type="hidden" id="img_path" value="<?= $this->config->item('img_path');; ?>" />

    <?php

    echo "
    <input type='hidden' name='input-" . ($act == 'add' ? 'created' : 'modified') . "_by' value='" . $this->session->userdata('username') . "'/>
    <input type='hidden' name='input-" . ($act == 'add' ? 'created' : 'modified') . "_time' value='" . date('Y-m-d H:i:s') . "'/>";

    if ($act == 'add') {
        echo "
        <input type='hidden' name='input-modified_time' value='" . date('Y-m-d H:i:s') . "'/>
        <input type='hidden' name='input-wp_wr_id' value='" . ($taxpayer_info_available ? $taxpayer_detail_row['wp_wr_id'] : '0') . "'/>
        <input type='hidden' name='input-jenis_pemungutan_id' value='" . ($taxpayer_info_available ? $taxpayer_detail_row['jenput_id'] : $collection_type_id) . "'/>";
    }
    ?>

    <input type="hidden" name="showed" value="<?= $showed; ?>" />

    <?php
    foreach ($src_params as $key => $val) {
        echo "<input type='hidden' name='src-" . $key . "' value='" . $val . "'/>";
    }
    foreach ($src_daterange_params as $key => $val) {
        echo "<input type='hidden' name='src_date_range-" . $key . "' value='" . $val . "'/>";
    }
    ?>

    <fieldset>
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-info"></i> Profil Wajib Pajak
                    </div>
                    <div class="panel-body">

                        <?php
                        if ($taxpayer_info_available) {
                            echo "
                            <div class='form-group'>
                                <label class='control-label col-md-3'>NPWPD</label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' name='input-npwprd' value='" . $taxpayer_detail_row['npwprd'] . "' readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Jenis Pajak</label>                            
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $taxpayer_detail_row['kode_pajak'] . ' - ' . $taxpayer_detail_row['nama_pajak'] . "' readonly/>                                        
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Kegiatan Usaha</label>                            
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $taxpayer_detail_row['kode_kegus'] . ' - ' . $taxpayer_detail_row['nama_kegus'] . "' readonly/>                                        
                                    </div>
                                </div>
                            </div>                

                            <div class='form-group'>
                                <label class='control-label col-md-3'>Nama WP</label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $taxpayer_detail_row['nama_wp'] . "' readonly/>                                        
                                    </div>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class='control-label col-md-3'>Alamat</label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $taxpayer_detail_row['kelurahan'] . "' readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class='control-label col-md-3'>Kelurahan</label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $taxpayer_detail_row['kelurahan'] . "' readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class='control-label col-md-3'>Kecamatan</label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $taxpayer_detail_row['kecamatan'] . "' readonly/>
                                    </div>
                                </div>
                            </div>";
                        } else {
                            echo "                            
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Jenis Pajak</label>                            
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $tax_code . ' - ' . $bundle_name . "' readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Kegiatan Usaha</label>                            
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' value='" . $business_code . ' - ' . $business_name . "' readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Nama WP <font color='red'>*</font></label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' name='input3-nama' id='input3-nama' value='" . $curr_data4['nama'] . "' required/>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class='control-label col-md-3'>Alamat <font color='red'>*</font></label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <textarea class='form-control' name='input3-alamat' id='input3-alamat' rows='3' required>" . $curr_data4['alamat'] . "</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>No. Telepon <font color='red'>*</font></label>
                                <div class='col-md-9'>
                                    <div class='input'>
                                        <input class='form-control' name='input3-no_telepon' id='input3-no_telepon' value='" . $curr_data4['no_telepon'] . "' required/>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Kecamatan <font color='red'>*</font></label>
                                <div class='col-md-9'>
                                    <div class='input state-disabled'>                                        
                                        <select class='form-control' name='input3-kecamatan' id='input3-kecamatan' onchange=\"get_villages(this.value,'input3-kelurahan','loader-input3_kelurahan','2')\" required>
                                            <option value=''></option>";
                            foreach ($district_rows as $row) {
                                $selected = ($curr_data4['kecamatan_id'] == $row['kecamatan_id'] ? 'selected' : '');
                                echo "<option value='" . $row['kecamatan_id'] . "_" . $row['nama_kecamatan'] . "_" . $row['kode_kecamatan'] . "' " . $selected . ">" . $row['nama_kecamatan'] . "</option>";
                            }
                            echo "</select>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='control-label col-md-3'>Kelurahan <font color='red'>*</font></label>
                                <div class='col-md-9'>
                                    <div class='input state-disabled'>
                                        <div id='loader-input3_kelurahan' style='display:none'>
                                            <img src='" . $this->config->item('img_path') . "ajax-loaders/ajax-loader-1.gif'/>
                                        </div>

                                        <select class='form-control' name='input3-kelurahan' id='input3-kelurahan' required>";
                            if ($act == 'edit') {
                                foreach ($village_rows as $row) {
                                    $selected = ($curr_data4['kelurahan_id'] == $row['kelurahan_id'] ? 'selected' : '');
                                    echo "<option value='" . $row['kecamatan_id'] . "_" . $row['nama_kelurahan'] . "_" . $row['kode_kelurahan'] . "' " . $selected . ">" . $row['nama_kelurahan'] . "</option>";
                                }
                            }
                            echo "</select>
                                    </div>
                                </div>
                            </div>";
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php
                        if ($bundle_id == '3') {
                            echo "<i class='fa fa-pencil'></i> Atribut Objek Pajak</i>";
                        } else {
                            echo "<i class='fa fa-money'></i> Objek Pajak";
                        }
                        ?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Sistem Pemungutan</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" value="<?= ($taxpayer_info_available ? $taxpayer_detail_row['jenis_pemungutan'] : $collection_type); ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Periode SPT</label>
                            <div class="col-md-9">
                                <div class="input">
                                    <input class="form-control" name="tahun_pajak" value="<?= ($act == 'add' ? $tax_year : $curr_data['tahun_pajak']); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Masa Pajak <font color="red">*</font></label>
                            <div class='col-md-3'>
                                <div class='input state-disabled'>
                                    <select class="form-control" id="bulan_pajak" onchange="fill_tax_period(this.value)">
                                        <option value=''></option>
                                        <?php
                                        if ($act == 'add') {
                                            $curr_month = date('m');
                                            for ($i = 1; $i <= 12; $i++) {
                                                $selected = ($i == $curr_month ? 'selected' : '');
                                                echo "<option value='" . $i . "' " . $selected . ">" . get_monthName($i) . "</option>";
                                            }
                                        } else {
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo "<option value='" . $i . "'>" . get_monthName($i) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input">
                                    <input class="form-control datepicker1" name="input-masa_pajak1" id="input-masa_pajak1" value="<?= ($act == 'edit' ? indo_date_format($curr_data['masa_pajak1'], 'shortDate') : $curr_start_date); ?>" required />
                                </div>
                                <div class="note">
                                    masa pajak awal
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input">
                                    <input class="form-control datepicker1" name="input-masa_pajak2" id="input-masa_pajak2" value="<?= ($act == 'edit' ? indo_date_format($curr_data['masa_pajak2'], 'shortDate') : $curr_last_date); ?>" required />
                                </div>
                                <div class="note">
                                    masa pajak akhir
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Tgl. Proses <font color="red">*</font></label>
                            <div class="col-md-4">
                                <div class="input">
                                    <input class="form-control datepicker2" name="input-tgl_proses-date" id="input-tgl_proses" value="<?= ($act == 'edit' ? indo_date_format($curr_data['tgl_proses'], 'shortDate') : date('d-m-Y')); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Metode Transaksi <font color="red">*</font></label>
                            <div class="col-md-4">
                                <div class="input state-disabled">
                                    <select name="input-metod_trans_id" id="input-metod_trans_id" class="form-control" <?= ($act == 'add' ? "required" : ""); ?>>
                                        <option value="" selected></option>
                                        <?php
                                        foreach ($metode_transaksi_result as $row) {
                                            $selected = ($row['metod_trans_id'] == $curr_data['metod_trans_id'] ? 'selected' : '');
                                            echo "<option value='" . $row['metod_trans_id'] . "' " . $selected . ">" . $row['metode_transaksi'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kompensasi</label>
                            <div class="col-md-4">
                                <div class="input">
                                    <input class="form-control" name="input-kompensasi" id="input-kompensasi" value="<?= ($act == 'edit' ? $curr_data['kompensasi'] : '0'); ?>" style="text-align: right;" />
                                </div>
                            </div>
                        </div>
                        <?php
                        $dtl_type1_arr = array(1, 2, 5, 7, 11);
                        $dtl_type2_arr = array(4, 6);

                        if (in_array($bundle_id, $dtl_type1_arr)) {
                            if ($bundle_id == 5) {
                                echo "<div class='form-group'>
                                        <label class='control-label col-md-3'>Penggunaan Daya (kwh) <font color='red'>*</font></label>
                                        <div class='col-md-6'>
                                            <input type='text' class='form-control thousand_format' id='input2-penggunaan_daya' name='input2-penggunaan_daya' onkeyup=\"assess_tax4()\" value='" . $curr_data3['penggunaan_daya'] . "' required/>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='input'>
                                                <input type='text' class='form-control thousand_format' id='input2-tarif_dasar' name='input2-tarif_dasar' value='" . $taxpayer_detail_row['tarif_dasar'] . "' readonly/>
                                            </div>
                                            <div class='note'>
                                                tarif dasar
                                            </div>
                                        </div>
                                    </div>";
                            } else if ($bundle_id == 7) {
                                // echo "
                                //     <div class='form-group'>
                                //         <label class='control-label col-md-3'>Jenis Air/Harga Satuan</label>
                                //         <div class='col-md-4'>
                                //             <div class='input'>
                                //                 <input class='form-control' value='" . $groundwater_wp_row['jenis_air'] . "' readonly/>
                                //             </div>
                                //         </div>
                                //         <div class='col-md-5'>
                                //             <div class='input'>
                                //                 <input class='form-control thousand_format' id='input2-harga_satuan' value='" . $groundwater_wp_row['harga_satuan'] . "' readonly/>
                                //             </div>
                                //         </div>
                                //     </div>
                                //     <div class='form-group'>
                                //         <div class='col-md-3'>&nbsp;</div>
                                //         <div class='col-md-9'>
                                //             <table class='table table-bordered'>
                                //                 <thead>
                                //                     <tr>
                                //                         <th>Jenis Komponen</th>
                                //                         <th>%</th>
                                //                         <th>Bobot</th>
                                //                         <th>Nilai</th>
                                //                     </tr>
                                //                 </thead>
                                //                 <tbody>                                                    
                                //                     <tr><td>Komponen SDA</td>
                                //                         <td align='right'><input type='text' class='form-control number' id='input2-persen_komponen_sda' value='" . $groundwater_components[0] . "' readonly/></td>
                                //                         <td align='right'><input type='text' class='form-control number' id='input2-bobot_komponen_sda' value='" . $groundwater_wp_row['bobot_sda'] . "' readonly/></td>
                                //                         <td align='right'><input type='text' class='form-control number_input' id='input2-nilai_komponen_sda' value='" . number_format($naturalresources_component_value, 2, '.', ',') . "' readonly/></td>
                                //                     </tr>
                                //                     <tr>
                                //                         <td>Komponen Kompensasi Pemulihan</td>
                                //                         <td align='right'><input type='text' class='form-control number' id='input2-persen_komponen_kompensasi' value='" . $groundwater_components[1] . "' readonly/></td>
                                //                         <td style='background:#eaeaea' colspan='2'></td></tr>
                                //                 </tbody>
                                //             </table>
                                //         </div>
                                //     </div>

                                //     <div class='form-group'>
                                //         <label class='control-label col-md-3'>Volume <font color='red'>*</font></label>
                                //         <div class='col-md-6'>
                                //             <div class='input'>
                                //                 <input class='form-control thousand_format' name='input2-volume' 
                                //                     id='input2-volume' value='" . ($act == 'edit' ? number_format($curr_data2['volume']) : '') . "' 
                                //                     onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                //             </div>
                                //             <div class='note'>Volume (m<sup>3</sup>)</div>
                                //         </div>";
                                echo "
                                    <table class='table' width='100%'>
                                        <thead>
                                            <tr align='center'>
                                                <td><b>Petunjuk Meter Air</b></td>
                                                <td><b>Bukan Meter Air</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Hari Ini
                                                     <input class='form-control' name='input2-ptnjk_meter_hari_ini' 
                                                    id='input2-ptnjk_meter_hari_ini' value='" . ($act == 'edit' ? $curr_data2['ptnjk_meter_hari_ini'] : '0') . "' 
                                                    onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                                </td>
                                                <td>Penggunaan 1 hari
                                                     <input class='form-control thousand_format' name='input2-bkn_meter_hari' 
                                                    id='input2-bkn_meter_hari' value='" . ($act == 'edit' ? $curr_data2['bkn_meter_hari'] : '0') . "' 
                                                    onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bulan Lalu
                                                     <input class='form-control' name='input2-ptnjk_meter_bulan_lalu' 
                                                    id='input2-ptnjk_meter_bulan_lalu' value='" . ($act == 'edit' ? $curr_data2['ptnjk_meter_bulan_lalu'] : '0') . "' 
                                                    onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                                </td>
                                                <td>Penggunaan 1 bulan
                                                     <input class='form-control thousand_format' name='input2-bkn_meter_bulan' 
                                                    id='input2-bkn_meter_bulan' value='" . ($act == 'edit' ? $curr_data2['bkn_meter_bulan'] : '0') . "' 
                                                    onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>";
                                echo "
                                    <div class='form-group'>
                                        <label class='control-label col-md-3'>Volume Air <font color='red'>*</font></label>
                                        <div class='col-md-6'>
                                            <div class='input'>
                                                <input class='form-control thousand_format' name='input2-volume' 
                                                    id='input2-volume' value='" . ($act == 'edit' ? number_format($curr_data2['volume']) : '') . "' 
                                                    onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                            </div>
                                            <div class='note'>Volume (m<sup>3</sup>)</div>
                                        </div>";
                                echo "</div>
                                    <div class='form-group'>
                                        <label class='control-label col-md-3'>Harga Satuan <font color='red'>*</font></label>
                                        <div class='col-md-6'>
                                            <div class='input'>
                                                <input class='form-control thousand_format' name='input2-tarif_dasar' 
                                                    id='input2-tarif_dasar' value='" . ($act == 'edit' ? number_format($curr_data2['tarif_dasar']) : '') . "' 
                                                    onkeyup=\"assess_tax2();\" style='text-align:right'/>
                                            </div>
                                        </div>";
                                // echo "</div>

                                //     <div class='form-group'>
                                //         <div class='col-md-3'>&nbsp;</div>
                                //         <div class='col-md-9'>
                                //             <table class='table table-bordered'>

                                //                 <thead>
                                //                     <tr>
                                //                     <th colspan='5'>Komponen Pemulihan</th>
                                //                     </tr>
                                //                     <tr>
                                //                         <th>Volume (m<sup>3</sup>)</th><th>Bobot</th><th>Nilai</th>
                                //                     </tr>
                                //                 </thead>
                                //                 <tbody id='tbody-groundwater_assessment'>";
                                // // if ($act == 'edit') {
                                // //     foreach ($compensation_component_rows as $row) {
                                // //         echo "<tr>
                                // //                         <td>" . $row['volume'] . "</td>
                                // //                         <td align='right'>" . $row['weight'] . "</td>
                                // //                         <td align='right'>" . $row['nkp'] . "</td>
                                // //                         <td align='right'>" . $row['npa'] . "</td>
                                // //                         </tr>";
                                // //     }
                                // // }
                                // if ($act == 'edit') {
                                //     foreach ($compensation_component_rows as $row) {
                                //         echo "<tr>
                                //                         <td>" . $row['volume'] . "</td>
                                //                         <td align='right'>" . $row['weight'] . "</td>
                                //                         <td align='right'>" . $row['npa'] . "</td>
                                //                         </tr>";
                                //     }
                                // }
                                // echo "</div>
                                //                 <tfoot width='100px'>
                                //                     <tr>
                                //                         <td align='right'>Total NPA</td>
                                //                         <td><input type='text' id='input2-total_npa' class='form-control thousand_format' value='" . ($act == 'edit' ? number_format($curr_data2['nilai_terkena_pajak']) : '') . "' readonly/></td>
                                //                     </tr>
                                //                 </tfoot>
                                //             </table>
                                //         </div>
                                //     </div>";
                                echo "</div>
                                    <div class='form-group'>
                                        <label class='control-label col-md-3'>Total NPA</font></label>
                                        <div class='col-md-6'>
                                            <div class='input'>
                                            <input type='text' id='input2-total_npa' class='form-control thousand_format' value='" . ($act == 'edit' ? number_format($curr_data2['nilai_terkena_pajak']) : '') . "' readonly/>
                                            </div>
                                        </div>";
                            }

                            echo "</div>
                                <div class='form-group'>
                                    <label class='control-label col-md-3'>Dasar Pengenaan " . ($bundle_id != 5 && $bundle_id != 7 ? "<font color='red'>*</font>" : "") . "</label>
                                    <div class='col-md-6'>
                                        <div class='input'>
                                            <input class='form-control thousand_format' name='input-nilai_terkena_pajak-int' onkeyup=\"assess_tax1()\" 
                                            value='" . ($act == 'edit' ? number_format($curr_data2['nilai_terkena_pajak']) : '') . "' id='input-nilai_terkena_pajak' style='text-align:right' " . ($bundle_id != 5 && $bundle_id != 7 ? 'required' : 'readonly') . "/>
                                        </div>
                                    </div>
                                    <div class='col-md-3'>
                                        <div class='input'>
                                            <input class='form-control' name='input-persen_tarif' id='input-persen_tarif' value='" . $taxpayer_detail_row['persen_tarif'] . "' style='text-align:right' readonly/>
                                        </div>
                                        <div class='note'>
                                            tarif (%)
                                        </div>
                                    </div>
                                </div>";
                        } else if (in_array($bundle_id, $dtl_type2_arr)) {

                            if ($bundle_id == 4) {
                                $i = 1;
                                echo "
                                    <table class='table table-bordered'>
                                    <thead>
                                        <tr>";
                                if ($multiple_entertaiment_tax_row) {
                                    echo "<th>Jenis Hiburan</th>";
                                }
                                echo "<th width='20%'>Dasar Pengenaan</th><th width='10%'>Tarif (%)</th><th width='20%'>Pajak</th>";
                                if ($multiple_entertaiment_tax_row) {
                                    echo "<th>-</th>";
                                }
                                echo "</tr>
                                    </thead>
                                    <tbody id='detail1-tbody'>";
                                if ($act == 'add') {
                                    echo "<tr id='row-1'>";
                                    if ($multiple_entertaiment_tax_row) {
                                        echo "<td>
                                                    <select class='form-control' name='input2-kegus_id1' onchange=\"mix_function1(1)\" id='input2-kegus_id1'>
                                                        <option value=''></option>";
                                        foreach ($entertainment_type_rows as $row) {
                                            $selected = ($row['ref_kegus_id'] == $taxpayer_detail_row['kegus_id'] ? 'selected' : '');
                                            echo "<option value='" . $row['ref_kegus_id'] . "_" . $row['persen_tarif'] . "' " . $selected . ">" . $row['nama_kegus'] . "</option>";
                                        }
                                        echo "</select>
                                                </td>";
                                    } else {
                                        echo "<input type='hidden' name='input2-kegus_id" . $i . "' value='" . $taxpayer_detail_row['kegus_id'] . "'>";
                                    }
                                    echo "<td>
                                                    <input class='form-control thousand_format' name='input2-nilai_terkena_pajak1' id='input2-nilai_terkena_pajak1' onkeyup=\"mix_function2(1)\" style='text-align:right' required/>
                                                </td>
                                                <td>
                                                    <input class='form-control thousand_format' name='input2-persen_tarif1' id='input2-persen_tarif1' style='text-align:right' value='" . $taxpayer_detail_row['persen_tarif'] . "' readonly/>
                                                </td>
                                                <td>
                                                    <input class='form-control thousand_format' name='input2-pajak1' id='input2-pajak1' style='text-align:right' readonly/>
                                                </td>";
                                    if ($multiple_entertaiment_tax_row) {
                                        echo "<td></td>";
                                    }
                                    echo "</tr>";
                                } else {

                                    $i = 0;
                                    foreach ($curr_data2 as $row1) {
                                        $i++;
                                        echo "
                                                <tr id='row-" . $i . "'>";
                                        if ($multiple_entertaiment_tax_row) {
                                            echo "<td>
                                                    <select class='form-control' name='input2-kegus_id" . $i . "' onchange=\"mix_function1(" . $i . ")\" id='input2-kegus_id" . $i . "'>
                                                        <option value=''></option>";
                                            foreach ($entertainment_type_rows as $row2) {
                                                $selected = ($row2['ref_kegus_id'] == $row1['kegus_id'] ? 'selected' : '');
                                                echo "<option value='" . $row2['ref_kegus_id'] . "_" . $row2['persen_tarif'] . "' " . $selected . ">" . $row2['nama_kegus'] . "</option>";
                                            }
                                            echo "</select>
                                                    </td>";
                                        } else {
                                            echo "<input type='hidden' name='input2-kegus_id" . $i . "' value='" . $row1['kegus_id'] . "'>";
                                        }
                                        echo "<td>
                                                        <input class='form-control thousand_format' name='input2-nilai_terkena_pajak" . $i . "' id='input2-nilai_terkena_pajak" . $i . "' onkeyup=\"mix_function2(" . $i . ")\" value='" . number_format($row1['nilai_terkena_pajak']) . "' style='text-align:right' required/>
                                                    </td>
                                                    <td>
                                                        <input class='form-control thousand_format' name='input2-persen_tarif" . $i . "' id='input2-persen_tarif" . $i . "' style='text-align:right' value='" . number_format($row1['persen_tarif']) . "' readonly/>
                                                    </td>
                                                    <td>
                                                        <input class='form-control thousand_format' name='input2-pajak" . $i . "' id='input2-pajak" . $i . "' style='text-align:right' value='" . number_format($row1['pajak']) . "' readonly/>
                                                    </td>";
                                        if ($multiple_entertaiment_tax_row) {
                                            echo "<td>";
                                            if ($i > 1) {
                                                echo "<button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail1_row(" . $i . ");\"><i class='fa fa-trash-o'></i></button>";
                                            }
                                            echo "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                }
                                echo "</tbody>";

                                if ($multiple_entertaiment_tax_row) {
                                    echo "<tfoot>
                                            <tr>
                                                <td colspan='5' align='center'><a href='javascript:;' style='color:#000;' onclick=\"add_detail1_row()\"><i class='fa fa-plus'></i> Tambah baris</a></td>
                                            </tr>
                                        </tfoot>";
                                }

                                echo "<input type='hidden' id='n_detail1_rows' name='n_detail1_rows' value='" . $i . "'/></table>";
                            } else {
                                $i = 1;
                                echo "<table class='table table-bordered'>
                                    <thead>
                                        <tr><th>Satuan</th><th>Mineral Bukan Logam & Batuan</th><th width='20%'>Volume</th><th width='20%'>Tarif Dasar</th><th width='20%'>Nilai Jual</th><th>-</th></tr>
                                    </thead>
                                    <tbody id='detail2-tbody'>";
                                if ($act == 'add') {
                                    echo "
                                            <tr id='row-1'>
                                                <td>
                                                    <select class='form-control' name='input2-satuan1' id='input2-satuan1'>
                                                        <option value=''></option>
                                                        <option value='1'>Kubik</option>
                                                        <option value='2'>Ton</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class='form-control' name='input2-mblb_id1' id='input2-mblb_id1' onchange=\"mix_function3(1)\">
                                                        <option value=''></option>";
                                    foreach ($nonmetalic_mineral_rock_type_rows as $row) {
                                        echo "<option value='" . $row['ref_mblb_id'] . "_" . $row['tarif_kubik'] . "_" . $row['tarif_ton'] . "'>" . $row['jenis_mblb'] . "</option>";
                                    }
                                    echo "</select>
                                                </td>
                                                <td>
                                                    <input class='form-control thousand_format' name='input2-mblb_volume1' id='input2-mblb_volume1' onkeyup=\"mix_function4(1)\" style='text-align:right' required/>
                                                </td>                                            
                                                <td>
                                                    <input class='form-control thousand_format' name='input2-mblb_tarif_dasar1' id='input2-mblb_tarif_dasar1' onkeyup=\"mix_function4(1)\" style='text-align:right' required/>
                                                </td>
                                                <td>
                                                    <input class='form-control thousand_format' name='input2-mblb_nilai_jual1' id='input2-mblb_nilai_jual1' style='text-align:right' readonly/>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>";
                                } else {
                                    $i = 0;
                                    foreach ($nonmetalic_mineral_rock_rows as $row1) {
                                        $i++;
                                        echo "<tr id='row-" . $i . "'>
                                                    <td>
                                                        <select class='form-control' name='input2-satuan" . $i . "' id='input2-satuan" . $i . "'>
                                                            <option value=''></option>
                                                            <option value='1'>Kubik</option>
                                                            <option value='2'>Ton</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class='form-control' name='input2-mblb_id" . $i . "' id='input2-mblb_id" . $i . "' onchange=\"mix_function3(" . $i . ")\">
                                                            <option value=''></option>";
                                        foreach ($nonmetalic_mineral_rock_type_rows as $row2) {
                                            $selected = ($row1['mblb_id'] == $row2['ref_mblb_id'] ? 'selected' : '');
                                            echo "<option value='" . $row2['ref_mblb_id'] . "_" . $row2['tarif_kubik'] . "_" . $row2['tarif_ton'] . "' " . $selected . ">" . $row2['jenis_mblb'] . "</option>";
                                        }
                                        echo "</select>
                                                    </td>
                                                    <td>
                                                        <input class='form-control thousand_format' name='input2-mblb_volume" . $i . "' id='input2-mblb_volume" . $i . "' onkeyup=\"mix_function4(" . $i . ")\"  value='" . number_format($row1['volume']) . "' style='text-align:right' required/>
                                                    </td>                                            
                                                    <td>
                                                        <input class='form-control thousand_format' name='input2-mblb_tarif_dasar" . $i . "' id='input2-mblb_tarif_dasar" . $i . "' onkeyup=\"mix_function4(" . $i . ")\" value='" . number_format($row1['tarif_dasar']) . "' style='text-align:right' required/>
                                                    </td>
                                                    <td>
                                                        <input class='form-control thousand_format' name='input2-mblb_nilai_jual" . $i . "' id='input2-mblb_nilai_jual" . $i . "' value='" . number_format($row1['nilai_jual']) . "' style='text-align:right' readonly/>
                                                    </td>
                                                    <td>";
                                        if ($i > 1) {
                                            echo "<button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail2_row(" . $i . ");\"><i class='fa fa-trash-o'></i></button>";
                                        }
                                        echo "</td>
                                                </tr>";
                                    }
                                }
                                echo "
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan='5' align='center'><a href='javascript:;' style='color:#000;' onclick=\"add_detail2_row()\"><i class='fa fa-plus'></i> Tambah baris</a></td>
                                        </tr>
                                        <input type='hidden' id='n_detail2_rows' name='n_detail2_rows' value='" . $i . "'/>
                                    </tfoot>
                                    </table>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3'>Dasar Pengenaan</label>
                                        <div class='col-md-6'>
                                            <div class='input'>
                                                <input class='form-control thousand_format' name='input-nilai_terkena_pajak-int' onkeyup=\"assess_tax1()\" 
                                                value='" . ($act == 'edit' ? number_format($curr_data2['nilai_terkena_pajak']) : '') . "' id='input-nilai_terkena_pajak' style='text-align:right' readonly/>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='input'>
                                                <input class='form-control' name='input-persen_tarif' id='input-persen_tarif' value='" . $taxpayer_detail_row['persen_tarif'] . "' style='text-align:right' readonly/>
                                            </div>
                                            <div class='note'>
                                                tarif (%)
                                            </div>
                                        </div>
                                    </div>";
                            }
                        }

                        if ($bundle_id != '3') {
                            echo "
                                <div class='form-group'>
                                    <label class='control-label col-md-3'><b>Pajak Terhutang</b></label>
                                    <div class='col-md-9'>
                                        <div class='input'>
                                            <input class='form-control currency-text bg-gold' name='input-pajak-int' id='input-pajak' value='" . ($act == 'edit' ? number_format($curr_data['pajak']) : '') . "' style='font-size:1.6em;color:#fff;border:2px solid #fcf63f;' readonly/>
                                        </div>
                                    </div>
                                </div>";
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($bundle_id == '3') {
            $n_rows = 1;
            echo "
            <input type='hidden' name='skip_register' value='" . $skip_register . "'/>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            <i class='fa fa-money'></i> Perhitungan Pajak
                        </div>
                        <div class='panel-body' id='adsdetail-body'>";
            if ($act == 'add') {

                echo "
                                <div class='row' id='row-1'>
                                    <div class='col-md-12'>                                    
                                        <div align='right'><h5><span class='badge badge-secondary'># 1</span></h5></div>                                            
                                        <div class='box'>                                            
                                            <div class='row'>
                                                <div class='col-md-6'>
                                                    <div class='form-group'>
                                                        <label class='control-label col-md-4'>Jenis Reklame <font color='red'>*</font></label>
                                                        <div class='col-md-8'>
                                                            <div class='input state-disabled'>
                                                                <select class='form-control' name='input2-jenis_reklame_id1' id='input2-jenis_reklame_id1' onchange=\"load_dtl_ads_content(this.value,1)\" required>
                                                                    <option value=''></option>";
                foreach ($ads_type_rows as $row) {
                    echo "<option value='" . $row['ref_jenrek_id'] . "'>" . $row['jenis_reklame'] . "</option>";
                }
                echo "</select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label col-md-4'>Area</label>
                                                        <div class='col-md-8'>
                                                            <input type='radio' name='input2-area1' value='1' checked/> Outdoor&nbsp;&nbsp;<input type='radio' name='input2-area1' value='2'/> Indoor
                                                        </div>
                                                    </div>                                            
                                                </div>
                                                <div class='col-md-6'>
                                                    <div class='form-group'>
                                                        <label class='control-label col-md-4'>Naskah Judul <font color='red'>*</font></label>
                                                        <div class='col-md-8'>
                                                            <div class='input'>
                                                                <textarea class='form-control' name='input2-judul1' id='input2-judul1' rowspan='2' required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <label class='control-label col-md-4'>Lokasi Pasang <font color='red'>*</font></label>
                                                        <div class='col-md-8'>
                                                            <div class='input'>
                                                                <textarea class='form-control' name='input2-lokasi1' id='input2-lokasi1' rowspan='2' required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <label class='control-label col-md-4'>Tgl. Pasang <font color='red'>*</font></label>
                                                        <div class='col-md-4'>
                                                            <div class='input'>
                                                                <input class='form-control datepicker' name='input2-tgl_pasang1' id='input2-tgl_pasang1' value='' required/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <div id='loader-dtl_ads1' style='display:none;' align='center'>
                                                        <img src='" . $this->config->item('img_path') . "ajax-loaders/ajax-loader-1.gif'/>
                                                    </div>
                                                    <div id='content-dtl_ads1'>
                                                        <div class='alert alert-warning'>
                                                            Silahkan pilih Jenis Reklame pada Kotak Pilihan di sebelah kiri!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                   
                                    </div>
                                </div>";
            } else {

                $i = 0;
                foreach ($curr_data3 as $curr_data3_row) {
                    $i++;

                    echo "
                                    <div class='row' id='row-" . $i . "' style='margin-top:10px;'>
                                        <div class='col-md-12'>                                    
                                            <div align='right'><h5><span class='badge badge-secondary'># " . $i . "</span></h5></div>                                            
                                            <div class='box'>                                            
                                                <div class='row'>
                                                    <div class='col-md-6'>
                                                        <div class='form-group'>
                                                            <label class='control-label col-md-4'>Jenis Reklame <font color='red'>*</font></label>
                                                            <div class='col-md-8'>
                                                                <div class='input state-disabled'>
                                                                    <select class='form-control' name='input2-jenis_reklame_id" . $i . "' id='input2-jenis_reklame_id" . $i . "' onchange=\"load_dtl_ads_content(this.value," . $i . ")\" required>
                                                                        <option value=''></option>";
                    foreach ($ads_type_rows as $row) {
                        $selected = ($curr_data3_row['jenis_reklame_id'] == $row['ref_jenrek_id'] ? 'selected' : '');
                        echo "<option value='" . $row['ref_jenrek_id'] . "' " . $selected . ">" . $row['jenis_reklame'] . "</option>";
                    }
                    echo "</select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='control-label col-md-4'>Area</label>
                                                            <div class='col-md-8'>
                                                                <input type='radio' name='input2-area" . $i . "' value='1' " . ($curr_data3_row['area'] == '1' ? 'checked' : '') . "/> Outdoor&nbsp;&nbsp;
                                                                <input type='radio' name='input2-area" . $i . "' value='2' " . ($curr_data3_row['area'] == '2' ? 'checked' : '') . "/> Indoor
                                                            </div>
                                                        </div>                                            
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='form-group'>
                                                            <label class='control-label col-md-4'>Naskah Judul</label>
                                                            <div class='col-md-8'>
                                                                <div class='input'>
                                                                    <textarea class='form-control' name='input2-judul" . $i . "' id='input2-judul" . $i . "' rowspan='2'>" . $curr_data3_row['judul'] . "</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label class='control-label col-md-4'>Lokasi Pasang</label>
                                                            <div class='col-md-8'>
                                                                <div class='input'>
                                                                    <textarea class='form-control' name='input2-lokasi" . $i . "' id='input2-lokasi" . $i . "' rowspan='2'>" . $curr_data3_row['lokasi'] . "</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label class='control-label col-md-4'>Tgl. Pasang <font color='red'>*</font></label>
                                                            <div class='col-md-4'>
                                                                <div class='input'>
                                                                    <input class='form-control datepicker' name='input2-tgl_pasang" . $i . "' id='input2-tgl_pasang" . $i . "' value='" . indo_date_format($curr_data3_row['tgl_pasang'], 'shortDate') . "' required/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-12'>
                                                        <div id='loader-dtl_ads" . $i . "' style='display:none;' align='center'>
                                                            <img src='" . $this->config->item('img_path') . "ajax-loaders/ajax-loader-1.gif'/>
                                                        </div>
                                                        <div id='content-dtl_ads" . $i . "'>
                                                            " . $curr_data3_row['dtl_ads_content'] . "
                                                        </div>";
                    if ($i > 1) {
                        echo "<div align='center'><button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail3_row(" . $i . ")\">Hapus Detil Reklame</button></div>";
                    }
                    echo "</div>
                                                </div>
                                            </div>                                   
                                        </div>
                                    </div>";
                }
                $n_rows = $i;
            }

            echo "</div>
                        
                        <div class='panel-footer'>
                            <div class='form-group'>
                                <div class='col-md-2'>
                                    <button type='button' class='btn btn-xs btn-default' onclick=\"add_detail3_row()\"><i class='fa fa-plus'></i> Tambah Detil Reklame</button>
                                </div>
                                <label class='control-label col-md-3'><b>Pajak Terhutang</b></label>
                                <div class='col-md-7'>
                                    <div class='input'>
                                        <input class='form-control' name='input-pajak-int' id='input-pajak' value='" . ($act == 'edit' ? number_format($curr_data['pajak']) : '') . "' 
                                               style='text-align:right;font-weight:bold;font-size:1.6em;color:#fff;background:#f9a602;border:2px solid #fcf63f;' readonly/>
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' id='n_ads_detail_rows' name='n_ads_detail_rows' value='" . $n_rows . "'/>
                        </div>
                    </div>
                </div>
            </div>";
        }
        ?>
    </fieldset>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="submit" id="btn-save" class="btn btn-primary" <?= ($act == 'add' ? ($bundle_id == '3' ? 'disabled' : '') : ''); ?>>
                    Simpan
                </button>
                <button type="button" class="btn btn-default" id="close-modal-form" data-dismiss="modal">
                    Batal
                </button>
            </div>
        </div>
    </div>
</form>

<script src="<?= $this->config->item('js_path'); ?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        // START AND FINISH DATE
        $('#input-masa_pajak1').datepicker({
            dateFormat: 'dd-mm',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function(selectedDate) {
                $('#input-masa_pajak2').datepicker('option', 'minDate', selectedDate);
                $('#bulan_pajak').val('');
            }
        });

        $('#input-masa_pajak2').datepicker({
            dateFormat: 'dd-mm',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function(selectedDate) {
                $('#input-masa_pajak1').datepicker('option', 'maxDate', selectedDate);
                $('#bulan_pajak').val('');
            }
        });

        init_jquery_plugin();

    });

    function init_jquery_plugin() {
        $(".thousand_format").inputmask({
            'alias': 'numeric',
            rightAlign: true,
            'groupSeparator': '.',
            'autoGroup': true
        });

        $(".number").inputmask({
            'alias': 'numeric',
            'mask': '9999',
            rightAlign: true
        });

        $(".datepicker1").mask('99-99');
        $(".datepicker2").mask('99-99-9999');

        $('.datepicker1').datepicker({
            dateFormat: 'dd-mm',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });

        $('.datepicker2').datepicker({
            dateFormat: 'dd-mm-yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>'
        });

    }

    var main_form_id = '<?= $main_form_id; ?>';
    var $main_form = $('#' + main_form_id);
    var submit_noty = ($('#act').val() == 'add' ? 'menambah' : 'merubah');
    var main_form_stat = $main_form.validate({
        // Do not change code below
        errorPlacement: function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());

        }
    });

    //main form ajax process
    $main_form.submit(function() {
        if (main_form_stat.checkForm()) {
            ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true)
                .set_content('#list-data')
                .set_loading('#loader-list-data')
                .enable_pnotify()
                .set_form($main_form)
                .submit_ajax(submit_noty);
            $('#close-modal-form').click();
            return false;
        }
    });


    function load_dtl_ads_content(val, order_num) {
        ajax_object.reset_object();
        data_ajax = ['ads_type_id=' + val, 'tax_percentage=' + $('#persen_tarif').val(), 'order_num=' + order_num, 'menu=' + $('#menu').val()];
        ajax_object.set_url(base_url + 'bundle/taxes/advertisement/record_tax_object_data/load_dtl_ads_content')
            .set_plugin_datatable(false)
            .set_content('#content-dtl_ads' + order_num)
            .set_loading('#loader-dtl_ads' + order_num)
            .set_data_ajax(data_ajax)
            .request_ajax();

        $('#input-pajak').val('');
        $('#btn-save').attr('disabled', (val == ''));

    }

    function assess_tax1(input, i) {
        bundle_id = document.getElementById('pajak_id').value
        var input = (typeof(input) == 'undefined' ? 'input' : input);
        var i = (typeof(i) == 'undefined' ? '' : i);

        var $base = $('#' + input + '-nilai_terkena_pajak' + i),
            $percent = $('#' + input + '-persen_tarif' + i),
            $kompensasi = $('#input-kompensasi'),
            $tax = $('#' + input + '-pajak' + i);
        var base = gnv($base.val()),
            percent = gnv($percent.val()),
            kompensasi = gnv($kompensasi.val()),
            tax = 0;
        console.log($kompensasi)
        base = replaceall(base, ',', '');
        percent = replaceall(percent, ',', '');
        if (bundle_id == 2 && base < 2000000) {
            tax = 0
        } else {
            tax = parseFloat(base) * (parseFloat(percent) / 100);
        }
        tax = Math.round(tax)
        tax = tax - kompensasi
        // tax = (tax == 0 ? 0 : number_format(tax, 0, '.', ','));
        tax = (tax == 0 ? 0 : number_format(tax, 0, '.', ','));

        $tax.val(tax);
    }

    function assess_tax2() { //groundwater tax

        var compensation_component_weights = <?= $compensation_component_weights_json ?>;

        var $volume = $('#input2-volume'),
            $tarif_dasar = $('#input2-tarif_dasar'),
            // $compensation_percent = $('#input2-persen_komponen_kompensasi'),
            // $unit_price = $('#input2-harga_satuan'),
            $tot_npa = $('#input2-total_npa'),
            $base = $('#input-nilai_terkena_pajak'),
            $tax = $('#input-pajak'),
            $kompensasi = $('#input-kompensasi'),
            $percent = $('#input-persen_tarif'),
            $tbody = $('#tbody-groundwater_assessment');
        var volume = gnv($volume.val()),
            tarif_dasar = gnv($tarif_dasar.val()),
            kompensasi = gnv($kompensasi.val()),
            // compensation_percent = gnv($compensation_percent.val()),
            // unit_price = gnv($unit_price.val()),
            percent = gnv($percent.val());
        var remain = 0,
            tank_volume = 0,
            step_volume = 0,
            tot_npa = 0,
            tax = 0;

        var rows = "";

        volume = parseFloat(replaceall(volume, ',', ''));
        tarif_dasar = parseFloat(replaceall(tarif_dasar, ',', ''));
        // compensation_percent = parseFloat(replaceall(compensation_percent, ',', ''));
        // unit_price = parseFloat(replaceall(unit_price, ',', ''));

        compensation_component_weights = sortByKey(compensation_component_weights, 'asc');
        $tbody.empty();

        var i = 0;
        remain = volume;

        tot_npa = volume * tarif_dasar;

        // while (tank_volume < volume) {

        //     components = compensation_component_weights[i];

        //     min = parseFloat(components[0]);
        //     max = parseFloat(components[1][1]);
        //     weight = parseFloat(components[1][0]);

        //     if (remain > max) {
        //         step_volume = (max - tank_volume <= max ? max - tank_volume : remain);
        //     } else {
        //         step_volume = ((tank_volume + remain) <= max ? remain : max - tank_volume);
        //     }

        //     tank_volume += parseFloat(step_volume);
        //     remain -= parseFloat(step_volume);

        //     // nkp = weight * compensation_percent / 100;
        //     // nkp = weight / 100;
        //     // nkp = decimal_round(nkp, 2);
        //     // fna = sda_value + nkp;
        //     // fna = decimal_round(fna, 2);
        //     // npa = unit_price * step_volume * fna;
        //     // npa = unit_price * step_volume;
        //     npa = weight * volume;
        //     tot_npa += npa;

        //     npa = (npa == 0 ? 0 : number_format(npa, 0, '.', ','));

        //     rows += "<tr><td>Volume " + min + "-" + max + " => " + step_volume + "</td>";
        //     rows += "<td align='right'>" + weight + "</td>";
        //     // rows += "<td align='right'>" + nkp + "</td>";
        //     // rows += "<td align='right'>" + fna + "</td>";
        //     rows += "<td align='right'>" + npa + "</td>";
        //     rows += "</tr>";
        //     i++;
        // }

        tax = parseFloat(tot_npa) * (parseFloat(percent) / 100);
        tax = Math.round(tax)
        tax = tax - kompensasi

        tax = (tax == 0 ? 0 : number_format(tax, 2, '.', ','));
        tot_npa = (tot_npa == 0 ? 0 : number_format(tot_npa, 0, '.', ','));

        $tot_npa.val(tot_npa);
        $base.val(tot_npa);
        $tax.val(tax);

        $tbody.append(rows);

    }

    function assess_tax3() {
        var n_rows = parseInt($('#n_detail1_rows').val()),
            $tax = $('#input-pajak');

        var total_tax = 0;

        for (i = 1; i <= n_rows; i++) {
            $sub_tax = $('#input2-pajak' + i);
            if ($sub_tax.length) {
                sub_tax = gnv($sub_tax.val());
                // console.log(sub_tax)
                sub_tax = replaceall(sub_tax, ',', '');
                total_tax += parseFloat(sub_tax);
            }
        }
        total_tax = Math.round(total_tax)
        total_tax = number_format(total_tax, 0, '.', ',');

        $tax.val(total_tax);
    }

    function assess_tax4() {
        var $power_usage = $('#input2-penggunaan_daya'),
            $basic_rate = $('#input2-tarif_dasar'),
            $base = $('#input-nilai_terkena_pajak'),
            $kompensasi = $('#input-kompensasi'),
            $percent = $('#input-persen_tarif'),
            $tax = $('#input-pajak');
        var power_usage = gnv($power_usage.val()),
            basic_rate = gnv($basic_rate.val()),
            kompensasi = gnv($kompensasi.val()),
            percent = gnv($percent.val()),
            rate = 0,
            tax = 0;

        power_usage = replaceall(power_usage, ',', '');
        basic_rate = replaceall(basic_rate, ',', '');
        percent = replaceall(percent, ',', '');

        base = parseFloat(power_usage) * parseFloat(basic_rate);
        tax = base * (parseFloat(percent) / 100);
        tax = Math.round(tax)
        tax = tax - kompensasi

        base = (base == 0 ? 0 : number_format(base, 0, '.', ','));
        tax = (tax == 0 ? 0 : number_format(tax, 0, '.', ','));

        $base.val(base);
        $tax.val(tax);
    }

    function assess_mblb_sale_value(i) {
        var $volume = $('#input2-mblb_volume' + i),
            $base_rate = $('#input2-mblb_tarif_dasar' + i),
            $sale_value = $('#input2-mblb_nilai_jual' + i);
        var volume = gnv($volume.val()),
            base_rate = gnv($base_rate.val()),
            sale_value = 0;

        volume = replaceall(volume, ',', '');
        base_rate = replaceall(base_rate, ',', '');

        sale_value = parseFloat(volume) * parseFloat(base_rate);
        sale_value = (sale_value == 0 ? 0 : number_format(sale_value, 0, '.', ','));

        $sale_value.val(sale_value);
    }

    function assess_mblb_base_assessment() {

        var n_rows = parseInt($('#n_detail2_rows').val()),
            $base_assessment = $('#input-nilai_terkena_pajak');

        var total_base_assessment = 0;

        for (i = 1; i <= n_rows; i++) {
            $sub_sale_value = $('#input2-mblb_nilai_jual' + i);
            if ($sub_sale_value.length) {
                sub_sale_value = gnv($sub_sale_value.val());
                sub_sale_value = replaceall(sub_sale_value, ',', '');
                total_base_assessment += parseFloat(sub_sale_value);
            }
        }

        total_base_assessment = number_format(total_base_assessment, 0, '.', ',');

        $base_assessment.val(total_base_assessment);

    }

    function assess_sub_tax1(i) {

        assess_tax1('input2', i);
    }

    function delete_detail1_row(order_num) {
        var $tr = $('#detail1-tbody > tr');
        $tr.remove('#row-' + order_num);
        assess_tax3();
        init_jquery_plugin();
    }

    function delete_detail2_row(order_num) {
        var $tr = $('#detail2-tbody > tr');
        $tr.remove('#row-' + order_num);
        assess_mblb_base_assessment();
        assess_tax1();
        init_jquery_plugin();
    }

    function delete_detail3_row(order_num) {
        var $row = $('#adsdetail-body > div');
        $row.remove('#row-' + order_num);
        adstax_assess_total_tax();
        init_jquery_plugin();
    }


    <?php
    if ($bundle_id == '4') {

        if ($multiple_entertaiment_tax_row) {
    ?>

            function add_detail1_row() { //entertainment tax

                var entertainment_type_rows = <?= $entertainment_type_rows_json ?>;

                var $tbody = $('#detail1-tbody'),
                    $lc_tbody = $('#detail1-tbody tr:last-child'),
                    $n_rows = $('#n_detail1_rows');

                var last_row_id = $lc_tbody.attr('id');

                x = last_row_id.split('-');
                last_order = x[1];
                new_order = parseInt(last_order) + 1;

                new_row = "<tr id='row-" + new_order + "'><td><select class='form-control' name='input2-kegus_id" + new_order + "' onchange=\"mix_function1(" + new_order + ")\" id='input2-kegus_id" + new_order + "'>";
                new_row += "<option value=''></option>";

                for (i = 0; i < entertainment_type_rows.length; i++) {
                    new_row += "<option value='" + entertainment_type_rows[i]['ref_kegus_id'] + "_" + entertainment_type_rows[i]['persen_tarif'] + "'>" + entertainment_type_rows[i]['nama_kegus'] + "</option>";
                }

                new_row += "</select></td>" +
                    "<td><input class='form-control thousand_format' name='input2-nilai_terkena_pajak" + new_order + "' id='input2-nilai_terkena_pajak" + new_order + "' onkeyup=\"mix_function2(" + new_order + ")\" style='text-align:right' required/></td>" +
                    "<td><input class='form-control thousand_format' name='input2-persen_tarif" + new_order + "' id='input2-persen_tarif" + new_order + "' style='text-align:right' readonly/></td>" +
                    "<td><input class='form-control thousand_format' name='input2-pajak" + new_order + "' id='input2-pajak" + new_order + "' style='text-align:right' readonly/></td>" +
                    "<td><button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail1_row(" + new_order + ");\"><i class='fa fa-trash-o'></i></button></td></tr>";

                $n_rows.val(new_order);
                $tbody.append(new_row);

                init_jquery_plugin();

            }

    <?php }
    } ?>

    function add_detail2_row() { //nonmetallic_mineral_rock tax

        var nonmetalic_mineral_rock_type_rows = <?= $nonmetalic_mineral_rock_type_rows_json ?>;


        var $tbody = $('#detail2-tbody'),
            $lc_tbody = $('#detail2-tbody tr:last-child'),
            $n_rows = $('#n_detail2_rows');

        var last_row_id = $lc_tbody.attr('id');

        x = last_row_id.split('-');
        last_order = x[1];
        new_order = parseInt(last_order) + 1;

        new_row = "<tr id='row-" + new_order + "'><td><select class='form-control' name='input2-satuan" + new_order + "' id='input2-satuan" + new_order + "'><option value='' ></option><option value= '1'> Kubik </option><option value='2'> Ton </option></select></td><td><select class='form-control' name='input2-mblb_id" + new_order + "' onchange=\"mix_function3(" + new_order + ")\" id='input2-mblb_id" + new_order + "'>";
        new_row += "<option value=''></option>";

        for (i = 0; i < nonmetalic_mineral_rock_type_rows.length; i++) {
            new_row += "<option value='" + nonmetalic_mineral_rock_type_rows[i]['ref_mblb_id'] + "_" + nonmetalic_mineral_rock_type_rows[i]['tarif_kubik'] + "_" + nonmetalic_mineral_rock_type_rows[i]['tarif_ton'] + "'>" + nonmetalic_mineral_rock_type_rows[i]['jenis_mblb'] + "</option>";
        }

        new_row += "</select></td>" +
            "<td><input class='form-control thousand_format' name='input2-mblb_volume" + new_order + "' id='input2-mblb_volume" + new_order + "' onkeyup=\"mix_function4(" + new_order + ")\" style='text-align:right' required/></td>" +
            "<td><input class='form-control thousand_format' name='input2-mblb_tarif_dasar" + new_order + "' id='input2-mblb_tarif_dasar" + new_order + "' onkeyup=\"mix_function4(" + new_order + ")\" style='text-align:right' required/></td>" +
            "<td><input class='form-control thousand_format' name='input2-mblb_nilai_jual" + new_order + "' id='input2-mblb_nilai_jual" + new_order + "' style='text-align:right' readonly/></td>" +
            "<td><button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail2_row(" + new_order + ");\"><i class='fa fa-trash-o'></i></button></td></tr>";

        $n_rows.val(new_order);
        $tbody.append(new_row);

        init_jquery_plugin();

    }


    function add_detail3_row() { //ads tax

        var ads_type_rows = <?= $ads_type_rows_json ?>;

        var $body = $('#adsdetail-body'),
            $lc_body = $('#adsdetail-body > div:last-child'),
            $n_rows = $('#n_ads_detail_rows');
        var last_row_id = $lc_body.attr('id');

        x = last_row_id.split('-');
        last_order = x[1];
        new_order = parseInt(last_order) + 1;

        new_row = "<div class='row' id='row-" + new_order + "' style='margin-top:10px;'>";
        new_row += "<div class='col-md-12'>" +
            "<div align='right'><h5><span class='badge badge-secondary'># " + new_order + "</span></h5></div>" +
            "<div class='box'><div class='row'>" +
            "<div class='col-md-6'><div class='form-group'><label class='control-label col-md-4'>Jenis Reklame <font color='red'>*</font></label>" +
            "<div class='col-md-8'><div class='input state-disabled'>" +
            "<select class='form-control' name='input2-jenis_reklame_id" + new_order + "' id='input2-jenis_reklame_id" + new_order + "' onchange=\"load_dtl_ads_content(this.value," + new_order + ")\" required>" +
            "<option value=''></option>";
        for (i = 0; i < ads_type_rows.length; i++) {
            new_row += "<option value='" + ads_type_rows[i]['ref_jenrek_id'] + "'>" + ads_type_rows[i]['jenis_reklame'] + "</option>";
        }

        new_row += "</select></div></div></div><div class='form-group'><label class='control-label col-md-4'>Area</label>" +
            "<div class='col-md-8'>" +
            "<input type='radio' name='input2-area" + new_order + "' value='1' checked/> Outdoor&nbsp;&nbsp;<input type='radio' name='input2-area" + new_order + "' value='2'/> Indoor" +
            "</div></div></div><div class='col-md-6'>" +
            "<div class='form-group'><label class='control-label col-md-4'>Naskah Judul <font color='red'>*</font></label><div class='col-md-8'>" +
            "<div class='input'><textarea class='form-control' name='input2-judul" + new_order + "' id='input2-judul" + new_order + "' rowspan='2' required></textarea></div>" +
            "</div></div>" +
            "<div class='form-group'>" +
            "<label class='control-label col-md-4'>Lokasi Pasang <font color='red'>*</font></label>" +
            "<div class='col-md-8'><div class='input'>" +
            "<textarea class='form-control' name='input2-lokasi" + new_order + "' id='input2-lokasi" + new_order + "' rowspan='2' required></textarea>" +
            "</div></div></div>" +
            "<div class='form-group'>" +
            "<label class='control-label col-md-4'>Tgl. Pasang <font color='red'>*</font></label>" +
            "<div class='col-md-4'><div class='input'><input class='form-control datepicker' name='input2-tgl_pasang" + new_order + "' id='input2-tgl_pasang" + new_order + "' value='' required/>" +
            "</div></div></div>" +
            "</div></div>" +
            "<div class='row'><div class='col-md-12'>" +
            "<div id='loader-dtl_ads" + new_order + "' style='display:none;' align='center'>" +
            "<img src='" + $('#img_path').val() + "ajax-loaders/ajax-loader-1.gif'/>" +
            "</div>" +
            "<div id='content-dtl_ads" + new_order + "'><div class='alert alert-warning'>Silahkan pilih Jenis Reklame pada Kotak Pilihan di sebelah kiri!</div>" +
            "</div>" +
            "<div align='center'><button type='button' class='btn btn-default btn-xs' onclick=\"delete_detail3_row(" + new_order + ")\">Hapus Detil Reklame</button></div></div></div></div></div>";

        new_row += "</div>";

        $n_rows.val(new_order);
        $body.append(new_row);

        init_jquery_plugin();

    }




    function fill_entertainment_tax_rate(i) {
        var $business = $('#input2-kegus_id' + i),
            $percent = $('#input2-persen_tarif' + i);
        var x_business = $business.val().split('_');
        $percent.val(x_business[1]);
    }

    function fill_mblb_tax_base_rate(i) {
        var $mblb = $('#input2-mblb_id' + i),
            $satuan = $('#input2-satuan' + i),
            $base_rate = $('#input2-mblb_tarif_dasar' + i);
        var x_mblb = $mblb.val().split('_'),
            satuan = $satuan.val();
        if (satuan == 1) {
            $base_rate.val(x_mblb[1]);
        } else {
            $base_rate.val(x_mblb[2]);
        }
        // $base_rate.val(x_mblb[1]);
    }

    function mix_function1(i) {
        fill_entertainment_tax_rate(i);
        assess_sub_tax1(i);
        assess_tax3();
    }

    function mix_function2(i) {
        assess_sub_tax1(i);
        assess_tax3();
    }

    function mix_function3(i) {
        fill_mblb_tax_base_rate(i);
        assess_mblb_sale_value(i);
        assess_mblb_base_assessment();
        assess_tax1();
    }

    function mix_function4(i) {
        assess_mblb_sale_value(i);
        assess_mblb_base_assessment();
        assess_tax1();
    }

    function fill_tax_period(i) {
        var $tax_period1 = $('#input-masa_pajak1'),
            $tax_period2 = $('#input-masa_pajak2')
        var range_dates = <?= $range_dates_json ?>;

        if (i != '') {
            $tax_period1.val(range_dates[i - 1]['start']);
            $tax_period2.val(range_dates[i - 1]['end']);
        } else {
            $tax_period1.val('');
            $tax_period2.val('');
        }

    }













    function adstax_execute_multifunction1(order_num) {

        adstax_place_index_value('kawasan', order_num);
        adstax_place_index_value('sudut_pandang', order_num);
        adstax_place_index_value('kelas_jalan', order_num);
        adstax_place_index_value('ketinggian', order_num);
        adstax_assess_nsl(order_num);
        adstax_assess_nsr(order_num);
        adstax_assess_sub_tax(order_num);
        adstax_assess_total_tax();
    }

    function adstax_execute_multifunction2(order_num) {
        adstax_assess_nsr(order_num);
        adstax_assess_sub_tax(order_num);
        adstax_assess_total_tax();
    }

    function adstax_place_index_value(type, order_num) {
        var $index_id = $('#input2-indeks_' + type + '_id' + order_num + ' :selected'),
            $index_val = $('#input2-indeks_' + type + order_num);
        var x = $index_id.val().split('_');
        var index = x[1];
        $index_val.val(index);
    }

    function adstax_assess_nsl(order_num) {

        var $index1 = $('#input2-indeks_kawasan' + order_num),
            $index2 = $('#input2-indeks_sudut_pandang' + order_num),
            $index3 = $('#input2-indeks_kelas_jalan' + order_num),
            $index4 = $('#input2-indeks_ketinggian' + order_num),
            $nsl = $('#input2-nsl' + order_num);

        var index1 = gnv($index1.val()),
            index2 = gnv($index2.val()),
            index3 = gnv($index3.val()),
            index4 = gnv($index4.val()),
            nsl = 0;

        index1 = replaceall(index1, ',', '');
        index2 = replaceall(index2, ',', '');
        index3 = replaceall(index3, ',', '');
        index4 = replaceall(index4, ',', '');

        nsl = parseFloat(index1) + parseFloat(index2) + parseFloat(index3) + parseFloat(index4);

        nsl = (nsl == 0 ? 0 : number_format(nsl, 2, '.', ','));

        $nsl.val(nsl);

    }

    function adstax_assess_nsr(order_num) {

        var $nsl = $('#input2-nsl' + order_num),
            $size = $('#input2-ukuran' + order_num),
            $periode = $('#input2-jangka_waktu' + order_num),
            $numbers = $('#input2-jumlah' + order_num),
            $unit_price = $('#input2-harga_satuan' + order_num),
            $nsr = $('#input2-nilai_sewa_reklame' + order_num);

        var nsl = gnv($nsl.val()),
            size = gnv($size.val()),
            periode = gnv($periode.val()),
            numbers = gnv($numbers.val()),
            unit_price = gnv($unit_price.val()),
            nsr = 0;
        nsl = replaceall(nsl, ',', '');
        size = replaceall(size, ',', '');
        periode = replaceall(periode, ',', '');
        numbers = replaceall(numbers, ',', '');
        unit_price = replaceall(unit_price, ',', '');

        nsr = parseFloat(nsl) * parseFloat(size) * parseFloat(periode) * parseFloat(numbers) * parseFloat(unit_price);

        nsr = (nsr == 0 ? 0 : number_format(nsr, 0, '.', ','));

        $nsr.val(nsr);

    }


    function adstax_assess_sub_tax(order_num) {

        var $nsr = $('#input2-nilai_sewa_reklame' + order_num),
            $percent = $('#input2-persen_tarif' + order_num),
            $tax = $('#input2-pajak' + order_num);

        var nsr = gnv($nsr.val()),
            percent = gnv($percent.val()),
            tax = 0;

        nsr = replaceall(nsr, ',', '');
        percent = replaceall(percent, ',', '');

        tax = parseFloat(nsr) * parseFloat(percent) / 100;
        tax = (tax == 0 ? 0 : number_format(tax, 0, '.', ','));

        $tax.val(tax);
    }


    function adstax_assess_total_tax() {

        var n_rows = parseInt($('#n_ads_detail_rows').val()),
            $tax = $('#input-pajak');

        var total_tax = 0;

        for (i = 1; i <= n_rows; i++) {
            $sub_tax = $('#input2-pajak' + i);
            if ($sub_tax.length) {
                sub_tax = gnv($sub_tax.val());
                sub_tax = replaceall(sub_tax, ',', '');
                total_tax += parseFloat(sub_tax);
            }
        }

        total_tax = number_format(total_tax, 0, '.', ',');

        $tax.val(total_tax);
    }
</script>