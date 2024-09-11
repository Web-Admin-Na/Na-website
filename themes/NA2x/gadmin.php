<?php
/**
 * Template Name: gAdmin
 */
$user = wp_get_current_user();
$roles = (array) $user->roles;
// echo "<pre>".print_r($roles,1)."</pre>";
// allow only if merchant or adminstartor
if (!is_user_logged_in()) {
    echo "Unauthorized Access!";
    // echo "<a href='$glogin'>Login here</a>";
    die;
}
get_header();
//  TODO - Display a loader when click on edit
$ap_args = [
    'post_type' => 'page',
    'fields' => 'ids',
    'nopaging' => true,
    'meta_key' => '_wp_page_template',
    'meta_value' => 'gadmin.php'
];
$adminPage = get_pages($ap_args);

$glogin = get_temp_permalink('glogin.php');
$editMeeting = get_temp_permalink('gadmin-editMeeting.php');
$addMeeting = get_temp_permalink('gadmin-addMeeting.php');
$editGroup = get_temp_permalink('gadmin-editGroup.php');

if (isset($_POST['gLogin'])) {
    $creds = array(
        "user_login" => $_POST["lEmail"],
        "user_password" => $_POST["lPassword"]
    );
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        echo $user->get_error_message();
        echo "<script>window.location.replace('$glogin');</script>";
    } else {
        $gadmin = get_bloginfo("url") . "/gadmin/";
        // $current_user = wp_get_current_user();
        // echo "<pre>".print_r( $user, 1 )."</pre>";
        // echo "Redirecting....<script>window.location.replace('$gadmin');</script>";
        // wp_redirect( $gadmin )
        // exit
    }
}

echo '<div id="main" class="container mb-50">
<div class="gadmin">';


if (!empty($_GET['delete'])) {
    delete_meeting($_GET['delete']);
    wp_redirect( get_the_permalink() );
}

$group_id = 0;
$g_args = array(
    "post_type"   => "group",
    'meta_key'    => 'owner',
    'meta_value'  => $user->ID
);
$g_query = new WP_Query($g_args);
if ($g_query->have_posts()) :
    while ($g_query->have_posts()) : $g_query->the_post();
        $group_id = get_the_ID();
        $c_info = get_field('contact_info');
        echo "<div class='group'><div class='gHead'><h4>المجموعة: " . get_the_title() . "</h4><p><small>العنوان:</small> " . $c_info['address'] . ", <small>المسؤول:</small> " . $c_info['contact_person'] . ", <small>التليفون:</small> " . $c_info['contact_number'] . "</p>
        <strong>يرجي التاكد من صحة بيانات المجموعه بصورة منتظمة خصوصا العنوان واسم ممثل المجموعه</strong>
        <a href='#' class='editGroup' data-id='$group_id'><strong>تعديل بيانات المجموعة</strong></a>
        </div><ul>";
        $m_args = array(
            "post_type"   => "meeting",
            'meta_key'    => 'pgroup',
            'meta_value'  => get_the_ID(),
            'posts_per_page' => -1
        );
        $m_query = new WP_Query($m_args);
        if ($m_query->have_posts()) :
            while ($m_query->have_posts()) : $m_query->the_post();
                $topic = wp_get_post_terms(get_the_ID(), 'topic');
                $topic_name = $topic[0]->name;
                $weekday = get_field('day');
                $time = get_field('mtime');
                $from = $time['from'];
                $from = date("g:i a", strtotime($from));
                $to = $time['to'];
                $to = date("g:i a", strtotime($to));
                $misc = get_field('misc');
                $notes = get_field('notes');
                $mID = get_the_ID();
                echo "<li><strong>$topic_name - ($weekday)</strong><span><i class='fa fa-clock'></i> $from</span><span><i class='fa fa-clock'></i> $to</span><a href='#' class='delete' data-id='$mID'>حذف</a><a href='#' class='edit' data-id='$mID'>تعديل</a></li>";
            /*
        options
        - Open/Closed, Smoking/Non-Smoking, Capacity, Language, Map Pin (lat-long), CandleLight
        - Topic (dropdown), Days (dropdown), Time, Notes (free text)
        */
            endwhile;
        else :
            echo "<li>لا يوجد اي اجتماعات داخل هذه المجموعة</li>";
        endif;
        echo "</ul></div>";
    endwhile;
endif;
?>
<!-- <div class='msg'><strong>يرجي التاكد من صحة بيانات المجموعه بصورة منتظمة خصوصا العنوان واسم ممثل المجموعه</strong></div> -->
<a href="#" class="mAdd" data-id="<?php echo $group_id; ?>"><?php _e('اضف اجتماع جديد', 'NA'); ?></a>
<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/wMMXuKB0BoY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
<div class="mPopup"></div> <!-- .mPopup -->
<script type="text/javascript">
    $(document).ready(function() {
        $("a.edit, a.mAdd, a.delete").click(function(e) {
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
                    window.location.href = window.location.href + "/?delete=" + mID;
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