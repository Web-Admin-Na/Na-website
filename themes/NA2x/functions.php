<?php

add_theme_support( 'post-thumbnails', array( 'post' ) );

//ADD MENU SUPPORT
add_theme_support( 'menus' );
register_nav_menu('main', 'Main Navigation Menu');
register_nav_menu('footer', 'Footer Menu');

/*******************************************************************************************
 * Accordion
 *
 *
 [accordions]
    [accordion title='title']Accordion Content[/accordion]
    [accordion title='title']Accordion Content[/accordion]
    [accordion title='title']Accordion Content[/accordion]
[/accordions]
********************************************************************************************/
function accordions_function( $atts, $content = null) {
	$html = '
	<script>
		$(function() {
			$( ".accordion" ).accordion();
		});
	</script>';
	$html .= '<div class="accordion">';
	$html .= do_shortcode($content);
	$html .= '</div>';
	return $html;
}
add_shortcode("accordions", "accordions_function");

function accordion_function( $atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"content" => ''
	), $atts));
	$html = "<h4><a href='#'>$title</a></h4><div>";
	$html .= $content;
	$html .= "</div>";
	return $html;
}
add_shortcode("accordion", "accordion_function");
/*******************************************************************************************
 * Toggle
 *
 *
 [toggle id="" title="title"]Content ....[/toggle]
********************************************************************************************/
function toggle_function( $atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => '',
		"title" => ''
	), $atts));
	$html = "<div class='toggle' id='$id'><h3>$title</h3>";
	$html .= "<div style='display:none'>";
	$html .= do_shortcode($content);
	$html .= "</div></div>";
	$html .= '
	<script>
		$("#'.$id.' h3").click(function(){
			$("#'.$id.' div").slideToggle("slow");
			$("#'.$id.'").toggleClass("toggle-open");
			$("#'.$id.' h3").toggleClass("open");
		});
	</script>';
	return $html;
}
add_shortcode("toggle", "toggle_function");
/********************************************************************************************/
/********************************************************************************************/
function custom_remove_menu_pages() {
	remove_menu_page('link-manager.php');
	remove_menu_page('tools.php');
	remove_menu_page('edit-comments.php');
	//remove_menu_page('users.php');
	remove_menu_page('plugins.php');
	//remove_menu_page('themes.php');
	//remove_menu_page('options-general.php');
}

include(TEMPLATEPATH . '/core/CPTs.php');
include(TEMPLATEPATH . '/core/bulk_edit.php');
include(TEMPLATEPATH . '/core/admin_options.php');

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( '. Read More...', 'textdomain' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

$homeURL = get_bloginfo( 'url' );

$topics_arr = array(
	"Beginner/Newcomer" => "العضو الجديد	",
	"Basic Text" => "النص الاساسي",
	"12 Concepts" => "المفاهيم ١٢",
	"IP Study" => "دراسة كتيبات",
	"It Works Study" => "كيف يعمل",
	"Just For Today Study" => "لليوم فقط",
	"Living Clean Study" => "العيش نظيف",
	"Literature Study" => "دراسه كتاب",
	"Meditation" => "تأمل",
	"Questions & Answers" => "سؤال وجواب	",
	"Speaker" => "متحدث",
	"Steps" => "خطوات",
	"Step Working Guide Study" => "مرشد عمل الخطوات",
	"Topic" => "مووضوع من القائمة",
	"Tradition" => "تقاليد",
	"Format Varies" => "متنوع",
	"Young People" => "صغار السن"
);
$weekdays = array(
	"Saturday" => "السبت",
	"Sunday" => "الاحد",
	"Monday" => "الاثنين",
	"Tuesday" => "الثلاثاء",
	"Wednesday" => "الاربعاء",
	"Thursday" => "الخميس",
	"Friday" => "الجمعة"
);
function pr($array = array()){
	echo "<pre>".print_r( $array, 1 )."</pre>";
}

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title'     => 'NAEgypt Options',
        'menu_title'    => 'NAEgypt Settings',
        'menu_slug'     => 'naegypt-general-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false
    ));

}

/************
User Login
************/
function na_custom_login( $creds = array() ) {
	$user = wp_signon( $creds, false );
	if ( is_wp_error( $user ) ) {
		return array(
			'error' => 1,
			'msg' => $user->get_error_message()
		);
		// echo 0;
	} else {
		$gadmin = get_pages(array(
		    'meta_key' => '_wp_page_template',
		    'meta_value' => 'gadmin.php'
		));
		$gadmin = get_permalink( $gadmin[0]->ID );
		wp_redirect( $gadmin );
	}
}
/************
Get page permalink by page template 
************/
function get_temp_permalink($temp) {
    $args = [
        'post_type' => 'page',
        'fields' => 'ids',
        'nopaging' => true,
        'meta_key' => '_wp_page_template',
        'meta_value' => $temp
    ];
    $page = get_pages($args);
    return get_permalink($page[0]->ID);
}
/************
Delete Meeting
************/
function delete_meeting($id)
{
    $x = wp_delete_post($id);
    if ($x) echo "<p class='success login'>تم حدف الاجتماع</p>";
}
