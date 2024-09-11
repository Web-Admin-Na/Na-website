<?php
/**
 * Template Name: Edit Meeting
 *
 */
?>
<div class="form">
  <a href="#" class="pClose"><?php _e('[إغلاق]'); ?></a>
  <?php
  if (!isset($_GET['mID'])) {
    echo "ERROR!";
    die;
  }
  $mID         = $_GET['mID'];
  $meeting_obj = get_post($mID);
  // $title       = $meeting_obj->post_title;
  // TOPIC taxonomy
  $topic = wp_get_post_terms($mID, 'topic');
  $group = get_field('pgroup', $mID);
  $mtime  = get_field('mtime', $mID);
  // echo "<pre>".print_r($mtime,1)."</pre>";
  // foreach($time as $key => $value) {
  //     $time[$key] = date('h:i a', strtotime($value));
  // }
  // echo "<pre>".print_r($time,1)."</pre>";
  $misc  = get_field('misc', $mID);
  $weekday = get_field('day', $mID);
  $notes   = get_field('notes', $mID);
  ?>
  <h4><strong><?php _e('تعديل اجتماع'); ?></strong></h4>
  <div class="result"></div>
  <form id="edit_meeting" type="post">
    <p>
      <input type="hidden" name="ID" value="<?php echo $mID; ?>">
      <label><?php _e('الموضوع'); ?></label>
      <select name="topic" required>
        <option><?php _e('اختر الموضوع'); ?></option>
        <?php
        $topics = get_terms("topic", array('hide_empty' => 0, 'parent' => 0));
        foreach ($topics as $term) :
          $selected                                         = '';
          if ($topic[0]->term_id == $term->term_id) $selected = 'selected="selected"';
          echo "<option value='$term->term_id' $selected>$term->name</option>";
        endforeach;
        ?>
      </select>
    </p>
    <p>
      <label><?php _e('يوم الاجتماع'); ?></label>
      <select name="data[day]" required>
        <option><?php _e('اختر اليوم'); ?></option>
        <?php
        echo $weekday;
        foreach ($weekdays as $en => $ar) {
          $is_selected = '';
          if ($weekday == $ar) $is_selected = "selected='selected'";
          echo "<option $is_selected>$ar</option>";
        }
        ?>
      </select>
    </p>
    <p>
      <label><?php _e('ميعاد بدأ الاجتماع'); ?></label> <!-- convert to a normal select -->
      <input type="time" name="data[mtime][from]" class="timepicker" value="<?php echo $mtime['from']; ?>" required>
      <!-- <small><em>example: 8: 00pm - 9: 30pm</em></small> -->
    </p>
    <p>
      <label><?php _e('ميعاد إنتهاء الاجتماع'); ?></label> <!-- convert to a normal select -->
      <input type="time" name="data[mtime][to]" class="timepicker" value="<?php echo $mtime['to']; ?>" required>
      <!-- <small><em>example: 8: 00pm - 9: 30pm</em></small> -->
    </p>
    <p>
      <label><?php _e('السعه'); ?></label>
      <input type="number" name="data[misc][capacity]" alt="" value="<?php echo $misc['capacity']; ?>" min=0>
    </p>
    <p>
      <label><?php _e('اللغة'); ?></label>
      <select name="data[misc][lang]" required>
        <option><?php _e('اختر'); ?></option>
        <?php
        echo "<option";
        if ($misc['lang'] == "العربية") echo " selected='selected'";
        echo ">";
        _e('العربية');
        echo "</option>";
        echo "<option";
        if ($misc['lang'] == "الانجليزية") echo " selected='selected'";
        echo ">";
        _e('الانجليزية');
        echo "</option>";
        ?>
      </select>
    </p>
    <div class="clr"></div>
    <div class="misc">
      <label><?php _e('اخري'); ?></label>
      <div class="checkbox <?php if($misc['smoking']==1) echo "active"; ?>"><input type="hidden" name="data[misc][smoking]" value="<?php echo $misc['smoking']; ?>"><i class="fa fa-smoking"></i> <span data-true="مسموح بالتدخين" data-false="غير مسموح بالتدخين"></span></div>
      <div class="checkbox <?php if($misc['accessible']==1) echo "active"; ?>"><input type="hidden" name="data[misc][accessible]" value="<?php echo $misc['accessible']; ?>"><i class="fa fa-universal-access"></i> <span data-true="مجهز لذوي الاحتياجات الخاصه" data-false="غير مجهز لذوي الاحتياجات الخاصه"></div>
      <div class="checkbox <?php if($misc['open']==1) echo "active"; ?>"><input type="hidden" name="data[misc][open]" value="<?php echo $misc['open']; ?>"><i class="fa fa-circle-notch"></i> <span data-true="اجتماع مفتوح" data-false="اجتماع مغلق"></span></div>
      <div class="checkbox <?php if($misc['candle']==1) echo "active"; ?>"><input type="hidden" name="data[misc][candle]" value="<?php echo $misc['candle']; ?>"><i class="fa fa-fire"></i> <span data-true="علي ضوء الشموع" data-false="ليس علي ضوء الشموع"></span></div>
      <div class="checkbox <?php if($misc['parking']==1) echo "active"; ?>"><input type="hidden" name="data[misc][parking]" value="<?php echo $misc['parking']; ?>"><i class="fa fa-parking"></i> <span data-true="مسموح بالركن امام المكان" data-false="غير مسموح بالركن امام المكان"></span></div>
      <div>
        <label><?php _e('الملاحظات'); ?></label>
        <textarea name="data[notes]"><?php echo $notes; ?></textarea>
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
      var save_url = "<?php bloginfo('url'); ?>/svm/";
      $("#edit_meeting button").attr("disabled", true).css("backgroundColor", "#999");
      $.post(save_url,
        formData,
        function(data) {
          //alert("SUCCESS!");
          $("#edit_meeting button").attr("disabled", false).css("backgroundColor", "#44b215");
          // data = trim( data );
          if (data == "1") {
            $(".result").html("<p class='success'>تم حفظ التعديلات بنجاح</p>");
			window.location.href = "<?php bloginfo('url'); ?>/gadmin";
          } else {
            $(".result").html("<p class='error'>" + data + "</p>");
          }
        });
    });

    // $('.timepicker').timepicker({
    //   timeFormat: 'hh:mm p',
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