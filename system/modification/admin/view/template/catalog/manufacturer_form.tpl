<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-manufacturer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <div class="checkbox">
                  <label>
                    <?php if (in_array(0, $manufacturer_store)) { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($stores as $store) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($store['store_id'], $manufacturer_store)) { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
              <?php if ($error_keyword) { ?>
              <div class="text-danger"><?php echo $error_keyword; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"> <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if (isset($seo_url_generator_status) && $seo_url_generator_status) { ?><!-- SEO URL Generator.Begin -->
<script type="text/javascript">

  //var seo_url_generator_language = <?php //echo $seo_url_generator_language; ?>;
  var seo_url_generator_language = ''; // no languages varians

  <?php if(stristr($_GET['route'], 'add')) { ?>

  $('#input-name').change(function(){ generateUrlOnAdd(); });

  function generateUrlOnAdd() {
    data = {
      //name       : $('#input-name').val(),
      name       : $('#input-name').val(),
      essence    : 'manufacturer',
      essence_id : ''
    };

    getSeoUrl(data);
  }

  <?php } else { ?>
  
  // enque button #generateUrlOnEdit
  var html = '';
  html += '<br><button id="generateUrlOnEdit" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i> <?php echo $sug_button_generate; ?></button>';

  $('#input-keyword').after(html);

  // enque redirects #generateUrlOnEdit
  var html = '';
  html += '<div class="form-group">';
  html += '<label class="col-sm-2 control-label"><?php echo $sug_text_redirects; ?></label>';
  html += '<!-- manufacturer-redirects . begin -->';
  html += '<div class="col-sm-10">';
  html += '<div class="alert alert-info alert-sm"><?php echo $sug_help_redirects; ?></div>';
  html += '<div id="seo_url_generator_redirects">';
  <?php $redirect_row = 0; ?>
  <?php foreach ($redirects as $key => $redirect) { ?>
  html += '<div id="redirect-row-<?php echo $redirect_row; ?>" class="row redirect-row" style="margin: 10px 0;"><input type="text" name="seo_url_generator_redirects[<?php echo $key; ?>]" value="<?php echo $redirect; ?>" class="form-control input-sm col-xs-10" style="width: 100%; width: calc(100% - 120px); <?php echo (isset($error_seo_url_generator_redirects[$key])) ?	'border-color: red;' : ''; ?>" /><div class="col-xs-1"><i class="pull-left fa fa-close text-danger deleteRedirect" style="cursor: pointer;" data-toggle="tooltip" title="<?php echo $sug_button_delete_redirect; ?>"></i></div></div>';
  <?php $redirect_row++; ?>
  <?php } ?>	
  html += '</div>';
  html += '<!-- /manufacturer-redirects . end -->';
  html += '<button id="addNewRedirect" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> <?php echo $sug_button_add_redirect; ?></button>';
  html += '</div>';
  html += '</div>';	
  
	<!-- Front works properly mark -->
  html += '<input type="hidden" name="seo_url_generator_front_works" />';
  
  $('#generateUrlOnEdit').parent().parent().after(html);

  $('#generateUrlOnEdit').click(function(e) {
    e.preventDefault();

    data = {
      //name       : $('#input-name' + seo_url_generator_language).val(),
      name       : $('#input-name').val(),
      essence    : 'manufacturer',
      essence_id : <?php echo $_GET['manufacturer_id']; ?>
    };

    getSeoUrl(data);
  });
  
  var redirectRow = <?php echo $redirect_row; ?>;
  
  $('#addNewRedirect').click(function(e) {
    e.preventDefault();
    
    $('#seo_url_generator_redirects').append('<div id="redirect-row-' + redirectRow + '" class="row redirect-row recent" style="margin: 10px 0;"><input type="text" name="seo_url_generator_redirects[]" value="" class="form-control input-sm col-xs-10" style="width: 100%; width: calc(100% - 120px);" /><div class="col-xs-1"><i class="pull-left fa fa-close text-danger deleteRedirect" style="cursor: pointer;" data-toggle="tooltip" title="<?php echo $sug_button_delete_redirect; ?>"></i></div></div>');
    
    redirectRow++;
  });
  
  $('body').on('click', '.deleteRedirect', function(e) {
    e.preventDefault();		
		$('#sug-btn-confirm').attr('data-target', '#' + $(this).parent().parent('.redirect-row').attr('id'));		
		$('#sug-confirm').modal('toggle');    
  });

  $('body').on('click', '#sug-btn-confirm', function(e) {
    e.preventDefault();		
		$($(this).attr('data-target')).remove();		
		$('#sug-confirm').modal('toggle');
  });

  <?php } ?>

  function getSeoUrl(data) {
    $.ajax({
      url: 'index.php?route=module/seo_url_generator/generateSeoUrlByAjax&token=<?php echo $token; ?>',
      dataType: 'json',
      data: data,
      method : 'POST',
      beforeSend: function() {
      },
      success: function(response, textStatus, jqXHR) {
        // success ajax query
        if(response.result != '') {
          <?php if (isset($_GET['manufacturer_id'])) { ?>
          if ('' != $('#input-keyword').val().trim() && $('#input-keyword').val() != response.result) {
            $('#seo_url_generator_redirects').append('<div id="redirect-row-' + redirectRow + '" class="row redirect-row recent" style="margin: 10px 0;"><input type="text" name="seo_url_generator_redirects[]" value="' + $('#input-keyword').val() + '" class="form-control input-sm col-xs-10" style="width: 100%; width: calc(100% - 120px);" /><div class="col-xs-1"><i class="pull-left fa fa-close text-danger deleteRedirect" style="cursor: pointer;" data-toggle="tooltip" title="<?php echo $sug_button_delete_redirect; ?>"></i></div></div>');
            
            redirectRow++;
          }
          <?php } ?>
          
          setTimeout(function() {
            $('#input-keyword').val(response.result);
          }, 100);
          
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Error ajax query
        console.log('AJAX query Error: ' + textStatus);
      },
      complete: function() {
      },
    });
  }
		
	// Prevent incorrect SEO URL!
	var inputBorderColorInitial = false;
	
	$('body').on('change', '.redirect-row input', function(e) {
		if (!inputBorderColorInitial) {
			inputBorderColorInitial = $(this).css('border-color');
		}
		
		// reset previous errors
		$(this).css('border-color', inputBorderColorInitial);
		
		$('#sug-error-body').html('');
		
		let hasError = false;
		
		// Check inputed data		
		if ($(this).val().trim() == '') {
			hasError = true;
			$('#sug-error-body').append('<p class="text-danger"><b><?php echo $sug_redirects_error_empty; ?></b></p>');
		}

		if ($(this).val().includes('/')) {
			hasError = true;
			$('#sug-error-body').append('<p class="text-danger"><b><?php echo $sug_redirects_error_slash; ?></b></p>');
		}
		
		if ($(this).val().includes('http')) {
			hasError = true;
			$('#sug-error-body').append('<p class="text-danger"><b><?php echo $sug_redirects_error_protocol; ?></b></p>');
		}
		
		if ($(this).val().includes('.html')) {
			hasError = true;
			$('#sug-error-body').append('<p class="text-warning"><b><?php echo $sug_redirects_error_html; ?></b></p>');
		}
		
		if (hasError) {
			$(this).css('border-color', 'red');
			
			$('#sug-error-body').append('<p class="alert alert-info"><i class="fa fa-info-circle" style="font-size: 1.5em;">&nbsp;</i>  <?php echo $sug_redirects_error_common; ?></p>');
			
			$('#sug-error').modal('toggle');
		}
		
    console.log('hasError : ' + hasError);
    console.log($(this).val());
		
		
  });
	
</script>
<!-- Confirm Modal -->
<div class="modal fade" id="sug-confirm" tabindex="-1" role="dialog" aria-labelledby="sug-confirm" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-warning" id="sug-confirm-title"><i class="fa fa-exclamation-triangle">&nbsp;</i> <b><?php echo $sug_confirm_title; ?></b></h4>
			</div>
			<div class="modal-body">
				<?php echo $sug_confirm_body; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger sug-btn-confirm" id="sug-btn-confirm" data-target=""><i class="fa fa-trash">&nbsp;</i> <?php echo $sug_confirm_btn_yes; ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $sug_confirm_btn_no; ?></button>
			</div>
		</div>
	</div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="sug-error" tabindex="-1" role="dialog" aria-labelledby="sug-error" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-danger" id="sug-error-title"><i class="fa fa-exclamation-triangle">&nbsp;</i> <b><?php echo $sug_redirects_error_title; ?></b></h4>
			</div>
			<div class="modal-body" id="sug-error-body"></div>
		</div>
	</div>
</div> 

<!-- SEO URL Generator.End --><?php } ?>

<?php echo $footer; ?>