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
$contact_info_en = get_field('contact_info', $translation_id);

// will return the category ID in the current language for categoy ID 4. If the translation is missing it will return the original (here: category ID 4)
// echo apply_filters( 'wpml_object_id', 4, 'category', TRUE  );

// // will return the German attachment ID for attachment ID 25. If the translation is missing it will return NULL
// echo apply_filters( 'wpml_object_id', 25, 'attachment', FALSE, 'de' );

?>
<div class="form">
    <a href="#" class="pClose">[إغلاق]</a>
    <h4><strong>تعديل بيانات المجموعة</strong></h4>
    <div class="result"></div>
    <form id="edit_meeting" type="post">
        <input type="hidden" name="gID" value="<?php echo $gID; ?>">
        <input type="hidden" name="gID_tr" value="<?php echo $translation_id; ?>">
        <input type="hidden" name="func" value="editGroup">
        <div class="ar">
            <h6>بيانات الاتصال بالعربية</h6>
            <label>اسم ممثل المجموعة</label><input type="text" name="data[contact_info][contact_person]" value="<?php echo $contact_info['contact_person']; ?>" required>
            <label>رقم ممثل المجموعة</label><input type="tel" name="data[contact_info][contact_number]" value="<?php echo $contact_info['contact_number']; ?>" required>
            <label>عنوان المجموعة</label><textarea name="data[contact_info][address]" row="3" required><?php echo $contact_info['address']; ?></textarea>

        </div>
        <div class="en">
            <h6>بيانات الاتصال بالانجليزية</h6>
            <label>GSR Name</label><input type="text" name="en[contact_info][contact_person]" value="<?php echo $contact_info_en['contact_person']; ?>" required>
            <label>GSR Number</label><input type="tel" name="en[contact_info][contact_number]" value="<?php echo $contact_info_en['contact_number']; ?>" required>
            <label>Group Address</label><textarea name="en[contact_info][address]" rows="3" required><?php echo $contact_info_en['address']; ?></textarea>
        </div>
        <input type="hidden" name="data[lat]" value="<?php echo $lat; ?>">
        <input type="hidden" name="data[lng]" value="<?php echo $lng; ?>">
        <input type="hidden" name="en[lat]" value="<?php echo $lat; ?>">
        <input type="hidden" name="en[lng]" value="<?php echo $lng; ?>">

        <div class="clr"></div>
        <!-- google maps location selector -->
        <a class="getLocation" onclick="getLocation()"><i class="fa fa-map-marker"></i> اضغط هنا عندما تكون متواجد في عنوان المجموعة لحفظ الموقع</a>
        <p id="demo"></p>
        <button>حفظ</button>
    </form>
</div> <!-- .form -->
<script type="text/javascript">
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            x.innerHTML = "نظام تحديد الموقع ليس مفعل علي متصفحك";
        }
    }

    function showPosition(position) {
        // x.innerHTML = "Latitude: " + position.coords.latitude +  "<br>Longitude: " + position.coords.longitude;
        x.innerHTML = "شكرا، تم تحديد الموقع";

        $("input[name='data[lat]'], input[name='en[lat]']").val(position.coords.latitude);
        $("input[name='data[lng]'], input[name='en[lng]']").val(position.coords.longitude);
    }
    $(document).ready(function() {
        $("#edit_meeting").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serializeArray();
            var save_url = "<?php bloginfo('url'); ?>/sv_func/";
            $("#edit_meeting button").attr("disabled", true).css("backgroundColor", "#999");
            $.post(save_url,
                formData,
                function(data) {
                    $("#edit_meeting button").attr("disabled", false).css("backgroundColor", "#44b215");
                    if (data == "1") {
                        $(".result").html("<p class='success'>تم حفظ التعديلات بنجاح</p>");
						window.location.href = "<?php bloginfo('url'); ?>/gadmin";
                    } else {
                        $(".result").html("<p class='error'>" + data + "</p>");
                    }
                });
        });
    });
</script>