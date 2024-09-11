<?php
/**
 * Template Name: Meetings
 */
get_header(); ?>
<div id="main" class="container mb-50">
    <h2 class="mb-10"></php the_title(); ?></h2>

    <div id="meetings_filters" class="mb-30">
      <h3>صنف ب</h3>
    	<div class="row">
        <div class="two columns">
          <ul class="bl_sort">
            <p class="mb-10"><strong>النوع</strong></p>
            <li><a href="#all">الكل</a></li>
      			<li><a href="#مفتوح">مفتوح</a></li>
      			<li><a href="#مغلق">مغلق</a></li>
      		</ul>
        </div>
        <div class="two columns">
          <p class="mb-10"><strong>المدينة</strong></p>
      		<ul class="bl_sort">
            <li><a href="#all">الكل</a></li>
      			<li><a href="#cairo">القاهرة</a></li>
      			<li><a href="#alexandria">الاسكندرية</a></li>
      			<li><a href="#beni-sueif">بني سويف</a></li>
      			<li><a href="#mansoura">المنصورة</a></li>
      			<li><a href="#sharm-el-sheikh">شرم الشيخ</a></li>
      			<li><a href="#tanta">طنطا</a></li>
      			<li><a href="#tour-sinai">طور سيناء</a></li>
      			<li><a href="#zagazig">الزقازيق</a></li>
      		</ul>
        </div>
        <div class="five columns">
          <p class="mb-10"><strong>المجموعة</strong></p>
      		<ul class="bl_sort">
      			<li><a href="#all">الكل</a></li>
      			<?php
      				$g_query = new WP_Query( 'post_type=group&posts_per_page=200&order=DESC' );
      				while ($g_query->have_posts()) : $g_query->the_post();
      			?>
      			<li><a href="#<?php echo($post->post_name) ?>"><?php the_title(); ?></a></li>
      			<?php endwhile; wp_reset_query(); ?>
      		</ul>
        </div>
        <div class="three columns">
        	<?php
        // 		$pdf_download_link = get_post_meta(get_the_ID(), 'pdf_download_link', true);
        		$pdf_download_link = get_field('meeting_file');
        		if( !empty($pdf_download_link) ) echo "<a href='$pdf_download_link' class='downloadPDF mt-20' target='_blank'><strong>تحميل</strong> جدول الاجتماعات</a>";
        	?>
        </div>
    	</div>
      <a href="#expand" class="expandFilters">اظهر جميع الاختيارات</a>
    </div> <!-- end #meetings_filters -->
    <script type="text/javascript">
      $('.expandFilters').click( function(e){
        e.preventDefault();
        $('#meetings_filters .row').css('overflow','visible');
        $('#meetings_filters .row').css('height','auto');
        $('#meetings_filters').css('overflow','hidden');
        $( this ).fadeOut( 500 );
      });
    </script>
    <!-- <hr class="mt-30 mb-30"> -->
    <div id="meetings_listing">
    <?php
    	function get_meetings( $day ) { ?>
    			<h4 id="table_<?php echo strtolower($day); ?>"><?php echo $day; ?> <small><em>(للتعرف علي عنوان ومعلومات المجموعه اضغط الاجتماع)</em></small></h4>
    			<table class="meetings-table mb-50">
    				<thead>
    					<tr>
                <th width="110">المجموعة</th>
    						<th width="110">الوقت</th>
    						<th width="160">الموضوع</th>
    						<th width="50">السعة</th>
    						<th width="50">اللغة</th>
    						<th width="140">اخري</th>
    						<th width="150">ملاحظات</th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php
    						$m_args = array(
    							'post_type' => 'meeting',
    							'meta_query' => array(
    								array(
    									'key' => 'weekday',
    									'value' => $day
    								)
    							)
    						);

    						$m_query = new WP_Query( $m_args );
    						while ($m_query->have_posts()) : $m_query->the_post();
    							$custom = get_post_custom($post->ID);
    							$group = isset($custom["group"][0]) ? $custom["group"][0] : '';
    							$time = isset($custom["time"][0]) ? $custom["time"][0] : '';
    							$topic = isset($custom["topic"][0]) ? $custom["topic"][0] : '';
    							$open_closed = isset($custom["open_closed"][0]) ? $custom["open_closed"][0] : '';
    							$smoking = isset($custom["smoking"][0]) ? $custom["smoking"][0] : '';
    							$capacity = isset($custom["capacity"][0]) ? $custom["capacity"][0] : '';
    							$lang = isset($custom["lang"][0]) ? $custom["lang"][0] : '';
    							$comments = isset($custom["comments"][0]) ? $custom["comments"][0] : '';

    							$post_classes = '';
    							$term_list = wp_get_post_terms($group, 'city');
    							foreach ( $term_list as $term ) {
    								$post_classes .= $term->slug." ";
    							}
    							$post_classes .= strtolower($open_closed)." ";
    							$group_post = get_post($group);
    							$post_classes .= $group_post->post_name;
    							$c_person = get_post_meta($group, 'c_person', true);
    							$c_num = get_post_meta($group, 'c_num', true);
    							$address = get_post_meta($group, 'address', true);
    							$maplink = get_post_meta($group, 'maplink', true);
    					?>
    						<tr class="<?php echo $post_classes; ?> single_meeting" id="<?php the_ID(); ?>">
    							<td>
    							<?php
    								$group_post = get_post($group);
    								echo $group_post->post_title;
    							?>
    							</td>
    							<td><?php echo $time; ?></td>
    							<td><?php echo $topic; ?></td>
    							<td><?php echo $capacity; ?></td>
    							<td><?php echo $lang; ?></td>
    							<td>
                    <?php
    									echo $open_closed;
    									if($smoking=='نعم') echo " - التدخين مسموح";
    									else echo " - غير مسموح بالتدخين";
    								?>
    							</td>
    							<td><?php echo $comments; ?></td>
    						</tr>
    						<tr class='infoRow' id="detail<?php the_ID(); ?>">
                  <td>العنوان</td>
    							<td><?php echo $address; ?></td>
    							<td>المسؤول</td>
    							<td><?php echo $c_person; ?></td>
    							<td>الموبايل</td>
    							<td><?php echo $c_num; ?></td>
    							<td><a href="<?php echo $maplink; ?>"><strong>الخريطة</strong></a></td>
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
    </div> <!-- end #meetings_listing -->

</div> <!-- #main -->
<?php get_footer(); ?>
