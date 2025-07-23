<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <div class="card">
            
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab1" aria-controls="main" role="tab" data-toggle="tab">Data Utama</a></li>
                <?php
                if(isset($data_form_content2)){
                    echo "<li role='presentation'><a href='#tab2' aria-controls='other-tax' role='tab' data-toggle='tab'>Pajak & Keg. Usaha Lain</a></li>
                    <li role='presentation'><a href='#tab3' aria-controls='images' role='tab' data-toggle='tab'>Gambar</a></li>
                    <li role='presentation'><a href='#tab4' aria-controls='map' role='tab' data-toggle='tab'>Peta Lokasi</a></li>";
                }
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab1">
                    <?php  
                        $this->load->view($view_folder.'/form_content1',$data_form_content1);
                    ?>
                </div>

                <?php
                if(isset($data_form_content2)){
                    
                    echo "
                    <div role='tabpanel' class='tab-pane' id='tab2'>";
                        $this->load->view($view_folder.'/form_content2',$data_form_content2);
                    echo "</div>";
                    
                    echo "<div role='tabpanel' class='tab-pane' id='tab3'>";
                            $this->load->view($view_folder.'/form_content3',$data_form_content3);
                    echo "</div>";
                    
                    echo "<div role='tabpanel' class='tab-pane' id='tab4'>";
                            $this->load->view($view_folder.'/form_content4',$data_form_content4);
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
