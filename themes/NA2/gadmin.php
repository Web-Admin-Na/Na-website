<?php
/**
 * Template Name: gAdmin
 */

// echo "<pre>".print_r($roles,1)."</pre>";
if (!is_user_logged_in()) {
    echo "Unauthorized Access!";
    // echo "<a href='$glogin'>Login here</a>";
    die;
}
$user = wp_get_current_user();
$roles = (array) $user->roles;
get_header();
//  TODO - Display a loader when click on edit

// $glogin = get_temp_permalink('glogin.php');
$editMeeting = get_temp_permalink('gadmin-editMeeting.php');
$addMeeting = get_temp_permalink('gadmin-addMeeting.php');
$editGroup = get_temp_permalink('gadmin-editGroup.php');
$gadmin = get_the_permalink();
// if (isset($_POST['gLogin'])) {
//     $creds = array(
//         "user_login" => $_POST["lEmail"],
//         "user_password" => $_POST["lPassword"]
//     );
//     $user = wp_signon($creds, false);
//     if (is_wp_error($user)) {
//         echo $user->get_error_message();
//         echo "<script>window.location.replace('$glogin');</script>";
//     } else {
//         $gadmin = get_bloginfo("url") . "/gadmin/";
//         // $current_user = wp_get_current_user();
//         // echo "<pre>".print_r( $user, 1 )."</pre>";
//         // echo "Redirecting....<script>window.location.replace('$gadmin');</script>";
//         // wp_redirect( $gadmin )
//         // exit
//     }
// }

// $row = 1;
// if (($handle = fopen(TEMPLATEPATH . "/users.csv", "r")) !== FALSE) {
//     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//         $num = count($data);
//         $row++;
//         for ($c=0; $c < $num; $c++) {
//             echo $data[$c]."<br>";
//             $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
//             $user_id = wp_create_user( $data[$c], $random_password, $data[$c] );
//             if($user_id) echo "ID: " . $user_id . " - Email: " . $data[$c] . "- P:" . $random_password;
//         }
//     }
//     fclose($handle);
// }
// die;

echo '<div id="main" class="container mb-50">
<div class="gadmin">';


if (!empty($_GET['delete'])) {
    delete_meeting($_GET['delete']);
    // wp_redirect( $gadmin );
}

// $group_id = 1292;
$g_args = array(
    "post_type"   => "group",
    'meta_key'    => 'owner',
    'meta_value'  => $user->ID
);
// echo "User ID:".$user->ID;

$g_query = new WP_Query($g_args);
if ($g_query->have_posts()) :
    while ($g_query->have_posts()) : $g_query->the_post();

        $group_id = get_the_ID();

        $c_info = get_field('contact_info');
        $group_address = $c_info['address'];
        $contact_person = $c_info['contact_person'];
        $contact_number = $c_info['contact_number'];
        $lat = get_field("lat");
        $lng = get_field("lng");
        //echo $lng;
        // echo "Group ID:".$group_id;
        // the_field('owner');

        echo "<div class='group'><div class='gHead'><h4>المجموعة: " . get_the_title() . "</h4><p><small>العنوان:</small> " . $group_address . ", <small>المسؤول:</small> " . $contact_person . ", <small>التليفون:</small> " . $contact_number . "</p>
        <strong>يرجي التاكد من صحة بيانات المجموعه بصورة منتظمة خصوصا العنوان واسم ممثل المجموعه</strong>
        <a href='#' class='editGroup' data-id='$group_id'><strong>تعديل بيانات المجموعة</strong></a>
        </div><ul>";
        
        $m_args = array(
            "post_type"   => "meeting",
            'meta_query' => array(
                array(
                    'key'     => 'pgroup',
                    'value'   => get_the_ID()
                )
            ),
            'posts_per_page' => -1,
            // 'meta_key' => 'day',
            // 'orderby' => 'meta_value_num',
            // 'order' => 'ASC'

        );
        $m_query = new WP_Query($m_args);
        if ($m_query->have_posts()) :
            while ($m_query->have_posts()) : $m_query->the_post();

                $topic = get_the_terms(get_the_ID(), 'topic');
                $topic_name = $topic[0]->name;
                $weekday = get_field('day');
				$fromf = get_field('from', false, false, false);
                $from = date("g:i A", strtotime($fromf));
				$tof = get_field('to', false, false, false);
                $to = date("g:i A", strtotime($tof));	
				$smoking  = get_field('smoking');
                $accessible  = get_field('accessible');
                $open  = get_field('open');
                $candle  = get_field('candle');
                $parking  = get_field('parking');

                $mID = get_the_ID();
                echo "<li><strong>$topic_name - ($weekday)</strong><span><i class='fa fa-clock'></i> $from</span><span>$to</span><span>";
                if($accessible) echo '<i class="fa fa-universal-access" title="مجهز لذوي الاحتياجات الخاصة"></i>';
                if($parking) echo '<i class="fa fa-parking" title="يوجد باركينج"></i>';
                if($open) echo '<i class="fa fa-circle-notch" title="اجتماع مفتوح"></i>';
                if($smoking) echo '<i class="fa fa-smoking" title="مسموح يالتدخين"></i>';
                if($candle) echo '<i class="fa fa-fire" title="علي ضوء الشموع"></i>';
                echo "</span><a href='#' class='delete' data-id='$mID'>حذف</a><a href='#' class='edit' data-id='$mID'>تعديل</a></li>";
            /*
        options
        - Open/Closed, Smoking/Non-Smoking, Capacity, Language, Map Pin (lat-long), CandleLight
        - Topic (dropdown), Days (dropdown), Time, Notes (free text)
        */
            endwhile;
        else :
            echo "<li>لا يوجد أي اجتماعات داخل هذه المجموعة</li>";
        endif;
        echo "</ul></div>";
        echo "<a href='#' class='mAdd' data-id='$group_id'>اضف اجتماع جديد</a><div class='clr'></div>";
    endwhile;
endif;
?>
<!-- <div class='msg'><strong>يرجي التاكد من صحة بيانات المجموعه بصورة منتظمة خصوصا العنوان واسم ممثل المجموعه</strong></div> -->
<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/wMMXuKB0BoY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
<div class="mPopup"></div> <!-- .mPopup -->
<script type="text/javascript">
    $(document).ready(function() {
        $(" a.mAdd, a.edit, a.delete").click(function(e) {
            e.preventDefault();
            if (this.className == "edit") {
                var mID = $(this).attr("data-id");
                var edit_url = "<?php echo $editMeeting; ?>/?mID=" + mID;
                $.get(edit_url, function(data) {
                    $(".mPopup").html(data);
                    $(".mPopup").fadeIn(300);
                    $(".pClose").click(function(e) {
                        e.preventDefault();
                        $(".mPopup").fadeOut(200);
                    });
                });
            } else if (this.className == "mAdd") {
                var gID = $(this).attr("data-id");
                var add_url = "<?php echo $addMeeting; ?>/?gID=" + gID;
                $.get(add_url, function(data) {
                    $(".mPopup").html(data);
                    $(".mPopup").fadeIn(300);
                    $(".pClose").click(function(e) {
                        e.preventDefault();
                        $(".mPopup").fadeOut(200);
                    });
                });
            } else if (this.className == "delete") {
                var mID = $(this).attr("data-id");
                var result = confirm("هل انت متأكد من حذف هذا الاجتماع؟");
                if (result) {
                    var base = window.location.origin;
                    window.location.href = "<?php echo $gadmin; ?>/?delete=" + mID;
                }
            }
        });
        $('.editGroup').click(function(e) {
            e.preventDefault();
            var gID = $(this).attr("data-id");
            var editg_url = "<?php echo $editGroup; ?>/?gID=" + gID;
            $.get(editg_url, function(data) {
                $(".mPopup").html(data);
                $(".mPopup").fadeIn(300);
                $(".pClose").click(function(e) {
                    e.preventDefault();
                    $(".mPopup").fadeOut(200);
                });
            });
        });
    });
</script>
<?php
echo '<div class="clr"></div></div></div> <!-- #main -->';
get_footer();
?>