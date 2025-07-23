<?php
echo "<input type='hidden' name='input1-jenis_sat_id' id='input1-jenis_sat_id' value='" . $zona_rows->ref_jensat_id . "'' /><input class='form-control' value='" . $zona_rows->ref_jensat_id . "." . $zona_rows->jenis_sat . "'' readonly onblur=\"get_sda(this.value,'input1-kompkom_id')\" />";
