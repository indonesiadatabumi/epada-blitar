
        <!-- PRELOAD OBJECT -->
        <div id="preloadAnimation" class="preload-wrapper">
            <div id="preloader_1">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- /PRELOAD OBJECT -->
        <div id="preloader"><div id="status">&nbsp;</div></div>
        
        <!--CONTAINER-->
        <div id="motherContainer">
            
            <!-- TOP FIXED NAVIGATION -->
            <div id="myNavbar" class="navbar navbar-default navbar-fixed-top" role="navigation" style="display:block;">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand" style="margin:0!important;padding:10px 0">
                            <a href="<?=base_url();?>">
                            <img src="<?=$this->config->item('img_path');?>app_logo.png" style="width:120px"/></a>
                        </div>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            
                            <li><a href="<?=base_url();?>">Home</a></li>                            
                            <li><a href="<?=base_url();?>payment">Pembayaran</a></li>
                            <li><a href="<?=base_url();?>config">Pengaturan</a></li>

                            <?php
                            echo "<li><a href='#' class='highlighted'>".$this->session->userdata('username')."</a></li>
                            <li><a href='#' data-toggle='modal' data-target='#profilModal'><i class='fa fa-user' title='Reset Password'></i></a></li>
                            <li><a href='".base_url()."login/logout' title='Logout'><i class='fa fa-sign-out'></i></a></li>";
                            ?>

                        </ul>
                    </div>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="profilModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="defModalHead">Reset Password User</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url(); ?>login/updatepassword" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $this->session->userdata('id'); ?>">
                                <div class="form-group">
                                    <label for="current_password">Password Lama</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password1">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password1" name="new_password1" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password2">Ulangi Password Baru</label>
                                    <input type="password" class="form-control" id="new_password2" name="new_password2" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Ganti Password</button>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Reset Password</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- END OF MODAL -->
            <!-- END NAVIGATIONS -->            

            