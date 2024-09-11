<?php
/**
 * Template Name: Save Meeting
 *
 */

// $user_id = get_current_user_id();
// $post_id = 0;
// if (isset($_POST['ID'])) {
//     /*
//     Update meeting
//     */
//     $updated_meeting = array(
//         'ID'           => $_POST['ID'],
//         'post_title'   => $_POST['topic'] // process as taxonomu
//     );
//     $post_id = wp_update_post($updated_meeting);
//     wp_set_post_terms($post_id, $_POST['topic'], 'topic', false);
//     do_action( 'wpml_make_post_duplicates', $post_id );
//     if (is_wp_error($post_id)) {
//         $errors = $post_id->get_error_messages();
//         foreach ($errors as $error) echo $error;
//     } else {
//         // $translation_id = apply_filters('wpml_object_id', $gID, 'group', FALSE, 'en');
//         foreach ($_POST['data'] as $meta_key => $meta_value) {
//             update_field($meta_key, $meta_value, $post_id);
//         }
//         echo 1;
//     }    
// } elseif (isset($_POST['gID']) && !isset($_POST['ّID']) && !isset($_POST['func'])) {
//      /*
//     Add meeting
//     */   
//     $new_meeting = array(
//         'post_author'           => $user_id,
//         'post_title'            => 'new draft meeting',
//         'post_status'           => 'publish',
//         'post_type'             => 'meeting',
//     );
//     $post_id = wp_insert_post($new_meeting);
//     // update group meta
//     update_field('pgroup', $_POST['gID'], $post_id);
//     wp_set_post_terms($post_id, $_POST['topic'], 'topic', false);
//     do_action( 'wpml_make_post_duplicates', $post_id );
//     if (is_wp_error($post_id)) {
//         $errors = $post_id->get_error_messages();
//         foreach ($errors as $error) echo $error;
//     } else {
//         // $translation_id = apply_filters('wpml_object_id', $gID, 'group', FALSE, 'en');
//         foreach ($_POST['data'] as $meta_key => $meta_value) {
//             update_field($meta_key, $meta_value, $post_id);
//         }
//         echo 1;
//     }    
// } elseif (isset($_POST['gID']) && isset($_POST['func'])) {
//      /*
//     Update group
//     */   
//     $post_id = $_POST['gID'];
//     do_action( 'wpml_make_post_duplicates', $post_id );
//     $translation_id = apply_filters('wpml_object_id', $post_id, 'group', FALSE, 'en');
//     foreach ($_POST['data'] as $meta_key => $meta_value) {
//         update_field($meta_key, $meta_value, $post_id);
//     }
//     foreach ($_POST['en'] as $meta_key => $meta_value) {
//         update_field($meta_key, $meta_value, $translation_id);
//     }
//     echo 1;
// } else {
//     echo "Error!";
//     die;
// }