<?php
function add_adminmenu_page2()
{
    add_menu_page('Bulk Edit', 'Bulk Edit', 'edit_themes', 'bulkeditmeetings2', 'bulk_edit_meetings2', 'dashicons-clipboard');
}
function bulk_edit_meetings2()
{
    $mArr = array('group', 'topic', 'time', 'open_closed', 'smoking', 'capacity', 'lang', 'comments');
    function get_meetings2($day)
    {
        ?>
        <h4 id="table_<?php echo strtolower($day); ?>" style='margin-bottom: 4px'><?php echo $day; ?></h4>
        <table class='wp-list-table widefat fixed'>
            <thead>
                <tr>
                    <th style="width: 10%;"><?php _e('الموضوع', 'NA'); ?></th>
                    <th style="width: 15%;"><?php _e('المجموعة', 'NA'); ?></th>
                    <th style="width: 8%;"><?php _e('من', 'NA'); ?></th>
                    <th style="width: 8%;"><?php _e('الي', 'NA'); ?></th>
                    <th style="width: 33%;"><?php _e('اخري', 'NA'); ?></th>
                    <th style="width: 6%;"><?php _e('السعه', 'NA'); ?></th>
                    <th style="width: 15%;"><?php _e('ملاحظات', 'NA'); ?></th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody>
        <?php
                $m_args = array(
                    'post_type' => 'meeting',
                    'meta_query' => array(
                        array(
                            'key' => 'day',
                            'value' => $day
                        )
                    ),
                    'posts_per_page', 2
                );
                $m_query = new WP_Query($m_args);
                while ($m_query->have_posts()) : $m_query->the_post();
                    $pgroup = get_field('pgroup');
                    $day = get_field('day');
                    $mtime = get_field('mtime');
                    $t_from = $mtime['from'];
                    $t_to = $mtime['to'];
                    $misc = get_field('misc');
                    $capacity = $misc['capacity'];
                    $misc_checks = $misc;
                    unset($misc_checks['capacity']);
                    unset($misc_checks['lang']);
                    $notes = get_field('notes');
                    $labels_arr = array(
                        'smoking' => __('مسموح بالتدخين', 'NA'),
                        'open' => __('اجتماع مفتوح', 'NA'),
                        'parking' => __('مسموح بالركن امام المكان', 'NA'),
                        'accessible' => __('متاح لذوي الاحتياجات الخاصه', 'NA'),
                        'candle' => __('علي ضوء الشموع', 'NA')
                    );
                    $postID = get_the_ID();
                    $topic = get_the_terms($post->ID, 'topic');
                    $topics = get_terms(array(
                        'taxonomy' => 'topic',
                        'hide_empty' => false
                    ));
                    echo '<tr>';
                    echo '<td><select name="data[' . $postID . '][topic]">';
                    foreach ($topics as $item) {
                        if ($topic[0]->term_id == $item->term_id)
                            echo "<option value='" . $item->term_id . "' selected='selected'>" . $item->name . "</option>";
                        else
                            echo '<option value="' . $item->term_id . '">' . $item->name . '</option>';
                    }
                    echo '</select></td>';
                    echo '<td><select name="data[' . $postID . '][pgroup]">';
                    $f_query = new WP_Query('post_type=group&posts_per_page=200');
                    while ($f_query->have_posts()) : $f_query->the_post();
                        if ($pgroup->ID == get_the_ID())
                            echo "<option value='" . get_the_ID() . "' selected='selected'>" . get_the_title() . "</option>";
                        else
                            echo "<option value='" . get_the_ID() . "'>" . get_the_title() . "</option>";
                    endwhile;
                    wp_reset_query();
                    echo "</select></td>";
                    echo '<td><input type="time" id="t_to" name="data[' . $postID . '][mtime][from]" value=' . $t_from . '></td>';
                    echo '<td><input type="time" id="t_from" name="data[' . $postID . '][mtime][to]" value=' . $t_to . '> </td>';
                    echo '<td>';
                    foreach ($misc_checks as $key => $value) {
                        $checked = '';
                        $label = $labels_arr[$key];
                        if ($value != false) {
                            $checked = 'checked';
                            $cVal = ' value=1';
                        }
                        echo '<span style="display: inline-block; margin: 0 10px;"><input type="checkbox" name="data[' . $postID . '][misc][' . $key . ']" ' . $checked . $cVal . '> ' . $label . '</span>';
                    }
                    echo '</td>';
                    echo '<td><input type="number" name="data[' . $postID . '][misc][capacity]" value="' . $capacity . '" style="width: 99%;" min=0 ></td>';
                    echo '<td><textarea name="data[' . $postID . '][notes]" style="width: 99%;">' . $notes . '</textarea></td>';
                    echo '<td><a href="">←</a></td>';
                    echo '</tr>';
                endwhile;
                echo '</tbody></table>';
            }
            // process edit
            if (isset($_POST['savebulk']) && !empty($_POST['savebulk'])) {
                echo "<br><h3>Saving....</h3>";
                echo "<pre>" . print_r($_POST['data'], 1) . "</pre>";
                // die;
                $counterx = 0;
                foreach ($_POST['data'] as $id => $post) {
                    $counterx++;
                    $topic = array($post['topic']);
                    wp_set_post_terms($id, $topic, 'topic');
                    unset($post['topic']);
                    // unset($post['misc']);
                    // // $misc = $post['misc'];
                    // update_field('pgroup', $post['pgroup'], $id);    
                    // update_field('misc', $post['misc'], $id);    
                    // update_field('mtime', $post['time'], $id);    
                    // echo "<pre>".print_r($misc,1)."</pre>"; die;
                    
                    // save unchecked features
                    foreach ($post as $key => $value) {
                        update_field($key, $value, $id);
                        // $mValue = get_post_meta($id, $mKey, true);
                        // if ($mValue != $post[$mKey]) update_field( $mKey, $post[$mKey], $id );
                        // update_post_meta($id, $mKey, $post[$mKey]);
                    }
                    echo "$counterx: Meeting #" . $id . " with topic: " . $post['topic'] . " Saved successfully.<br>";
                }
            } else {
                echo "<div class='wrap'><div id='icon-options-general' class='icon32'><br></div><h2>Edit All Meetings</h2>";
                echo '<form action="admin.php?page=bulkeditmeetings2" method="post">
			<input type="hidden" name="savebulk" value="save">';
                get_meetings2('السبت');
                get_meetings2('الاحد');
                get_meetings2('الاثنين');
                get_meetings2('الثلاثاء');
                get_meetings2('الاربعاء');
                get_meetings2('الخميس');
                get_meetings2('الجمعة');
                echo '<input type="submit" value="Save" class="button button-primary button-large" style="font-size: 30px; line-height: 60px !important; margin: 30px auto; width: 100%; text-align: center;"></form>';
                echo "</div>";
            }
        }
        add_action('admin_menu', 'add_adminmenu_page2');
        ?>