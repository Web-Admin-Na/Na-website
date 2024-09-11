<?php
  $dir = 'rtl';
  $css_file = 'style';
  $logo = 'logo';
  if( ICL_LANGUAGE_CODE == 'en' ) {
    $dir = 'ltr';
    $css_file = 'ltr';
    $logo = 'logo-en';
  }
?>
<!DOCTYPE html>
<html lang="<?php echo ICL_LANGUAGE_CODE; ?>" dir="<?php echo $dir; ?>">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/normalize.css">
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/skeleton.css">
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/<?php echo $css_file; ?>.css">
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/scripts/slicknav/slicknav.min.css" />
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/print.css" media="print" />
	 <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" /> 
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js" defer></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
  <link rel="icon" type="image/png" href="https://naegypt.org/wp-content/uploads/2024/02/na-site-logo-150x150-1.png">
  <meta name="google-site-verification" content="MxrOefke71Ductb1d645KBk4E8pYXuIXYZNx1pdV7nU" />
  <script src="https://kit.fontawesome.com/6a045e7802.js" crossorigin="anonymous"></script>
	<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
  <?php wp_head(); ?>
</head>
<body <?php body_class( $class ); ?>>
  <header>
    <div class="container">
		<div class="row">
		<div class="row">
        <div id="logo" class="four columns">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="https://naegypt.org/wp-content/uploads/2024/03/sourcee.png" alt="زمالة المدمنين المجهولين - مصر" />
			</a>
        </div> <!-- #logo -->
        <div id="mainNav" class="six columns">
          <?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'mainNav', 'container_id' => 'navigation', 'menu_id' => 'dropmenu')); ?>
        </div> <!-- #mainNav -->
      </div>
	<div class="row">
      <a href="https://www.facebook.com/OfficialNAEgyPage/" class="fbIcon" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/fb.png" ></a>
		</div>
    </div> <!-- .container -->
  </header>
  <div id="banner" class="mb-50">
    <div class="container"><!--<h2><?php _e('We do Recover!','NA'); ?></h2>--></div>
  </div> <!-- #banner -->
  <?php
    $ynote = get_field( 'ynote', 'option' );
    if( !empty( $ynote ) ) echo '<div class="container alertbox mb-50"><p class="nmb">'.$ynote.'</p></div> <!-- .alertbox -->';
  ?>
