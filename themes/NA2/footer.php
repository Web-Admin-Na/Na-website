<footer>
  <div class="container">
    <div class="copyrights six columns">
    <?php echo  _e('NA Egypt.org, All copyrights reserved', 'NA'); ?> &copy; <?php echo date('Y');?> 
    <!-- <a href="http://naegypt.org/terms-conditions/">Terms &amp; Conditions</a> - <a href="http://naegypt.org/privacy-policy/">Privacy Policy</a>--></div>
    <!-- <div class="credits six columns">Designed &amp; Developed by <a href="http://mspired.com/" class="mspired" target="_blank">MSPIRED</a></div> -->
  </div>
</footer>
<!-- meetings page only -->
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/scripts/filter.js" type="text/javascript"></script>
<script type="text/javascript">
	$('.meetings-table tr.single_meeting').click( function(e){
		var id = $( this ).attr( 'id' );
		$('#detail'+id).toggle();
	} );
</script>
<!-- ### -->
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/scripts/slicknav/jquery.slicknav.min.js"></script>
<script>
    <?php if(!is_page_template( 'gadmin.php' )) { ?>
	 jQuery(document).ready(function(){
        jQuery('#mainNav ul').slicknav( { label: '<?php _e("Menu", "NA"); ?>' } );
    });
    <?php } ?>
</script>
<?php wp_footer(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-1368042-19', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
