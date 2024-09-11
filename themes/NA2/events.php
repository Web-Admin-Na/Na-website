<?php
/**
 * Template Name: Events
 */
get_header(); ?>

<div id="main" class="container mb-50">
  <div id="body" class="nine columns">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 class="mb-10"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; endif; ?>
    <!-- start events -->
    <?php
      $e_args = array(
      "post_type" => "event"
      );
      $e_query = new WP_Query( $e_args );
      if ( $e_query->have_posts() ) :
      while ($e_query->have_posts()) : $e_query->the_post();
    ?>
    <div class="event_post">
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <p class="meta"><?php echo get_post_meta( get_the_ID(), 'event_date', true ); ?> - <?php echo get_post_meta( get_the_ID(), 'event_location', true ); ?></p>
      <?php the_excerpt(); ?>
    </div>
    <?php endwhile; endif;  ?>
    <!-- end events -->
  </div> <!-- #body -->
  <?php get_sidebar(); ?>
</div> <!-- #main -->
<?php get_footer(); ?>
