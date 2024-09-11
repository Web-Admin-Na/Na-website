<?php
function custom_post_type_init()
{
    $labels_meeting = array(
        'name' => _x('Meetings', 'post type general name', 'admin'),
        'singular_name' => _x('Meetings', 'post type singular name', 'admin'),
        'add_new' => _x('Add New', 'meeting', 'admin'),
        'add_new_item' => __('Add New Meeting', 'admin'),
        'edit_item' => __('Edit Meeting', 'admin'),
        'new_item' => __('New Meeting', 'admin'),
        'all_items' => __('All Meetings', 'admin'),
        'view_item' => __('View Meeting', 'admin'),
        'search_items' => __('Search Meetings', 'admin'),
        'not_found' =>  __('No Meetings found', 'admin'),
        'not_found_in_trash' => __('No Meetings found in Trash', 'admin'),
        'parent_item_colon' => '',
        'menu_name' => __('Meetings', 'admin')
    );
    $args_meeting = array(
        'labels' => $labels_meeting,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => _x('meeting', 'URL slug', 'admin')),
        'menu_icon' => 'dashicons-share',
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title')
    );
    register_post_type('meeting', $args_meeting);

    $labels_group = array(
        'name' => _x('Groups', 'post type general name', 'admin'),
        'singular_name' => _x('Groups', 'post type singular name', 'admin'),
        'add_new' => _x('Add New', 'group', 'admin'),
        'add_new_item' => __('Add New Group', 'admin'),
        'edit_item' => __('Edit Group', 'admin'),
        'new_item' => __('New Group', 'admin'),
        'all_items' => __('All Groups', 'admin'),
        'view_item' => __('View Group', 'admin'),
        'search_items' => __('Search Groups', 'admin'),
        'not_found' =>  __('No Groups found', 'admin'),
        'not_found_in_trash' => __('No Groups found in Trash', 'admin'),
        'parent_item_colon' => '',
        'menu_name' => __('Groups', 'admin')
    );
    $args_group = array(
        'labels' => $labels_group,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => _x('group', 'URL slug', 'admin')),
        'menu_icon' => 'dashicons-groups',
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title')
    );
    register_post_type('group', $args_group);
    $labels_event = array(
        'name' => _x('Events', 'post type general name', 'NA'),
        'singular_name' => _x('Event', 'post type singular name', 'NA'),
        'add_new' => _x('Add New', 'tour', 'NA'),
        'add_new_item' => __('Add New Event', 'NA'),
        'edit_item' => __('Edit Event', 'NA'),
        'new_item' => __('New Event', 'NA'),
        'all_items' => __('All Events', 'NA'),
        'view_item' => __('View Event', 'NA'),
        'search_items' => __('Search Events', 'NA'),
        'not_found' =>  __('No Events found', 'NA'),
        'not_found_in_trash' => __('No Events found in Trash', 'NA'),
        'parent_item_colon' => '',
        'menu_name' => __('Events', 'NA')
    );
    $args_event = array(
        'labels' => $labels_event,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => _x('event', 'URL slug', 'admin')),
        'menu_icon' => 'dashicons-calendar-alt',
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments')
    );
    register_post_type('event', $args_event);
}
add_action('init', 'custom_post_type_init');

// Cities Taxonomy
register_taxonomy(
    'city',
    array('group'),
    array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Cities', 'NA'),
            'singular_name' => __('City', 'NA'),
            'search_items' =>  __('Search Cities', 'NA'),
            'all_items' => __('All Cities', 'NA'),
            'parent_item' => __('Parent City', 'NA'),
            'parent_item_colon' => __('Parent City:', 'NA'),
            'edit_item' => __('Edit City', 'NA'),
            'update_item' => __('Update City', 'NA'),
            'add_new_item' => __('Add New City', 'NA'),
            'new_item_name' => __('New City', 'NA')
        ),
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'city', 'hierarchical' => true),
    )
);
// Topics Taxonomy
register_taxonomy(
    'topic',
    array('meeting'),
    array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Topics', 'NA'),
            'singular_name' => __('topic', 'NA'),
            'search_items' =>  __('Search Topics', 'NA'),
            'all_items' => __('All Topics', 'NA'),
            'parent_item' => __('Parent Topic', 'NA'),
            'parent_item_colon' => __('Parent Topic:', 'NA'),
            'edit_item' => __('Edit Topic', 'NA'),
            'update_item' => __('Update Topic', 'NA'),
            'add_new_item' => __('Add New Topic', 'NA'),
            'new_item_name' => __('New Topic', 'NA')
        ),
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'topic', 'hierarchical' => false),
    )
);
/* Do something with the data entered */
add_action('save_post', 'save_postdata');
/* When the post is saved, saves our custom data */
function save_postdata($post_id)
{
    global $post;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    if ($post->post_type == 'meeting') {
        if (isset($_POST["group"]) && $_POST["group"] <> '') update_post_meta($post->ID, "group", $_POST["group"]);
        if (isset($_POST["time"]) && $_POST["time"] <> '') update_post_meta($post->ID, "time", $_POST["time"]);
        if (isset($_POST["topic"]) && $_POST["topic"] <> '') update_post_meta($post->ID, "topic", $_POST["topic"]);
        if (isset($_POST["open_closed"]) && $_POST["open_closed"] <> '') update_post_meta($post->ID, "open_closed", $_POST["open_closed"]);
        if (isset($_POST["smoking"]) && $_POST["smoking"] <> '') update_post_meta($post->ID, "smoking", $_POST["smoking"]);
        if (isset($_POST["capacity"]) && $_POST["capacity"] <> '') update_post_meta($post->ID, "capacity", $_POST["capacity"]);
        if (isset($_POST["lang"]) && $_POST["lang"] <> '') update_post_meta($post->ID, "lang", $_POST["lang"]);
        if (isset($_POST["weekday"]) && $_POST["weekday"] <> '') update_post_meta($post->ID, "weekday", $_POST["weekday"]);
        if (isset($_POST["single"]) && $_POST["single"] <> '') update_post_meta($post->ID, "single", $_POST["single"]);
        if (isset($_POST["s_date"]) && $_POST["s_date"] <> '') update_post_meta($post->ID, "s_date", $_POST["s_date"]);
        if (isset($_POST["lat"]) && $_POST["lat"] <> '') update_post_meta($post->ID, "lat", $_POST["lat"]);
        if (isset($_POST["long"]) && $_POST["long"] <> '') update_post_meta($post->ID, "long", $_POST["long"]);
        if (isset($_POST["comments"]) && $_POST["comments"] <> '') update_post_meta($post->ID, "comments", $_POST["comments"]);
    } elseif ($post->post_type == 'group') {
        if (isset($_POST["gadmin"]) && $_POST["gadmin"] <> '') update_post_meta($post->ID, "gadmin", $_POST["gadmin"]);
        if (isset($_POST["address"]) && $_POST["address"] <> '') update_post_meta($post->ID, "address", $_POST["address"]);
        if (isset($_POST["c_person"]) && $_POST["c_person"] <> '') update_post_meta($post->ID, "c_person", $_POST["c_person"]);
        if (isset($_POST["c_num"]) && $_POST["c_num"] <> '') update_post_meta($post->ID, "c_num", $_POST["c_num"]);
        if (isset($_POST["maplink"]) && $_POST["maplink"] <> '') update_post_meta($post->ID, "maplink", $_POST["maplink"]);
    } elseif ($post->post_type == 'event') {

        if (isset($_POST["event_date"]) && $_POST["event_date"] <> '') update_post_meta($post->ID, "event_date", $_POST["event_date"]);
        if (isset($_POST["event_location"]) && $_POST["event_location"] <> '') update_post_meta($post->ID, "event_location", $_POST["event_location"]);
        if (isset($_POST["event_address"]) && $_POST["event_address"] <> '') update_post_meta($post->ID, "event_address", $_POST["event_address"]);
        if (isset($_POST["event_lat"]) && $_POST["event_lat"] <> '') update_post_meta($post->ID, "event_lat", $_POST["event_lat"]);
        if (isset($_POST["event_long"]) && $_POST["event_long"] <> '') update_post_meta($post->ID, "event_long", $_POST["event_long"]);
        if (isset($_POST["event_form"]) && $_POST["event_form"] <> '') update_post_meta($post->ID, "event_form", $_POST["event_form"]);
    }
}

include_once(TEMPLATEPATH . '/core/cpt_group.php');
include_once(TEMPLATEPATH . '/core/cpt_meeting.php');
include_once(TEMPLATEPATH . '/core/cpt_event.php');
// include_once(TEMPLATEPATH . '/core/admin_options.php');
