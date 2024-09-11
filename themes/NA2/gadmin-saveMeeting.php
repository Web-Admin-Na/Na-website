<?php
/**
 * Template Name: Save Meeting
 *
 */
if (!is_user_logged_in()) {
    echo "Unauthorized Access!";
    // echo "<a href='$glogin'>Login here</a>";
    die;
}
$topic = get_term_by('id', $_POST['topic'], 'topic');

$meta_arr = $_POST['data'];
// echo "<pre>".print_r($meta_arr,1)."</pre>";

// if( isset( $_POST['ID']) ) unset( $meta_arr['ID'] );
$updated_meeting = array(
  'ID'           => $_POST['ID'],
  'post_title'   => $topic->name,
//   'post_type'   => 'meeting',
);
// get_current_user_id()

$post_id = wp_update_post( $updated_meeting );

if ( is_wp_error( $post_id ) ) {
	$errors = $post_id->get_error_messages();
	foreach ($errors as $error) {
		echo $error;
	}
} else {
  foreach( $meta_arr as $meta_key => $meta_value ) {
    update_post_meta( $post_id, $meta_key, $meta_value);
  }
  wp_set_post_terms( $post_id, $_POST['topic'], 'topic' );
  echo 1;
}
?>