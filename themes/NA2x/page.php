<?php get_header(); ?>
<div id="main" class="container mb-50">
  <div id="body" class="nine columns">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1 class="mb-10"><?php the_title(); ?></h1>
    		<?php the_content(); ?>
    		<?php if ( is_page('for-the-public') ) { ?>
    		<!-- Begin MailChimp Signup Form -->
    		<div id="mc_embed_signup" style="overflow: hidden !important;">
    		<form action="//naegypt.us12.list-manage.com/subscribe/post?u=0bf36a47fb8c59cc84ecc7751&amp;id=0b4acc28ea" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    		    <div id="mc_embed_signup_scroll">
    			<h2>Subscribe to our mailing list</h2>
    		<div class="mc-field-group">
    			<label for="mce-EMAIL">Email Address </label>
    			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
    		</div>
    			<div id="mce-responses" class="clear">
    				<div class="response" id="mce-error-response" style="display:none"></div>
    				<div class="response" id="mce-success-response" style="display:none"></div>
    			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    		    <div style="position: absolute; left: -5000px; display: none" aria-hidden="true"><input type="text" name="b_0bf36a47fb8c59cc84ecc7751_0b4acc28ea" tabindex="-1" value=""></div>
    		    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    		    </div>
    		</form>
    		</div>
    		<!--End mc_embed_signup-->
    		<?php } wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    	<?php endwhile; endif; ?>
  </div> <!-- #body -->
  <?php get_sidebar(); ?>
</div> <!-- #main -->
<?php get_footer(); ?>
