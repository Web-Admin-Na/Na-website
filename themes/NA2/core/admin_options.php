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
                    <th style="width: 12%;"><?php _e('المجموعة', 'NA'); ?></th>
                    <th style="width: 15%;"><?php _e('الموضوع', 'NA'); ?></th>
                    <th style="width: 8%;"><?php _e('من', 'NA'); ?></th>
                    <th style="width: 8%;"><?php _e('الي', 'NA'); ?></th>
                    <th style="width: 30%;"><?php _e('اخري', 'NA'); ?></th>
                    <th style="width: 6%;"><?php _e('السعه', 'NA'); ?></th>
                    <th style="width: 16%;"><?php _e('ملاحظات', 'NA'); ?></th>
                    <th style="width: 5%;"></th>
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
                            'value' => $day
                        )
                    ),
                );
                $m_query = new WP_Query($m_args);
                while ($m_query->have_posts()) : $m_query->the_post();
                    $pgroup = get_field('pgroup');

                    // $day = get_field('day');
                    // $mtime = get_field('mtime');
                    // $t_from = $mtime['from'];
                    // $t_to = $mtime['to'];
                    // $misc = get_field('misc');
                    // $capacity = $misc['capacity'];
                    $topic = wp_get_post_terms('topic');
                    // echo "<pre>".print_r($topic,1)."</pre>";

                    // $city = wp_get_post_terms($pgroup->ID, 'city');

                    $from  = get_field('from');
                    $to  = get_field('to');
                                      
                    $lang  = get_field('lang');
                    $capacity  = get_field('capacity');
                    $smoking  = get_field('smoking');
                    $accessible  = get_field('accessible');
                    $open  = get_field('open');
                    $candle  = get_field('candle');
                    $parking  = get_field('parking');
                  
                    $weekday = get_field('day');
                    $notes   = get_field('notes');
                  
                    // $misc_checks = $misc;
                    // unset($misc_checks['capacity']);
                    // unset($misc_checks['lang']);
                    
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
                        'hide_empty' => true
                    ));
                    echo '<tr>';
                    // echo "<pre>".print_r($pgroup,1)."</pre>";
                    echo '<td><select name="data[' . $postID . '][pgroup]">';
                    $f_query = new WP_Query('post_type=group&posts_per_page=200');
                    while ($f_query->have_posts()) : $f_query->the_post();
                        if ($pgroup == get_the_ID())
                            echo "<option value='" . get_the_ID() . "' selected='selected'>" . get_the_title() . "</option>";
                        else
                            echo "<option value='" . get_the_ID() . "'>" . get_the_title() . "</option>";
                    endwhile;
                    wp_reset_query();
                    echo "</select></td>";
                    echo '<td><select name="data[' . $postID . '][topic]">';
                    foreach ($topics as $item) {
                        if ($topic[0]->term_id == $item->term_id)
                            echo "<option value='" . $item->term_id . "' selected='selected'>" . $item->name . "</option>";
                        else
                            echo '<option value="' . $item->term_id . '">' . $item->name . '</option>';
                    }
                    echo '</select></td>';
                    echo '<td><input type="time" id="t_to" name="data[' . $postID . '][from]" value=' . $from . '></td>';
                    echo '<td><input type="time" id="t_from" name="data[' . $postID . '][to]" value=' . $to . '> </td>';
                    echo '<td>';
                    // foreach ($misc_checks as $key => $value) {
                    //     $checked = '';
                    //     $label = $labels_arr[$key];
                    //     if ($value != false) {
                    //         $checked = 'checked';
                    //         $cVal = ' value=1';
                    //     }
                    //     echo '<span style="display: inline-block; margin: 0 10px;"><input type="checkbox" name="data[' . $postID . '][misc][' . $key . ']" ' . $checked . $cVal . '> ' . $label . '</span>';
                    // }
                    ?>
                        <input type="checkbox" name="data[<?php echo $postID; ?>][smoking]" <?php if($smoking==1) echo "checked"; ?>> مسموح بالتدخين<br>
                        <input type="checkbox" name="data[<?php echo $postID; ?>][accessible]" <?php if($accessible==1) echo "checked"; ?>> مجهز لذوي الاحتياجات الخاصه<br>
                        <input type="checkbox" name="data[<?php echo $postID; ?>][open]" <?php if($open==1) echo "checked"; ?>> اجتماع مفتوح<br>
                        <input type="checkbox" name="data[<?php echo $postID; ?>][candle]" <?php if($candle==1) echo "checked"; ?>> علي ضوء الشموع<br>
                        <input type="checkbox" name="data[<?php echo $postID; ?>][parking]" <?php if($parking==1) echo "checked"; ?>> مسموح بالركن امام المكان

                    <?php

                    echo '</td>';
                    echo '<td><input type="number" name="data[' . $postID . '][capacity]" value="' . $capacity . '" style="width: 99%;" min=0 ></td>';
                    echo '<td><textarea name="data[' . $postID . '][notes]" style="width: 99%;">' . $notes . '</textarea></td>';
                    echo '<td><a href="">←</a></td>';
                    echo '</tr>';
                endwhile;
                echo '</tbody></table>';
            }
            // process edit
            if (isset($_POST['savebulk']) && !empty($_POST['savebulk'])) {
                echo "<br><h3>Saving....</h3>";
                // echo "<pre>" . print_r($_POST['data'], 1) . "</pre>";
                // die;
                $counterx = 0;
                $checks_arr = array('smoking', 'accessible', 'open', 'candle', 'parking');
                foreach ($_POST['data'] as $id => $post) {
                    $counterx++;
                    $topic = array($post['topic']);
                    wp_set_post_terms($id, $topic, 'topic');
                    unset($post['topic']);

                    foreach( $checks_arr as $check ) {
                        // if( !isset($post[$check]) || empty($post[$check]) ) $post[$check] = 0; 
                        if( $post[$check] == 'on' ) $post[$check] = 1; 
                        else $post[$check] = 0;
                    }
                    // unset($post['misc']);
                    // // $misc = $post['misc'];
                    // update_field('pgroup', $post['pgroup'], $id);    
                    // update_field('misc', $post['misc'], $id);    
                    // update_field('mtime', $post['time'], $id);    
                    // echo "<pre>".print_r($misc,1)."</pre>"; die;
                    
                    // save unchecked features
                    foreach ($post as $key => $value) {
                        // if( in_array($key, $checks_arr) && empty($value) ) $value = 0;
                        update_field($key, $value, $id);
                        // $mValue = get_post_meta($id, $mKey, true);
                        // if ($mValue != $post[$mKey]) update_field( $mKey, $post[$mKey], $id );
                        // update_post_meta($id, $mKey, $post[$mKey]);
                    }
                    
                    echo "$counterx: Meeting #" . $id . " with topic: " . $post['topic'] . " Saved successfully.<br>";
                }
            } else {
                echo "<div class='wrap'><div id='icon-options-general' class='icon32'><br></div><h2>Edit All Meetings
                <a href='https://naegypt.org/csv-export/' target='_blank' class='page-title-action'>Export CSV</a>
                </h2>";
                
            //     download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            // echo array2csv($array);
            // die();
            
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