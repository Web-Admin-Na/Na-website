<?php
/**
 * Template Name: Full Page
 */
get_header(); ?>
<div id="main" class="container mb-50">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 class="mb-10"><?php the_title(); ?></h1>
  		<?php the_content(); ?>
  		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
  	<?php endwhile; endif; ?>
</div> <!-- #main -->
<?php get_footer(); ?>
