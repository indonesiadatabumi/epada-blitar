<link href="<?=$this->config->item('css_path');?>jquery.smartmenus.bootstrap.css" rel="stylesheet">
<!-- END BANNER -->
<!-- Navbar -->
<div class="navbar navbar-default" role="navigation" style="margin-bottom:0!important">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><?=$bundle_row['nama_paret'];?></a>
  </div>

  <div class="navbar-collapse collapse">
    <!-- Left nav -->
    <ul class="nav navbar-nav">
      <?php
        $menu_generator->print_tree($parsed_tree,'master',1);
      ?>
    </ul>
  </div><!--/.nav-collapse -->
</div>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="<?=$this->config->item('js_path');?>jquery.smartmenus.js"></script>
<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="<?=$this->config->item('js_path');?>jquery.smartmenus.bootstrap.js"></script>