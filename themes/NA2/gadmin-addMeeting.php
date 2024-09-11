<?php
/**
 * Template Name: Add Meeting
 *
 */
if (!isset($_GET['gID'])) {
    echo "ERROR!";
    die;
  }
  $gID         = $_GET['gID'];
?>
<div class="form">
  <a href="#" class="pClose"><?php _e('[إغلاق]'); ?></a>
  <h4><strong>إضافة اجتماع جديد</strong></h4>
  <div class="result"></div>
  <form id="edit_meeting" type="post">
    <p>
      <input type="hidden" name="data[pgroup]" value="<?php echo $gID; ?>">
      <input type="hidden" name="func" value="addMeeting">
      <label>الموضوع</label>
      <select name="topic" required>
        <option value="">اختر الموضوع</option>
        <?php
        $topics = get_terms("topic", array('hide_empty' => 0, 'parent' => 0));
        foreach ($topics as $term) :
          echo "<option value='$term->term_id'>$term->name</option>";
        endforeach;
        ?>
      </select>
    </p>
    <p>
      <label>يوم الاجتماع</label>
      <select name="data[day]" required>
        <option value="">اختر اليوم</option>
        <?php
        foreach ($weekdays as $ar => $en) {
          echo "<option>$ar</option>";
        }
        ?>
      </select>
    </p>
    <p>
		<label>ميعاد بداية الاجتماع</label>
		<input type="time" lang="en-US" name="data[from]" value="" required>
      <!-- <small><em>example: 8:00pm - 9:30pm</em></small> -->
    </p>
    <p>
		<label>ميعاد إنتهاء الاجتماع</label>
		<input type="time" lang="en-US" name="data[to]" value="" required>
      <!-- <small><em>example: 8:00pm - 9:30pm</em></small> -->
    </p>
    <p>
      <label>السعه</label>
      <input type="number" name="data[capacity]" alt="" value="<?php echo $misc['capacity']; ?>" min=0>
    </p>
    <p>
      <label>اللغة</label>
      <select name="data[lang]" required>
        <!-- <option>اختر</option> -->
        <?php
            echo "<option>" . __('العربية') . "</option>";
            echo "<option>" . __('الانجليزية') . "</option>";
        ?>
      </select>
    </p>
    <div class="clr"></div>
    <div class="misc">
      <label>اخري</label>
      <div class="checkbox "><input type="hidden" name="data[smoking]" value=""><i class="fa fa-smoking"></i> <span data-true="مسموح بالتدخين" data-false="غير مسموح بالتدخين"></span></div>
      <div class="checkbox "><input type="hidden" name="data[accessible]" value=""><i class="fa fa-universal-access"></i> <span data-true="مجهز لذوي الاحتياجات الخاصه" data-false="غير مجهز لذوي الاحتياجات الخاصه"></div>
      <div class="checkbox "><input type="hidden" name="data[open]" value=""><i class="fa fa-circle-notch"></i> <span data-true="اجتماع مفتوح" data-false="اجتماع مغلق"></span></div>
      <div class="checkbox "><input type="hidden" name="data[candle]" value=""><i class="fa fa-fire"></i> <span data-true="علي ضوء الشموع" data-false="ليس علي ضوء الشموع"></span></div>
      <div class="checkbox "><input type="hidden" name="data[parking]" value=""><i class="fa fa-parking"></i> <span data-true="مسموح بالركن امام المكان" data-false="غير مسموح بالركن امام المكان"></span></div>
      <div>
        <label>الملاحظات</label>
        <textarea name="data[notes]"></textarea>
      </div>
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
    $(".checkbox").each(function() {
      switchLabel($(this));
    });

    $("#edit_meeting").submit(function(e) {
      e.preventDefault();
      var formData = $(this).serializeArray();
      var save_url = "<?php bloginfo('url'); ?>/sv_func/";
      $("#edit_meeting button").attr("disabled", true).css("backgroundColor", "#999");
      $.post(save_url,
        formData,
        function(data) {
          //alert("SUCCESS!");
          $("#edit_meeting button").attr("disabled", false).css("backgroundColor", "#44b215");
          // data = trim( data );
          if (data == "1") {
            $(".result").html("<p class='success'>تم حفظ الاجتماع بنجاح</p>");
			window.location.href = "<?php bloginfo('url'); ?>/gadmin/";
          } else {
            $(".result").html("<p class='error'>" + data + "</p>");
          }
        });
    });

    // $('.timepicker').timepicker({
    //   timeFormat: 'h:mm p',
    //   interval: 15,
    //   defaultTime: '12',
    //   dynamic: true,
    //   dropdown: true,
    //   scrollbar: false
    // });

    $(".checkbox").click(function(e) {
      $(this).toggleClass('active');
      switchLabel($(this));
      if ($(this).hasClass('active')) {
        $(this).children('input[type="hidden"]').val(1);
      } else {
        $(this).children('input[type="hidden"]').val(0);
      }
    });
  });
</script>