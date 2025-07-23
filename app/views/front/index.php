            <style>
                #rcorners1 {
                    border-radius: 25px;
                }
            </style>
            <section class="portfolio-showcase-block" style="margin-top:60px!important">
                <div class="inside">

                    <div class="row" style="margin-bottom:25px;">
                        <div class="col-md-6 portfolio-blue post-41 metrolics_portfolio type-metrolics_portfolio status-publish hentry" style="cursor:pointer;">
                            <a href="<?= base_url() ?>">
                                <div class="featured-content" id="rcorners1">
                                    <img src="<?= $this->config->item('img_path'); ?>bundle-icon/tax11.png" style="width:750px;" alt="Smart Map" />

                                    <div class='featured-desc'>
                                        <h4>SIG PBB</h4>
                                        <span class='feat-category'>Jumlah Objek Pajak : Objek</span>
                                        <span class='feat-icon'><i class='fa fa-globe fa-lg'></i></span>
                                    </div>

                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 post-41 metrolics_portfolio type-metrolics_portfolio status-publish hentry">
                            <div class="featured-content" id="rcorners1">
                                <div class="box" style="height: 325px;">
                                    <!-- <h3 style="font-weight:bold;margin:0!important">Capaian Realisasi Target Penerimaan Pajak</h3> -->
                                    <h3 style="font-weight:bold;margin:0!important">Capaian Realisasi Target Penerimaan Pajak <select id="tahun_pajak" onchange="get_realisasi()">
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                        </select></h3>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Jenis Pajak</th>
                                                <th colspan="2" style="text-align: center;">Total WP</th>
                                                <th colspan="2" style="text-align: center;">Total Pajak</th>
                                                <!-- <th>Target</th>
                                                <th>Realisasi</th> -->
                                            </tr>
                                            <tr>
                                                <th>Target</th>
                                                <th>Realisasi</th>
                                                <th>Target</th>
                                                <th>Realisasi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hasil_realisasi">
                                            <?php
                                            foreach ($realisasi as $row) {
                                                $realization = rand(0, 99);
                                                echo "<tr>
                                                    <td>" . $row['nama_pajak'] . "</td>
                                                    <td>" . $row['target_wp'] . "</td>
                                                    <td>" . $row['tot_realisasi_wp'] . "</td>
                                                    <td align='right'>" . number_format($row['target_pajak'], 0, '.', ',') . "</td>
                                                    <td align='right'>" . number_format($row['tot_realisasi'], 0, '.', ',') . "</td>
                                                    </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $i = 0;
                    foreach ($bundle_rows as $row) {

                        if ($i % 3 == 0 or $i == 0) {
                            echo "<div class='caption-style-4 clear'>";
                        }

                        echo "
                            <div style='cursor:pointer;' 
                            class='post-41 metrolics_portfolio type-metrolics_portfolio status-publish hentry featured-list " . $row['backtext_color'] . " " . (($i + 1) % 3 == 0 ? "last" : "") . "'>
                                <a href='" . base_url() . $row['sub_url'] . "'>
                                    <div class='featured-content' id='rcorners1'>
                                        <img style='width:356px; height:220px;' src='" . $this->config->item('img_path') . "bundle-icon/" . $row['icon1'] . "' class='attachment-post-thumbnail wp-post-image' alt='" . $row['nama_paret'] . "'/>
                                        <div class='featured-desc'>
                                            <h4>" . $row['nama_paret'] . "</h4>
                                            <span class='feat-category'>Penerimaan Agustus : 

                                            </span>
                                            <span class='feat-icon'><i class='fa fa-globe fa-lg'></i></span>
                                        </div>
                                        <div class='caption'>
                                            <div class='blur'>&nbsp;</div>
                                            <div class='caption-text'>
                                                <h4>" . $row['nama_paret'] . "</h4>    
                                                <span class='feat-category'>Penerimaan Agustus : Rp. 52.000.000</span>
                                            </div>
                                        </div>  
                                    </div>
                                </a>
                            </div>";

                        if (($i + 1) % 3 == 0) {
                            echo "</div>";
                        }

                        $i++;
                    }
                    ?>
                    <?php
                    echo "
                            <div style='cursor:pointer;' 
                            class='post-41 metrolics_portfolio type-metrolics_portfolio status-publish hentry featured-list '>
                                <a href='" . base_url() . "/portal_payment/index.php' target='_blank'>
                                    <div class='featured-content' id='rcorners1'>
                                        <img style='width:356px; height:220px;' src='" . $this->config->item('img_path') . "bundle-icon/retribution.jpeg' class='attachment-post-thumbnail wp-post-image' alt='Portal Pembayaran'/>
                                        <div class='featured-desc'>
                                            <h4>Portal Pembayaran</h4>
                                            <span class='feat-icon'><i class='fa fa-money fa-lg'></i></span>
                                        </div>
                                        <div class='caption'>
                                            <div class='blur'>&nbsp;</div>
                                            <div class='caption-text'>
                                                <h4>Portal Pembayaran</h4>    
                                            </div>
                                        </div>  
                                    </div>
                                </a>
                            </div>";
                    ?>
            </section>
            <section class="page-content">
                <div class="inside clear"></div>
            </section>

            <script>
                $(document).ready(function() {
                    get_realisasi()
                });

                function get_realisasi() {
                    var tahun = $('#tahun_pajak').val();
                    $.ajax({
                        type: "POST",
                        url: "https://e-pada.blitarkab.go.id/front/get_realisasi",
                        data: {
                            tahun_pajak: tahun
                        },
                        dataType: "json",
                        success: function(response) {
                            var tbody = $('#hasil_realisasi');
                            tbody.empty(); // bersihkan isi sebelumnya

                            if (Array.isArray(response)) {
                                response.forEach(function(item) {
                                    var row = `
                                        <tr>
                                            <td>${item.nama_pajak}</td>
                                            <td>${item.target_wp}</td>
                                            <td>${item.tot_realisasi_wp}</td>
                                            <td align="right">${formatNumber(item.target_pajak)}</td>
                                            <td align="right">${formatNumber(item.tot_realisasi)}</td>
                                        </tr>
                                        `;
                                    tbody.append(row);
                                });
                            } else {
                                tbody.append('<tr><td colspan="5">Data tidak ditemukan</td></tr>');
                            }
                        }
                    });
                }

                function formatNumber(num) {
                    return Number(num).toLocaleString('id-ID');
                }
            </script>