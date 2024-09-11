<?php
/**
 * Template Name: Meetings
 */
get_header(); ?>
<div id="main" class="container mb-30">
    <h2 class="mb-10"><?php the_title(); ?></h2>

    <div id="meetings_filters" class="mb-30">
      <h4><?php _e('Filter by','NA'); ?></h4>
    	<div class="row" style="overflow: visible; height: auto;">
        <div class="two columns">
          <ul class="bl_sort">
            <p class="mb-10"><strong><?php _e('Type','NA'); ?></strong></p>
			  <select id="meetingtype" onchange="document.location = this.value;">
                <option value="#all"><?php _e('All','NA'); ?></option>
      			<option value="#open"><?php _e('Open','NA'); ?></option>
      			<option value="#closed"><?php _e('Closed', 'NA'); ?></option>
      		</select>
			</ul>
        </div>
        <div class="two columns">
          <p class="mb-10"><strong><?php _e('Geographical Area','NA'); ?></strong></p>
      		<ul class="bl_sort">
            <?php
            $cities = get_terms( 'city', array(
                'hide_empty' => false, 'parent' => 0
            ) );

        echo '<select id="out" onchange="document.location = this.value;">';
 		echo '<option value="#all">';
			_e('All','NA');
		echo '</option>';
            foreach( $cities as $city ) {
				echo "<option  value=#".$city->slug.">".$city->name."</option>";
			}
          echo '</select>';

            ?>
				
      		</ul>
        </div>
<div class="two columns">
  <p class="mb-10"><strong><?php _e('اليوم', 'NA'); ?></strong></p>
  <ul class="bl_sort">
    <select id="meetingday" onchange="filterMeetingsByDay(this.value); hideEmptyTables();">
      <option value="all"><?php _e('All', 'NA'); ?></option>
      <option value="السبت"><?php _e('السبت', 'NA'); ?></option>
      <option value="الاحد"><?php _e('الاحد', 'NA'); ?></option>
      <option value="الاثنين"><?php _e('الاثنين', 'NA'); ?></option>
      <option value="الثلاثاء"><?php _e('الثلاثاء', 'NA'); ?></option>
      <option value="الاربعاء"><?php _e('الاربعاء', 'NA'); ?></option>
      <option value="الخميس"><?php _e('الخميس', 'NA'); ?></option>
      <option value="الجمعة"><?php _e('الجمعة', 'NA'); ?></option>
    </select>
  </ul>
</div>
        <div class="two columns">
          <p class="mb-10"><strong><?php _e('Group', 'NA'); ?></strong></p>
			    <ul class="bl_sort">
				<select class="grp" id="group" onchange="document.location = this.value;">
      			<option value="#all"><?php _e('All', 'NA'); ?></option>
      			<?php
      				$g_query = new WP_Query( 'post_type=group&posts_per_page=200&order=DESC' );
      				while ($g_query->have_posts()) : $g_query->the_post();
      			?>
      			<option value="#<?php echo($post->post_name); ?>">
					<?php the_title(); 
					echo '</option>';
      			endwhile; wp_reset_query(); ?>
					</select>
			</ul>
			</div></div>
<div class="row" style="overflow: visible; height: auto;">
<div class="two columns">
<p class="mb-50"><a href="https://naegypt.org/groups-map" target="_blank" class="downloadPDF mt-5"><i class="fa fa-globe"></i> خريطة</a></p>
</div>
<div class="two columns">
        	<p class="mb-50">
				<?php
        		$pdf_download_link = get_post_meta(get_the_ID(), 'pdf_download_link', true);
        		$pdf_download_link = get_field('meeting_file');
        		if( !empty($pdf_download_link) ) echo "<a href='$pdf_download_link' class='downloadPDF mt-20' target='_blank'><strong>تحميل</strong> جدول الاجتماعات</a>";
        		echo "<a href='https://naegypt.org/csv-export/' class='downloadPDF mt-5' target='_blank' title='تحميل الجدول كاملا كملف اكسيل'><i class='fa fa-file-excel'></i> تحميل الجدول</a>";
				?>
			</p>
			
        </div>
<div class="two columns">
<p class="mb-50">
	<?php echo "<a href='https://www.sejda.com/html-to-pdf' id='saveAsPdfBtn' class='downloadPDF mt-5' onclick='window.print();return false;' title='طباعة الجدول او تحميله كملف pdf - يمكنك استخدام فلاتر البحث وطباعة أو تحميل النتائج فقط'><i class='fa fa-print'></i> طباعة الجدول</a>"; ?>
</p>
<script>
document.getElementById('saveAsPdfBtn').addEventListener('click', function(e){
  var pageUrl = encodeURIComponent(window.location.href);
  var opts = ['save-link=' + pageUrl, 'pageOrientation=auto'];
  window.open('https://www.sejda.com/html-to-pdf?' + opts.join('&'));
  e.preventDefault();
});
</script>
</div>
</div>
	<hr>
    <div id="meetings_listing">
        <i class="fa fa-universal-access" title="<?php _e('Accessible', 'NA'); ?>"></i> = <?php _e('Accessible', 'NA'); ?>  | 
        <i class="fa fa-parking" title="<?php _e('Parking available', 'NA'); ?>"></i> = <?php _e('Parking available', 'NA'); ?>  | 
        <i class="fa fa-circle-notch" title="<?php _e('Open meeting', 'NA'); ?>"></i> = <?php _e('Open meeting', 'NA'); ?>  |
        <i class="fa fa-smoking" title="<?php _e('Smoking allowed', 'NA'); ?>"></i> = <?php _e('Smoking allowed', 'NA'); ?>  |
        <i class="fa fa-fire" title="<?php _e('Candle light meeting', 'NA'); ?>"></i> = <?php _e('Candle light meeting', 'NA'); ?>
        <br><hr>
    <?php
    	function get_meetings( $day ) { 
            $day_ar = $day;
            if( ICL_LANGUAGE_CODE == 'en' ) $day = weekday_en( $day );
            ?>
                <!--<h4 id="table_<?php echo strtolower($day); ?>"></h4>-->
    			<table class="meetings-table day-table mb-30 table_<?php echo strtolower($day); ?>">
    				<thead>
						<tr>
							<th colspan="10">
							<?php echo $day; ?> <small><em><?php _e('(for address and other info click on the meeting row)', 'NA'); ?></em></small>
							</th>
						</tr>
    					<tr>
                            <th width="15%"><?php _e('Group','NA'); ?></th>
                            <th width="12%"><?php _e('Geographical Area', 'NA'); ?></th>
                            <th width="10%"><?php _e('City', 'NA'); ?></th>
    						<th colspan="2" width="18%" style="text-align:center;"><?php _e('Time', 'NA'); ?></th>
                            <th width="17%"><?php _e('Topic','NA'); ?></th>
                            <th width="5%" style="text-align:center;"><?php _e('Capacity','NA'); ?></th>
                            <th width="5%" style="text-align:center;"><?php _e('Language','NA'); ?></th>
                            
							<th colspan="2" width="18%" style="text-align:center;"><?php _e('Notes','NA'); ?></th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php
    						$m_args = array(
    							'post_type' => 'meeting',
                                'posts_per_page' => -1,
    							'meta_query' => array(
    								array(
    									'key' => 'day',
    									'value' => $day_ar
    								)
    							)
    						);

    						$m_query = new WP_Query( $m_args );
    						while ($m_query->have_posts()) : $m_query->the_post();

                                $pgroup = get_field('pgroup');
                                if( !ICL_LANGUAGE_CODE) {
                                    $gID_tr = apply_filters('wpml_object_id', $pgroup, 'group', FALSE, 'en');
                                    $pgroup = $gID_tr;
                                }

                                $topic = wp_get_post_terms(get_the_ID(), 'topic');
                                $topic_name = $topic[0]->name;
            
                                $fromf = get_field('from', false, false,false);
                                $from = date("g:i A", strtotime($fromf));
                                $tof = get_field('to', false, false, false);
                                $to = date("g:i A", strtotime($tof));
                
                                $geo = get_meeting_geo( $pgroup);
 								
                                $lang  = get_field('lang');
                                $capacity  = get_field('capacity');
                                $smoking  = get_field('smoking');
                                $accessible  = get_field('accessible');
                                $open  = get_field('open');

                                if( $open ) $open_closed = "open";
                                else $open_closed = "closed";

                                $candle  = get_field('candle');
                                $parking  = get_field('parking');
                                $notes   = get_field('notes');
			// Convert links into links
			$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
			$notes = preg_replace($url, '<a href="$0" target="_blank" title="$0">Link</a>', get_field('notes'));


                                $lat   = get_field('lat', $pgroup);
                                $lng   = get_field('lng', $pgroup);

    							$post_classes = '';

			                    $term_list = get_the_terms($pgroup, 'city');

								foreach ( $term_list as $term ) {
    								$post_classes .= $term->slug." ";
    							}
                                
								$post_classes .= $day." ";
          						$post_classes .= $open_closed." ";
                                
                                $contact_info = get_field('contact_info', $pgroup);

                                $group_post = get_post($pgroup);
    							$post_classes .= $group_post->post_name;

    					?>
    						<tr class="<?php echo $post_classes; ?> single_meeting" id="<?php the_ID(); ?>">
    							<td>
    							<?php
    								echo $group_post->post_title;
    							?>
    							</td>
                                <td><?php echo $geo['area']; ?></td>
                                <td><?php echo $geo['city']; ?></td>
    							<td><?php echo "<span><i class='fa fa-clock'></i> $from</span>"; ?></td>
                                <td><?php echo "<span><i class='fa fa-clock'></i> $to</span>"; ?></td>
    							<td><?php echo $topic_name; ?></td>
    							<td style="text-align:center;"><?php echo $capacity; ?></td>
                                <td>
                                    <?php 
                                        if( ICL_LANGUAGE_CODE == 'en' ) $lang = lang_en( $lang );
                                        echo $lang; 
                                    ?>
                                </td>
    							<td style="font-size: 16px">
                                <?php
                                    if($accessible) echo '<i class="fa fa-universal-access" title="Accessible"></i> ';
                                    if($parking) echo '<i class="fa fa-parking" title="Parking available"></i> ';
                                    if($open) echo '<i class="fa fa-circle-notch" title="Open meeting"></i> ';
                                    if($smoking) echo '<i class="fa fa-smoking" title="Smoking allowed"></i> ';
                                    if($candle) echo '<i class="fa fa-fire" title="Candle light meeting"></i>';
                                ?>
    							</td>
          <td style="text-align:center;">
          <?php $pattern = '/<a\\s+[^>]*href=[\'"]?([^\'" >]+)[\'"]?[^>]*>(.*?)<\\/a>/';
          if(preg_match($pattern, $notes, $matches)) {
          	echo $matches[0];
          } else { echo ""; }
          ?>
            </td>
							</tr>
    						<tr class='infoRow' id="detail<?php the_ID(); ?>">
    							<td colspan="3"><strong><?php _e('Address','NA'); ?>:</strong> <?php echo $contact_info['address']; ?></td>
    							<td colspan="2"><strong><?php _e('Contact Person', 'NA'); ?>:</strong> <?php echo $contact_info['contact_person']; ?> (<i class="fa fa-phone"></i> <?php echo "<a href='tel:".$contact_info['contact_number']."'>".$contact_info['contact_number']."</a>"; ?>)</td>
    							<td colspan="2">
          <!--
<div id='map' style='width: 400px; height: 300px;'></div>
<script>
  mapboxgl.accessToken = 'pk.eyJ1IjoibmFlZ3lwdCIsImEiOiJjbGdzMGNvdmswcmxyM2NtazlhZ2I0dDc2In0.kU_WMv_CWs41X2FnfKn_dg';
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11'
  });
</script>
          -->

                                    <?php if(!empty($lat)) {?>
                                    <a href="https://maps.google.com/?q=<?php echo $lat; ?>,<?php echo $lng; ?>" target="_blank"><strong><i class="fa fa-map-marker"></i> <?php _e('Map', 'NA'); ?></strong></a>
                                    <?php } else { echo '<i class="fa fa-map-marker"></i> الموقع غير متاح';} ?>
                                </td>
								<td colspan="3"><?php echo $notes; ?></td>
          					</tr>			
          			<?php endwhile; ?>
    				</tbody>
    			</table>
    <?php } ?>
    <?php
      get_meetings('السبت');
    	get_meetings('الاحد');
    	get_meetings('الاثنين');
    	get_meetings('الثلاثاء');
    	get_meetings('الاربعاء');
    	get_meetings('الخميس');
    	get_meetings('الجمعة');
    ?>

        <i class="fa fa-universal-access" title="<?php _e('Accessible', 'NA'); ?>"></i> <?php _e('Accessible', 'NA'); ?> | 
        <i class="fa fa-parking" title="<?php _e('Parking available', 'NA'); ?>"></i> <?php _e('Parking available', 'NA'); ?> | 
        <i class="fa fa-circle-notch" title="<?php _e('Open meeting', 'NA'); ?>"></i> <?php _e('Open meeting', 'NA'); ?> | 
        <i class="fa fa-smoking" title="<?php _e('Smoking allowed', 'NA'); ?>"></i> <?php _e('Smoking allowed', 'NA'); ?> | 
        <i class="fa fa-fire" title="<?php _e('Candle light meeting', 'NA'); ?>"></i> <?php _e('Candle light meeting', 'NA'); ?>

    </div> <!-- end #meetings_listing -->

</div> <!-- #main -->
<?php get_footer(); ?>
