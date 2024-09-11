<?php
$dir = 'rtl';
$css_file = 'style';
$logo = 'logo';
if (ICL_LANGUAGE_CODE == 'en') {
    $dir = 'ltr';
    $css_file = 'ltr';
    $logo = 'logo-en';
}
?>
<!DOCTYPE html>
<html lang="<?php echo ICL_LANGUAGE_CODE; ?>" dir="<?php echo $dir; ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/skeleton.css">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/<?php echo $css_file; ?>.css">
    <!-- <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/style.css"> -->
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/scripts/slicknav/slicknav.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <!-- <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <!-- <link rel="icon" type="image/png" href="images/favicon.png"> -->
    <?php // wp_head(); 
    ?>
    <script src="https://kit.fontawesome.com/6a045e7802.js" crossorigin="anonymous"></script>
</head>

<body <?php body_class($class); ?>>
    <?php if (!is_page_template('gadmin.php')) { ?>
        <header>
            <div class="container">
                <a href="http://naegypt.org/en/" class="lang">English</a>
                <a href="https://www.facebook.com/NAEgyptUnofficialPage" class="fbIcon" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/fb.png"></a>
                <div class="row">
                    <div id="logo" class="four columns">
                        <a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/<?php echo $logo; ?>.png" alt=""></a>
                    </div> <!-- #logo -->
                    <div id="mainNav" class="eight columns">
                        <?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'nav', 'container_id' => 'navigation', 'menu_id' => 'dropmenu')); ?>
                    </div> <!-- #mainNav -->
                </div>
            </div> <!-- .container -->
        </header>
        <div id="banner" class="mb-50">
            <div class="container">
                <h2><?php _e('نحن بالفعل نتعافي!', 'NA'); ?></h2>
            </div>
        </div> <!-- #banner -->
    <?php
        $ynote = get_field('ynote', 'option');
        if (!empty($ynote)) echo '<div class="container alertbox mb-50"><p class="nmb">' . $ynote . '</p></div> <!-- .alertbox -->';
    } else { ?>
    <br>
        <center><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/<?php echo $logo; ?>.png" alt=""></a>
        <br><br>
        <h1>ادارة اجتماعات المجموعة</h1></center>
    <?php  } ?>