<?php
// backwards compatible
add_action( 'admin_init', 'add_custom_box_meeting', 1 );

/* Adds a box to the main column on the Post and Page edit screens */
function add_custom_box_meeting() {
    add_meta_box(
        'custom_box_meeting',
        __( 'Meeting Information', 'admin' ),
        'inner_custom_box_meeting',
        'meeting'
    );
}
/* Prints the box content */
function inner_custom_box_meeting() {
	/**********************************/
	global $post;
	$custom = get_post_custom($post->ID);

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'noncename' );

	$single = isset($custom["single"][0]) ? $custom["single"][0] : '';
	$s_date = isset($custom["s_date"][0]) ? $custom["s_date"][0] : '';

	$group = isset($custom["group"][0]) ? $custom["group"][0] : '';
	$time = isset($custom["time"][0]) ? $custom["time"][0] : '';
	$topic = isset($custom["topic"][0]) ? $custom["topic"][0] : '';
	$open_closed = isset($custom["open_closed"][0]) ? $custom["open_closed"][0] : '';
	$smoking = isset($custom["smoking"][0]) ? $custom["smoking"][0] : '';
	$capacity = isset($custom["capacity"][0]) ? $custom["capacity"][0] : '';
	$lang = isset($custom["lang"][0]) ? $custom["lang"][0] : '';
	$weekday = isset($custom["weekday"][0]) ? $custom["weekday"][0] : '';
	$comments = isset($custom["comments"][0]) ? $custom["comments"][0] : '';

	$lat = isset($custom["lat"][0]) ? $custom["lat"][0] : '';
	$long = isset($custom["long"][0]) ? $custom["long"][0] : '';


?>
	<p style="display: none">
		<label>Single Occurance (Apply only for a single date edits)</label>
		<select name="single" style="width: 98%">
			<option<?php if($single=='No') echo ' selected="selected"'; ?>>No</option>
			<option<?php if($single=='Yes') echo ' selected="selected"'; ?>>Yes</option>
		</select>
	</p>
	<p style="display: none">
		<labe>Date (MM-DD-YYY)</labe>
		<input type="date" name="s_date" value="<?php echo $s_date; ?>" style="width: 98%;">
	</p>
	<!-- <br/><hr/><br/> -->
	<p>
		<label>Group</label>
		<select name="group" style="width: 98%">
			<?php
				$f_query = new WP_Query( 'post_type=group&posts_per_page=200' );
				while ($f_query->have_posts()) : $f_query->the_post();
					if( $group == get_the_ID() )
						echo "<option value='".get_the_ID()."' selected='selected'>".get_the_title()."</option>";
					else
						echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
				endwhile;
	//wp_reset_postdata();		
	wp_reset_query;
			?>
		</select>
	</p>
	<p>
		<label>Topic</label>
		<input type="text" name="topic" value="<?php echo $topic; ?>" style="width: 98%;">
	</p>
	<p>
		<label>Weekday</label>
		<select name="weekday" style="width: 98%">
      <option<?php if($weekday=='السبت') echo ' selected="selected"'; ?>>السبت</option>
			<option<?php if($weekday=='الاحد') echo ' selected="selected"'; ?>>الاحد</option>
			<option<?php if($weekday=='الاثنين') echo ' selected="selected"'; ?>>الاثنين</option>
			<option<?php if($weekday=='الثلاثاء') echo ' selected="selected"'; ?>>الثلاثاء</option>
			<option<?php if($weekday=='الاربعاء') echo ' selected="selected"'; ?>>الاربعاء</option>
			<option<?php if($weekday=='الخميس') echo ' selected="selected"'; ?>>الخميس</option>
			<option<?php if($weekday=='الجمعة') echo ' selected="selected"'; ?>>الجمعة</option>
		</select>
	</p>
	<p>
		<label>Time</label>
		<input type="text" name="time" value="<?php echo $time; ?>" style="width: 98%;">
	</p>
	<p>
		<label>Open/Closed</label>
		<select name="open_closed" style="width: 98%">
			<option<?php if($open_closed=='مفتوح') echo ' selected="selected"'; ?>>مفتوح</option>
			<option<?php if($open_closed=='مغلق') echo ' selected="selected"'; ?>>مغلق</option>
		</select>
	</p>
	<p>
		<label>Smoking</label>
		<select name="smoking" style="width: 98%">
			<option<?php if($smoking=='لا') echo ' selected="selected"'; ?>>لا</option>
			<option<?php if($smoking=='نعم') echo ' selected="selected"'; ?>>نعم</option>
		</select>
	</p>
	<p>
		<label>Capacity</label>
		<input type="text" name="capacity" value="<?php echo $capacity; ?>" style="width: 98%;">
	</p>
	<p>
		<label>Language</lable>
		<select name="lang" style="width: 98%">
			<option<?php if($lang=='العربية') echo ' selected="selected"'; ?>>العربية</option>
			<option<?php if($lang=='الانجليزية') echo ' selected="selected"'; ?>>الانجليزية</option>
		</select>
	</p>
	<p>
		<label>Latitude</lable>
		<input type="text" name="lat" value="<?php echo $lat; ?>" style="width: 98%;">
	</p>
	<p>
		<label>Longtude</label>
		<input type="text" name="long" value="<?php echo $long; ?>" style="width: 98%;">
	</p>

	<p>
		<label>Notes / Comments</label>
		<textarea name="comments" style="width: 98%; height: 70px;"><?php echo $comments; ?></textarea>
	</p>

<?php } ?>
