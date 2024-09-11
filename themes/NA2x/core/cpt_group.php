<?php
// backwards compatible
add_action('admin_init', 'add_custom_box_group', 1);

/* Adds a box to the main column on the Post and Page edit screens */
function add_custom_box_group()
{
    add_meta_box(
        'custom_box_group',
        __('Group Information', 'admin'),
        'inner_custom_box_group',
        'group'
    );
    add_meta_box(
        'custom_box_group2',
        __('Group Meetings', 'admin'),
        'inner_custom_box_group2',
        'group'
    );
}
/* Prints the box content */
function inner_custom_box_group()
{
    /**********************************/
    global $post;
    $custom = get_post_custom($post->ID);

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'noncename');
    $gadmin = isset($custom["gadmin"][0]) ? $custom["gadmin"][0] : '';
    $address = isset($custom["address"][0]) ? $custom["address"][0] : '';
    $c_person = isset($custom["c_person"][0]) ? $custom["c_person"][0] : '';
    $c_num = isset($custom["c_num"][0]) ? $custom["c_num"][0] : '';
    $maplink = isset($custom["maplink"][0]) ? $custom["maplink"][0] : '';
    $args = array(
        "orderby" => 'user_login'
    );
    ?>
    <p>
        <label>Group Admin</label>
        <select name="gadmin">
            <?php
                $user_query = new WP_User_Query($args);
                if (!empty($user_query->results)) {
                    echo "<option>Select User</option>";
                    foreach ($user_query->results as $user) {
                        if ($user->ID == $gadmin) echo '<option value="' . $user->ID . '" selected>' . $user->user_login . '</option>';
                        else echo '<option value="' . $user->ID . '">' . $user->user_login . '</option>';
                    }
                } else {
                    echo '<option>No users found.</option>';
                }
                ?>
        </select>
    </p>
    <p>
        <labe>Address</labe>
        <input type="text" name="address" value="<?php echo $address; ?>" style="width: 98%;">
    </p>
    <p>
        <labe>Contact Person</labe>
        <input type="text" name="c_person" value="<?php echo $c_person; ?>" style="width: 98%;">
    </p>
    <p>
        <labe>Contact Number</labe>
        <input type="text" name="c_num" value="<?php echo $c_num; ?>" style="width: 98%;">
    </p>
    <p>
        <labe>Map Link</labe>
        <input type="text" name="maplink" value="<?php echo $maplink; ?>" style="width: 98%;">
    </p>
    <!-- admin form html goes here -->

<?php }

function inner_custom_box_group2()
{
    global $post;

    $args = array(
        'post_type' => 'meeting',
        'meta_key' => 'group',
        'meta_value' => $post->ID
    );
    $the_query = new WP_Query($args);

    while ($the_query->have_posts()) {
        $the_query->the_post();
        $weekday = get_post_meta(get_the_ID(), 'weekday', true);
        $time = get_post_meta(get_the_ID(), 'time', true);

        echo "<li><a href='" . get_bloginfo('url') . "/wp-admin/post.php?post=" . get_the_ID() . "&action=edit'>" . get_the_title() . " - $weekday ($time) </a></li>";
    }
    wp_reset_query();
} ?>