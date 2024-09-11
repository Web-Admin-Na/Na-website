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
    <!--<div id="event-map"></div>

	  <script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: "AIzaSyAJ15C_GQbFUD1oqhVSZQDsVamHRoPkmhE",
    v: "weekly",
    // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
    // Add other bootstrap parameters as needed, using camel case.
  });
</script>
    <script type="text/javascript">
	let map;
      async function initMap() {

		const { Map } = await google.maps.importLibrary("maps");
      map = new Map(document.getElementById('event-map'), { 
	  	zoom: 17,
        center: {lat: <?php echo get_post_meta( get_the_ID(), 'event_lat', true ); ?>, lng: <?php echo get_post_meta( get_the_ID(), 'event_long', true ); ?> },
	  });

     
      }
      //google.maps.event.addDomListener(window, 'load', initMap);
      initMap();
    </script>-->
    <?php endwhile; endif; ?>
  </div> <!-- #body -->
  <?php get_sidebar(); ?>
</div> <!-- #main -->
<?php get_footer(); ?>
