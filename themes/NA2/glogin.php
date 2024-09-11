<?php
/**
 * Template Name: gLogin
 */
$l_error = 0;
if (isset($_POST['data']['func'])) {
    // echo "<pre>".print_r($_POST['data'],1)."</pre>"; die;
    $return = na_custom_login($_POST['data']['cred']);
    if ($return['error'] == 1) {
        $l_error = 1;
    }
}
get_header(); 

// $blogusers = get_users( );

// function password_generate($chars) 
// {
//   $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
//   return substr(str_shuffle($data), 0, $chars);
// }


// foreach ( $blogusers as $user ) {

//     // echo "<pre>".print_r($user,1)."</pre>";
//     $password = password_generate(6);

//     $user_data = wp_update_user( array( 'ID' => $user->ID, 'user_pass' => $password ) );
    
//     if ( is_wp_error( $user_data ) ) {
//         // There was an error; possibly this user doesn't exist.
//         echo "U: ".$user->user_login."Error.<br>";
//     } else {
//         // Success!
//         echo "Email: " . $user->user_login . " - P: " . $password."<br>";
//     }

// }
?>
<div id="main" class="container mb-50">
    <?php
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
            <label>البريد الالكتروني</label>
            <input type="email" name="data[cred][user_login]" required>
        </p>
        <p>
            <label>كلمة المرور</label>
            <input type="password" name="data[cred][user_password]" required>
        </p>
        <input type="submit" name="gLogin" value="تسجيل الدخول" class="green">
    </form>
</div> <!-- #main -->
<?php get_footer(); ?>