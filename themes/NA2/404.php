<?php get_header(); ?>
<div id="main" class="container mb-50">
  <div class="row">
    <div class="eight columns">
      <h1 class="p404 centerTxt nmb">404</h1>
      <h1 class="centerTxt">الصفحة المطلوبه غير موجوده<br>يبدو انك تائه, <strong class="green">اتصل بنا للمساعدة الان!</strong></h1>
    </div>
    <div class="four columns">
      <div class="helpline" itemscope itemtype="http://schema.org/Organization">
        <h3 class="mb-10"><?php echo get_option( 'na_hbtitle' ); ?></h3>
        <p class="large mb-10">
          <a href="tel:<?php echo get_option( 'na_hbline1' ); ?>" itemprop="telephone"><?php echo get_option( 'na_hbline1' ); ?></a><br>
          <a href="tel:<?php echo get_option( 'na_hbline2' ); ?>" itemprop="telephone"><?php echo get_option( 'na_hbline2' ); ?></a>
        </p>
        <small><?php echo get_option( 'na_hbtime' ); ?></small>
        <p class="nmb"><a href="mailto:<?php echo get_option( 'na_hbemail' ); ?>" itemprop="email"><?php echo get_option( 'na_hbemail' ); ?></a></p>
      </div> <!-- .helpline -->
    </div>
  </div>
</div> <!-- #main -->
<?php get_footer(); ?>
 