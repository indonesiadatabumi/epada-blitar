<form class="form-horizontal" id="search_form" action="<?= base_url() . "bundle/taxes/" . $bundle_item_type . "/print_reprimand_letter_old/report_controller"; ?>" method="POST">
    <input type="hidden" name="menu" id="menu" value="print_reprimand_letter_old" />
    <input type="hidden" name="report_type" id="report_type" />
    <fieldset>
        <div class="form-group">
            <label class="control-label col-md-2">Periode SPT</label>
            <div class="col-md-2">
                <div class="input">
                    <input type="text" class="form-control" name="src-tahun_pajak" id="src1-tahun_pajak" value="<?= date('Y'); ?>" maxlength="4" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">N.P.W.P.D</label>
            <div class="col-md-4">
                <div class="input">
                    <div class="input-group">
                        <input class="form-control" type="text" name="src-npwprd" id="src-npwprd" value="<?= $data_wp['npwprd'] ?>" readonly required />
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Pajak / Kegiatan Usaha</label>
            <div class="col-md-5">
                <div class="input">
                    <input class="form-control" id="src-jenis_pajak" value="<?= $data_wp['nama_kegus'] ?>" readonly />
                    <input type="hidden" name="src-wp_wr_detil_id" id="src-wp_wr_detil_id" />
                </div>
            </div>
        </div>

        <hr>
        </hr>

        <div class="form-group">
            <label class="control-label col-md-2">Tgl. Cetak</label>
            <div class="col-md-2">
                <div class="input">
                    <input type="text" class="form-control" name="src-tgl_cetak" value="<?= date('d-m-Y'); ?>" id="src-tgl_cetak">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Mengetahui</label>
            <div class="col-md-6">
                <select class="form-control" name="printAttr-legalitator" id="printAttr-legalitator">
                    <option value="" selected></option>
                    <?php
                    foreach ($official_rows as $row) {
                        echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . " / " . $row['nama_jabatan'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Diperiksa Oleh</label>
            <div class="col-md-6">
                <select class="form-control" name="printAttr-evaluator" id="printAttr-evaluator">
                    <option value="" selected></option>
                    <?php
                    foreach ($official_rows as $row) {
                        echo "<option value='" . $row['pejda_id'] . "'>" . $row['nama'] . " / " . $row['nama_jabatan'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit" onclick="fill_report_type('1','1')"><i class="fa fa-print"></i> Cetak</button>
        </div>

    </fieldset>
</form>
<script type="text/javascript">
    function fill_report_type(rpt_type) {
        $('#report_type').val(rpt_type);
    }
</script>