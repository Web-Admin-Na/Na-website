<?php

/**
 * Template Name: Edit Group
 *
 * owner
 * contact_info
 * * address
 * * contact_person
 * * contact_number
 * location (gmap)
 */
if (!isset($_GET['gID'])) {
    echo "ERROR!";
    die;
}
$gID = $_GET['gID'];
$contact_info = get_field('contact_info', $gID);


// will return the post ID in the current language for post ID 1
$translation_id = apply_filters('wpml_object_id', $gID, 'group', FALSE, 'en');

// will return the category ID in the current language for categoy ID 4. If the translation is missing it will return the original (here: category ID 4)
// echo apply_filters( 'wpml_object_id', 4, 'category', TRUE  );

// // will return the German attachment ID for attachment ID 25. If the translation is missing it will return NULL
// echo apply_filters( 'wpml_object_id', 25, 'attachment', FALSE, 'de' );

?>
<div class="form">
    <a href="#" class="pClose"><?php _e('[إغلاق]'); ?></a>
    <h4><strong><?php _e('تعديل بيانات المجموعة'); ?></strong></h4>
    <div class="result"></div>
    <form id="edit_meeting" type="post">
        <input type="hidden" name="gID" value="<?php echo $gID; ?>">
        <input type="hidden" name="gID_tr" value="<?php echo $translation_id; ?>">
        <input type="hidden" name="func" value="editGroup">
        <div class="ar">
            <h6>بيانات الاتصال بالعربية</h6>
            <label><?php _e('اسم ممثل المجموعة', 'NA'); ?></label><input type="text" name="data[contact_info][contact_person]" value="<?php echo $contact_info['contact_person']; ?>" required>
            <label><?php _e('رقم ممثل المجموعة', 'NA'); ?></label><input type="tel" name="data[contact_info][contact_number]" value="<?php echo $contact_info['contact_number']; ?>" required>
            <label><?php _e('عنوان المجموعة', 'NA'); ?></label><textarea name="data[contact_info][address]" row="3" required><?php echo $contact_info['address']; ?></textarea>

        </div>
        <div class="en">
            <h6>بيانات الاتصال بالانجليزية</h6>
            <label><?php _e('GSR Name', 'NA'); ?></label><input type="text" name="en[contact_info][contact_person]" value="<?php echo $contact_info['contact_person']; ?>" required>
            <label><?php _e('GSR Number', 'NA'); ?></label><input type="tel" name="en[contact_info][contact_number]" value="<?php echo $contact_info['contact_number']; ?>" required>
            <label><?php _e('Group Address', 'NA'); ?></label><textarea name="en[contact_info][address]" rows="3" required><?php echo $contact_info['address']; ?></textarea>

        </div>
        <div class="clr"></div>
        <!-- google maps location selector -->
        <a href="" class="getLocation"><i class="fa fa-map-marker"></i> اضغط هنا عندما تكون متواجد في عنوان المجموعة لحفظ الموقع</a>
        <button>حفظ</button>
    </form>
</div> <!-- .form -->
<script type="text/javascript">
    function switchLabel(checkbox) {
        var dataTrue = $(checkbox).children('span').attr('data-true');
        var dataFalse = $(checkbox).children('span').attr('data-false');
        if ($(checkbox).hasClass('active')) {
            $(checkbox).children('span').text(dataTrue);
        } else {
            $(checkbox).children('span').text(dataFalse);
        }
    };

    $(document).ready(function() {
        $("#edit_meeting").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serializeArray();
            var save_url = "<?php bloginfo('url'); ?>/svm/";
            $("#edit_meeting button").attr("disabled", true).css("backgroundColor", "#999");
            $.post(save_url,
                formData,
                function(data) {
                    //alert("SUCCESS!");
                    $("#edit_meeting button").attr("disabled", false).css("backgroundColor", "#44b215");
                    // data = trim( data );
                    if (data == "1") {
                        $(".result").html("<p class='success'>تم حفظ الاجتماع بنجاح</p>");
						window.location.href = "<?php bloginfo('url'); ?>/gadmin";
                    } else {
                        $(".result").html("<p class='error'>" + data + "</p>");
                    }
                });
        });
    });
</script>