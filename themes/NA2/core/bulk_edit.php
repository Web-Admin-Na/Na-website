<?php
/* TODO - $_POST array not handling more than 125 value */
// function add_adminmenu_page()
// {
//     add_submenu_page('edit.php?post_type=group', 'Bulk Edit', 'Bulk Edit', 'edit_themes', 'bulkeditmeetings', 'bulk_edit_meetings');
// }
function bulk_edit_meetings()
{

    $mArr = array('group', 'topic', 'time', 'open_closed', 'smoking', 'capacity', 'lang', 'comments');

    function get_meetings2($day)
    {

        ?>
        <h4 id="table_<?php echo strtolower($day); ?>" style='margin-bottom: 4px'><?php echo $day; ?></h4>

        <table class='wp-list-table widefat fixed'>
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Group</th>
                    <th width="90">Time</th>
                    <th width="55">Capacity</th>
                    <th width="125">Language</th>
                    <th width="230">Misc.</th>
                    <th>Comments</th>
                    <th width="50"></th>
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
                            ),
                            'posts_per_page', -1
                        );
                        $m_query = new WP_Query($m_args);
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
                            // $term_list = wp_get_post_terms($group, 'city');
                            // foreach ( $term_list as $term ) {
                            // 	$post_classes .= $term->slug." ";
                            // }
                            // $post_classes .= strtolower($open_closed)." ";
                            $group_post = get_post($group);
                            $post_classes .= $group_post->post_name;
                            $c_person = get_post_meta($group, 'c_person', true);
                            $c_num = get_post_meta($group, 'c_num', true);
                            $address = get_post_meta($group, 'address', true);
                            $p_id = get_the_ID();
                            // if( $open_closed == "Open" ) $open_closed == "مفتوح";
                            // else $open_closed == "مغلق";
                            // if( $smoking == "Yes" ) $smoking == "نعم";
                            // else $smoking == "لا";
                            ?>
                    <tr class="<?php echo $post_classes; ?> single_meeting">
                        <td>
                            <input type="text" name='data[<?php echo $p_id; ?>][topic]' value="<?php the_title(); ?>" style='width: 99%;' />
                        </td>
                        <td>
                            <select name="data[<?php echo $p_id; ?>][group]">
                                <?php
                                            $f_query = new WP_Query('post_type=group&posts_per_page=200');
                                            while ($f_query->have_posts()) : $f_query->the_post();
                                                if ($group == get_the_ID())
                                                    echo "<option value='" . get_the_ID() . "' selected='selected'>" . get_the_title() . "</option>";
                                                else
                                                    echo "<option value='" . get_the_ID() . "'>" . get_the_title() . "</option>";
                                            endwhile;
                                            wp_reset_query;
                                            ?>
                            </select>
                        </td>
                        <td><input type="text" name='data[<?php echo $p_id; ?>][time]' value="<?php echo $time; ?>" style='width: 99%;' /></td>
                        <td><input type="text" name='data[<?php echo $p_id; ?>][capacity]' value="<?php echo $capacity; ?>" style='width: 99%;' /></td>
                        <td>
                            <select name="data[<?php echo $p_id; ?>][lang]" style="width: 80%">
                                <option<?php if ($lang == 'العربية') echo ' selected="selected"'; ?>>العربية</option>
                                    <option<?php if ($lang == 'الانجليزية') echo ' selected="selected"'; ?>>الانجليزية</option>
                            </select>
                        </td>
                        <td>
                            <select name="data[<?php echo $p_id; ?>][open_closed]">
                                <option<?php if ($open_closed == 'مفتوح') echo ' selected="selected"'; ?>>مفتوح</option>
                                    <option<?php if ($open_closed == 'مغلق') echo ' selected="selected"'; ?>>مغلق</option>
                            </select>
                            &nbsp;&nbsp;Smoking:
                            <select name="data[<?php echo $p_id; ?>][smoking]">
                                <option<?php if ($smoking == 'لا') echo ' selected="selected"'; ?>>لا</option>
                                    <option<?php if ($smoking == 'نعم') echo ' selected="selected"'; ?>>نعم</option>
                            </select>
                        </td>
                        <td><textarea name='data[<?php echo $p_id; ?>][comments]' style='width: 99%;'><?php echo $comments; ?></textarea></td>
                        <!-- <input type="hidden" name="data[<?php echo $p_id; ?>][day]" value="<?php echo $day; ?>"> -->
                        <td>
                            <a href="http://naegypt.org/wp-admin/post.php?post=<?php echo $p_id; ?>&action=edit">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

<?php }

    // process edit
    if (isset($_POST['savebulk']) && !empty($_POST['savebulk'])) {

        // echo "<pre>" . print_r($_POST, 1) . "</pre>";
        // echo count($_POST['data']);
        // die;

        echo "<br><h3>Saving....</h3>";

        $counterx = 0;
        foreach ($_POST['data'] as $id => $post) {
            $counterx++;
            // echo $counterx;
            $my_post = array();
            $my_post['ID'] = $id;
            $my_post['post_title'] = $post['topic'];
            wp_update_post($my_post);

            foreach ($mArr as $mKey) {
                $mValue = get_post_meta($id, $mKey, true);
                if ($mValue != $post[$mKey]) update_post_meta($id, $mKey, $post[$mKey]);
            }
            // update_post_meta( $id, 'group', $post['group'] );
            // update_post_meta( $id, 'topic', $post['topic'] );
            // update_post_meta( $id, 'time', $post['time'] );
            // update_post_meta( $id, 'open_closed', $post['open_closed'] );
            // update_post_meta( $id, 'smoking', $post['smoking'] );
            // update_post_meta( $id, 'capacity', $post['capacity'] );
            // update_post_meta( $id, 'lang', $post['lang'] );
            // update_post_meta( $id, 'comments', $post['comments'] );

            echo "$counterx: Meeting #" . $id . " with topic: " . $post['topic'] . " Saved successfully.<br>";
            // echo "<pre>".print_r( $post, 1 )."</pre>";

        }
    } else {

        echo "<div class='wrap'><div id='icon-options-general' class='icon32'><br></div><h2>Edit All Meetings</h2>";

        echo '<form action="edit.php?post_type=group&page=bulkeditmeetings" method="post">
			<input type="hidden" name="savebulk" value="save">';
        get_meetings2('السبت');
        get_meetings2('الاحد');
        get_meetings2('الاثنين');
        get_meetings2('الثلاثاء');
        get_meetings2('الاربعاء');
        get_meetings2('الخميس');
        get_meetings2('الجمعة');

        echo '<input type="submit" value="Save" class="button button-primary button-large" style="font-size: 30px; height: 60px; margin: 30px auto; padding-top: 15px; padding-bottom: 15px; width: 100%; text-align: center;"></form>';
        echo "</div>";
    }
}
add_action('admin_menu', 'add_adminmenu_page');
?>