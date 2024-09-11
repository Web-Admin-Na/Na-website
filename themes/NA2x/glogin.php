<?php
/**
 * Template Name: gLogin
 */
get_header(); 
// echo "<pre>".print_r($_POST,1)."</pre>";
/////
// Result
/////
// Array
// (
//     [data] => Array
//         (
//             [func] => al_login
//             [cred] => Array
//                 (
//                     [user_login] => nn@nn.com
//                     [user_password] => abc@@@
//                 )
//         )
//     [gLogin] => تسجيل الدخول
// )
?>
<div id="main" class="container mb-50">
    <?php
    $l_error = 0;
    if (isset($_POST['data']['func'])) {
        // echo "<pre>".print_r($_POST['data'],1)."</pre>"; die;
        $return = na_custom_login($_POST['data']['cred']);
        if ($return['error'] == 1) {
            $l_error = 1;
        }
    }
    if (have_posts()) : while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    if ($l_error == 1) {
        _e("<p class='error login'>حدث خطأ، من فضلك حاول مره اخري", 'NA');
    }
    ?>
    <form action="" method="post" class="gLogin">
        <input type="hidden" name="data[func]" value="al_login">
        <p>
            <label><?php _e('البريد الالكتروني','NA'); ?></label>
            <input type="email" name="data[cred][user_login]" required>
        </p>
        <p>
            <label><?php _e('كلمة المرور','NA'); ?></label>
            <input type="password" name="data[cred][user_password]" required>
        </p>
        <input type="submit" name="gLogin" value="تسجيل الدخول" class="green">
    </form>
</div> <!-- #main -->
<?php get_footer(); ?>