<input type="hiddens" id="bundle_id" value="<?= $bundle_id; ?>" />

<!-- BANNER -->
<div id="banner" class="banner" style="margin-top:50px!important">

  <div class="row" style="margin:0!important">
    <div class="col-lg-2 col-md-2 col-xs-12" style="text-align:right;">
      <img src="<?= $this->config->item('img_path'); ?>bundle-icon/<?= $bundle_row['icon2']; ?>" />
    </div>
    <div class="col-lg-10 col-md-10 col-xs-12">
      <div class="row" id="income-global-info">
        <div id="loader-income-global-info" align="center" style="display:none;margin-top:100px;">
          <img src="<?= $this->config->item('img_path'); ?>ajax-loaders/ajax-loader-1.gif" />
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  base_url = $('#base_url').val();
  menu = $('#menu').val();
  data_ajax = ['bundle_id=' + $('#bundle_id').val()];

  function load_banner_info() {

    if (menu != 'general_info') {

      ajax_object.reset_object();
      ajax_object
        .set_url(base_url + 'glob/get_banner_info')
        .set_loading('#loader-income-global-info')
        .set_content('#income-global-info')
        .set_data_ajax(data_ajax)
        .request_ajax();
    }

  }

  $(window).load(function() {
    load_banner_info();
  });
</script>