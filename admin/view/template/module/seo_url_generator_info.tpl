<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-warning"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <!-- /page-header -->
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-info-circle"></i> <?php echo $text_part_info; ?></span>
      </div>

      <!-- Customization.Begin -->
      <!-- Loader icon -->
      <link href="view/stylesheet/load-bar.css" type="text/css"	rel="stylesheet" media="screen" />
      <!-- custom syle -->
      <style>
        ._relative {
          position: relative; /* for button loading */
        }
      </style>

      <div class="panel-body">

        <div class="module-navigation">
          <a class="btn btn-default navbar-btn" href="<?php echo $link_part_settings; ?>"><i class="fa fa-cogs"></i> <?php echo $text_part_settings; ?></a>
          <a class="btn btn-default navbar-btn active" href="<?php echo $link_part_info; ?>"><?php echo $text_part_info; ?></a>
        </div>
        <hr>

				<h2><?php echo $text_about_title; ?></h2>
				<?php echo $text_about; ?>
				<hr>
				<h2><?php echo $text_about_pro_title; ?></h2>
				<?php echo $text_about_pro; ?>

                      </div>
      <!-- /panel-body-->
      <!-- /Customization.End -->



    </div>
    <!-- /panel-default-->

    <div class="copywrite" style="padding: 10px 10px 0 10px; border: 1px dashed #ccc;">
      <p>&copy; <?php echo $text_author; ?>: <a href="http://bit.ly/3I9sILk" target="_blank">Serge Tkach</a>
        <br />
        <?php echo $text_author_support; ?>: <a href="mailto:sergetkach.help@gmail.com">sergetkach.help@gmail.com</a>
      </p>
    </div>

  </div>
  <!-- /container-fluid-->
</div>
<!-- /content-->

<script>
<?php echo $footer; ?>
