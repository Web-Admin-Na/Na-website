<?php
/**
 * Template Name: Contact Us
 */
get_header(); ?>
<div id="main" class="container mb-50">
  <div id="body" class="nine columns">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <h1 class="mb-10"><?php the_title(); ?></h1>
    <?php the_content(); ?>
    <?php endwhile; endif; ?>
    <hr class="mb-40 mt-20">
    <?php
      if( isset( $_POST['contactSubmit'] ) ) {
        $name = $_POST['cname'];
        // $phone = $_POST['cphone'];
        $email = $_POST['cemail'];
        $message = $_POST['cmessage'];
        if ( !empty( $name ) && !empty( $email ) && !empty( $message ) ) {
          $headers = 'From: '.$name.' <'.$email.'>' . "\r\n";
          $sent = wp_mail( 'pr@naegypt.org', 'NAEgypt.org - '.$name.' sent a message', $message, $headers, $attachments );
          if( $sent ) echo "<p class='success'>Your mail was sent succeffuly. We will get back to you soon.</p>";
          else echo "<p class='error'>Something went wrong, please try again!</p>";
        } else echo "<p class='error'>Error, please fill in all the required fields!</p>";
      }
    ?>
    <form class="contactus" method="post" action="">
      <p>
        <label>الاسم *</label>
        <input type="text" name="cname" required>
      </p>
      <!-- <p>
        <label>Your Mobile</label>
        <input type="text" name="cphone">
      </p> -->
      <p>
        <label>البريد الالكتروني *</label>
        <input type="email" name="cemail" required>
      </p>
      <p>
        <label>رسالتك *</label>
        <textarea name="cmessage" required></textarea>
      </p>
      <input class="btn medium blue" type="submit" name="contactSubmit" value="ارسال">
      <p><em>* حقول مطلوبه</em></p>
    </form>
  </div> <!-- #body -->
  <?php get_sidebar(); ?>
</div> <!-- #main -->
<?php get_footer(); ?>
