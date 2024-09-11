<?php
/**
 * Template Name: Save all
 *
 */
if (!is_user_logged_in() || !isset($_POST['func'])) {
    echo "Unauthorized Access!";
    // echo "<a href='$glogin'>Login here</a>";
    die;
}


// echo "<pre>".print_r($_POST,1)."</pre>"; die;

$func = $_POST['func'];

if( $func == "addMeeting" ) {
 
    $topic = get_term_by('id', $_POST['topic'], 'topic');

    $meta_arr = $_POST['data'];

    // if( isset( $_POST['ID']) ) unset( $meta_arr['ID'] );

    // ***** AUTHOR ID ****** //
    $new_meeting = array(
        'post_title'   => $topic->name,
        'post_type'   => 'meeting',
        'post_status' => 'publish',
        // 'author' => 
    );
    // get_current_user_id()

    $post_id = wp_insert_post( $new_meeting );

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
        do_action( 'wpml_make_post_duplicates', $post_id );
        echo 1;
    }

} elseif ( $func == "editMeeting") {
    // echo "<pre>".print_r($_POST,1)."</pre>"; die;

    $topic = get_term_by('id', $_POST['topic'], 'topic');

    $meta_arr = $_POST['data'];

    $updated_meeting = array(
      'ID'           => $_POST['ID'],
      'post_title'   => $topic->name,
    //   'post_type'   => 'meeting',
    );
    
    $post_id = wp_update_post( $updated_meeting );
    
    if ( is_wp_error( $post_id ) ) {
        $errors = $post_id->get_error_messages();
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
      foreach( $meta_arr as $meta_key => $meta_value ) {
        update_field( $meta_key, $meta_value, $post_id);
      }
      wp_set_post_terms( $post_id, $_POST['topic'], 'topic' );
      echo 1;
    }

} elseif ( $func == "editGroup" ) {

    // echo "<pre>".print_r($_POST['data'],1)."</pre>";
    update_field( 'lat', $_POST['data']['lat'], $_POST['gID']); 
    update_field( 'lng', $_POST['data']['lng'], $_POST['gID']); 
    update_field( 'lat', $_POST['en']['lat'], $_POST['gID_tr']); 
    update_field( 'lng', $_POST['en']['lng'], $_POST['gID_tr']); 

    $result = update_field( 'contact_info', $_POST['data']['contact_info'], $_POST['gID']); 

    $result = update_field( 'contact_info', $_POST['en']['contact_info'], $_POST['gID_tr']); 
    echo 1;
    // if( $result ) echo 1; else echo 0;

} else {
    echo 0;
}


?>