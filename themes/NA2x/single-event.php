<?php get_header(); ?>
<div id="main" class="container mb-50">
  <div id="body" class="nine columns">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <h1 class="mb-10"><?php the_title(); ?></h1>
    <p class="meta"><?php echo get_post_meta( get_the_ID(), 'event_date', true ); ?>
      - <?php echo get_post_meta( get_the_ID(), 'event_location', true ); ?></p>
    <?php the_content(); ?>
    <?php
      $event_form = get_post_meta( get_the_ID(), 'event_form', true );
      if ( !empty( $event_form ) ) echo '<a href="'.$event_form.'" class="btn paige medium mt-20">Register Now!</a>';
    ?>
    <div id="event-map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script type="text/javascript">
      function initialize() {
        var myLatlng = new google.maps.LatLng(<?php echo get_post_meta( get_the_ID(), 'event_lat', true ); ?>, <?php echo get_post_meta( get_the_ID(), 'event_long', true ); ?>);
        var mapOptions = {
        zoom: 15,
        center: myLatlng
      }
      var map = new google.maps.Map(document.getElementById('event-map'), mapOptions);

      var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: '<?php echo get_post_meta( get_the_ID(), "event_location", true ); ?>'
        });
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <?php endwhile; endif; ?>
  </div> <!-- #body -->
  <?php get_sidebar(); ?>
</div> <!-- #main -->
<?php get_footer(); ?>
