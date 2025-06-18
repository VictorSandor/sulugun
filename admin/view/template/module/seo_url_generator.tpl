<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form_seo_url_generator" data-toggle="tooltip" title="<?php echo $button_save_settings; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save_settings; ?></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-warning"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div><!-- /page-header -->
  <div class="container-fluid">
    <?php if (isset($errors['warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $errors['warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (isset($text_success) && $text_success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $text_success; ?></div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-cogs"></i> <?php echo $text_part_settings; ?></span>
      </div>

      <!-- Customization.Begin -->
      <!-- Loader icon -->
      <link href="view/stylesheet/load-bar.css" type="text/css" rel="stylesheet" media="screen" />
      <!-- custom syle -->

      <div class="panel-body">
        
        <div class="module-navigation">
          <a class="btn btn-default navbar-btn active" href="<?php echo $link_part_settings; ?>"><?php echo $text_part_settings; ?></a>
          <a class="btn btn-default navbar-btn" href="<?php echo $link_part_info; ?>"><i class="fa fa-info-circle"></i> <?php echo $text_part_info; ?> >>></a>
        </div>
				<hr>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form_seo_url_generator" class="form-horizontal">

          <div id="module-work-area">
            <!-- Settings
            =========================================================================== -->
            <fieldset style="border: 1px dashed #ccc; padding: 10px 0; margin-bottom: 20px;">
              <h3 style="margin-left: 10px;"><?php echo $fieldset_base; ?></h3>
              <!-- status -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label class="col-sm-2 control-label" for="input_status"><?php echo $entry_status; ?>:</label>
                <div class="col-sm-2">
                  <select name="status" id="input_status" class="form-control">
                    <?php if ($status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <hr />
              <!-- system -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label class="col-sm-2 control-label" for="input_system"><?php echo $entry_system; ?>:</label>
                <div class="col-sm-2">
                  <select name="system" id="input_system" class="form-control">
                    <?php foreach ($systems as $system_item) { ?>
                    <option value="<?php echo $system_item; ?>" <?php echo $system_item == $system ? 'selected' : ''; ?>><?php echo $system_item; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <hr />
              <!-- debug -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label class="col-sm-2 control-label" for="input_debug" style="padding-top: 0px;"><span data-toggle="tooltip" title="<?php echo $help_debug; ?>"><?php echo $entry_debug; ?>:</span></label>
                <div class="col-sm-2">
                  <select name="debug" id="input_debug" class="form-control">
                    <?php foreach ($debug_levels as $debug_item_key => $debug_item_value) { ?>
                      <option value="<?php echo $debug_item_key; ?>" <?php echo $debug_item_key == $debug ? 'selected' : ''; ?>><?php echo $debug_item_value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </fieldset>

            <!-- Translit
            =========================================================================== -->
            <fieldset style="border: 1px dashed #ccc; padding: 10px 0; margin-bottom: 20px;">
              <h3 style="margin-left: 10px;"><?php echo $fieldset_translit; ?></h3>
							<div class="row">
								<!-- translit . left column -->
								<div class="col-sm-6">
									<!-- language ID -->
									<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
										<label class="col-sm-4 control-label" for="input_language_id"><?php echo $entry_language_id; ?>:</label>
										<div class="col-sm-6">
											<select name="language" id="input_language_id" class="form-control">
												<?php if ($language) { ?>
												<?php foreach ($languages as $language_item) { ?><option value="<?php echo $language_item['language_id']; ?>" <?php echo $language == $language_item['language_id'] ? 'selected' : ''; ?>><?php echo $language_item['name']; ?></option>
												<?php } ?>
												<?php } else { ?>
												<?php foreach ($languages as $this_language_code => $language_item) { ?><option value="<?php echo $language_item['language_id']; ?>" <?php echo $config_language_code == $this_language_code ? 'selected' : ''; ?>><?php echo $language_item['name']; ?></option><?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<hr />
									<!-- translit_function -->
									<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
										<label class="col-sm-4 control-label" for="input_translit_function"><?php echo $entry_translit_function; ?>:</label>
										<div class="col-sm-6">
											<select name="translit_function" id="input_translit_function" class="form-control">
												<?php foreach ($translit_functions as $key => $translit_function_item) { ?>
													<option value="<?php echo $key; ?>" <?php echo $translit_function == $key ? 'selected' : ''; ?>><?php echo $translit_function_item; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<hr />
									<!-- delimiter_char -->
									<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
										<label class="col-sm-4 control-label" for="input_delimiter_char"><span data-toggle="tooltip" title="<?php echo $help_delimiter_char; ?>"><?php echo $entry_delimiter_char; ?>:</span></label>
										<div class="col-sm-6">
											<select name="delimiter_char" id="input_delimiter_char" class="form-control">
												<?php foreach ($delimiter_chars as $key => $delimiter_char_item) { ?>
													<option value="<?php echo $key; ?>" <?php echo $delimiter_char == $key ? 'selected' : ''; ?>><?php echo $delimiter_char_item; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<hr />
									<!-- change_delimiter_char -->
									<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
										<label class="col-sm-4 control-label" for="input_change_delimiter_char" style="padding-top: 0px;"><span data-toggle="tooltip" title="<?php echo $help_change_delimiter_char; ?>"><?php echo $entry_change_delimiter_char; ?>:</span></label>
										<div class="col-sm-6">
											<select name="change_delimiter_char" id="input_change_delimiter_char" class="form-control">
												<?php foreach ($change_delimiter_chars as $key => $change_delimiter_char_item) { ?>
													<option value="<?php echo $key; ?>" <?php echo $change_delimiter_char == $key ? 'selected' : ''; ?>><?php echo $change_delimiter_char_item; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<hr />
									<!-- rewrite_on_save -->
									<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
										<label class="col-sm-4 control-label" for="input_rewrite_on_save" style="padding-top: 0px;"><span data-toggle="tooltip" title="<?php echo $help_rewrite_on_save; ?>"><?php echo $entry_rewrite_on_save; ?>:</span></label>
										<div class="col-sm-6">
											<select name="rewrite_on_save" id="input_rewrite_on_save" class="form-control">
												<?php if ($rewrite_on_save) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<!-- translit . right column -->
								<div class="col-sm-6">
									<div class="row" style="margin-right: 10px;">
										<div class="col-sm-12">
											<h4><?php echo $title_custom_replace; ?></h4>
											<div class="alert alert-warning" style="margin-bottom: 0;"><i class="fa fa-exclamation-triangle">&nbsp;</i><?php echo $help_custom_replace; ?></div>
										</div>
									</div>
									<div class="row" style="margin-right: 10px;">
										<div class="col-sm-6" style="padding-top: 5px; padding-bottom: 5px;">
											<label for="input_custom_replace_from" class="control-label"><?php echo $entry_custom_replace_from; ?>:</label>
											<div class="">
												<textarea id="input_custom_replace_from" type="text" name="custom_replace_from" class="form-control" style="height: 250px;"><?php if (isset($custom_replace_from_array) && count($custom_replace_from_array) > 0) { $i=1; foreach ($custom_replace_from_array as $value) { if ($i>1) { echo "\r\n"; } echo $value; $i++; } } ?></textarea>
											</div>
										</div>
										<div class="col-sm-6" style="padding-top: 5px; padding-bottom: 5px; border-top: none;">
											<label for="input_custom_replace_to" class="control-label"><?php echo $entry_custom_replace_to; ?>:</label>
											<div class="">
												<textarea id="input_custom_replace_to" type="text" name="custom_replace_to" class="form-control" style="height: 250px;"><?php if (isset($custom_replace_to_array) && count($custom_replace_to_array) > 0) { $i=1; foreach ($custom_replace_to_array as $value)  {if ($i>1) { echo "\r\n"; } echo $value; $i++; } } ?></textarea>
												<?php if (isset($errors['custom_replace_to'])) { ?><div class="text-danger"><?php echo $errors['custom_replace_to']; ?></div><?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>				
            </fieldset>

            <!-- Formulas
            =========================================================================== -->
            <fieldset style="border: 1px dashed #ccc; padding: 10px 0; margin-bottom: 20px;">
              <h3 style="margin-left: 10px;"><?php echo $fieldset_formulas; ?></h3>
              <!-- category formula -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label for="input_category_formula" class="col-sm-2 control-label"><?php echo $entry_category_formula; ?>:</label>
                <div class="col-sm-4">
                  <input id="input_category_formula" type="text" name="category_formula" value="<?php echo isset($category_formula) ? $category_formula : ''; ?>" class="form-control" />
                  <i><?php echo $text_available_vars; ?>:</i> <b>[category_name]</b><i>,</i> <b>[category_id]</b>
									<br>
									<br>
									<i><?php echo $help_vars; ?></i>
									<br>
									<b>[category_name]-[category_id]</b>
									<br>
									<i><?php echo $or; ?></i>
									<br>
									<b>[category_name]_[category_id]</b>
                  <?php if (isset($errors['category_formula'])) { ?><div class="text-danger"><?php echo $errors['category_formula']; ?></div><?php } ?>
                </div>
              </div>
              <hr />

              <!-- product formula -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label for="input_product_formula" class="col-sm-2 control-label"><?php echo $entry_product_formula; ?>:</label>
                <div class="col-sm-4">
                  <input id="input_product_formula"	type="text" name="product_formula" value="<?php echo isset($product_formula) ? $product_formula : ''; ?>" class="form-control" />
                  <i><?php echo $text_available_vars; ?>:</i> <b>[product_name]</b><i>,</i> <b>[model]</b><i>,</i> <b>[sku]</b><i>,</i> <b>[manufacturer_name]</b><i>,</i> <b>[product_id]</b>
									<br>
									<br>
									<i><?php echo $help_vars; ?></i>
									<br>
									<b>[product_name]-[product_id]</b>
									<br>
									<i><?php echo $or; ?></i>
									<br>
									<b>[product_name]_[manufacturer_name]_[sku]</b>
                  <?php if (isset($errors['product_formula'])) { ?><div class="text-danger"><?php echo $errors['product_formula']; ?></div><?php } ?>
                </div>
              </div>
              <hr />

              <!-- manufacturer formula -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label for="input_manufacturer_formula" class="col-sm-2 control-label"><?php echo $entry_manufacturer_formula; ?>:</label>
                <div class="col-sm-4">
                  <input id="input_manufacturer_formula" type="text" name="manufacturer_formula" value="<?php echo isset($manufacturer_formula) ? $manufacturer_formula : ''; ?>" class="form-control" />
                  <i><?php echo $text_available_vars; ?>:</i> <b>[manufacturer_name]</b><i>,</i> <b>[manufacturer_id]</b>
									<br>
									<br>
									<i><?php echo $help_vars; ?></i>
									<br>
									<b>[manufacturer_name]-[manufacturer_id]</b>
									<br>
									<i><?php echo $or; ?></i>
									<br>
									<b>[manufacturer_name]_[manufacturer_id]</b>
                  <?php if (isset($errors['manufacturer_formula'])) { ?><div class="text-danger"><?php echo $errors['manufacturer_formula']; ?></div><?php } ?>
                </div>
              </div>
              <hr />

              <!-- information formula -->
              <div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
                <label for="input_information_formula" class="col-sm-2 control-label"><?php echo $entry_information_formula; ?>:</label>
                <div class="col-sm-4">
                  <input id="input_information_formula"	type="text" name="information_formula" value="<?php echo isset($information_formula) ? $information_formula : ''; ?>" class="form-control" />
                  <i><?php echo $text_available_vars; ?>:</i> <b>[information_title]</b><i>,</i> <b>[information_id]</b>
									<br>
									<br>
									<i><?php echo $help_vars; ?></i>
									<br>
									<b>[information_title]-[information_id]</b>
									<br>
									<i><?php echo $or; ?></i>
									<br>
									<b>[information_title]_[information_id]</b>
                  <?php if (isset($errors['information_formula'])) { ?><div class="text-danger"><?php echo $errors['information_formula']; ?></div><?php } ?>
                </div>
              </div>
            </fieldset>

            <button type="submit" form="form_seo_url_generator" data-toggle="tooltip" title="<?php echo $button_save_settings; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save_settings; ?></button>

          </div> <!-- /module-work-area -->
        </form>
      </div><!-- /panel-body-->
      <!-- /Customization.End -->



    </div><!-- /panel-default-->

    <div class="copywrite" style="padding: 10px 10px 0 10px; border: 1px dashed #ccc;">
      <p>
        &copy; <?php echo $text_author; ?>: <a href="http://bit.ly/3I9sILk" target="_blank">Serge Tkach</a>
        <br/>
        <?php echo $text_author_support; ?>: <a href="mailto:sergetkach.help@gmail.com">sergetkach.help@gmail.com</a>
      </p>

    </div>

  </div><!-- /container-fluid-->
</div><!-- /content-->
<?php echo $footer; ?>
