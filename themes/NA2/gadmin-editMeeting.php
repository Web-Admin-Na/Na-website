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
  $topic = get_the_terms($mID, 'topic');
  $group = get_field('pgroup', $mID);
  $from  = get_field('from', $mID);
  $to  = get_field('to', $mID);
  
   //echo "<pre>".print_r($mtime,1)."</pre>";
   foreach($time as $key => $value) {
       $time[$key] = date('h:i A', strtotime($value));
   }
   //echo "<pre>".print_r($time,1)."</pre>";

  $lang  = get_field('lang', $mID);
  $capacity  = get_field('capacity', $mID);
  $smoking  = get_field('smoking', $mID);
  $accessible  = get_field('accessible', $mID);
  $open  = get_field('open', $mID);
  $candle  = get_field('candle', $mID);
  $parking  = get_field('parking', $mID);

  $weekday = get_field('day', $mID);
  $notes   = get_field('notes', $mID);
  ?>
  <h4><strong>تعديل اجتماع</strong></h4>
  <div class="result"></div>
  <form id="edit_meeting" type="post">
    <p>
      <input type="hidden" name="ID" value="<?php echo $mID; ?>">
      <input type="hidden" name="func" value="editMeeting">
      <label>الموضوع</label>
      <select name="topic" required>
        <option value="">اختر الموضوع</option>
        <?php
        $topics = get_terms("topic", array('hide_empty' => 0, 'parent' => 0));
        foreach ($topics as $term) :
          $selected = '';
          if ($topic[0]->term_id == $term->term_id) $selected = 'selected="selected"';
          echo "<option value='$term->term_id' $selected>$term->name</option>";
        endforeach;
        ?>
      </select>
    </p>
    <p>
      <label>يوم الاجتماع</label>
      <select name="data[day]" required>
        <option value="">اختر اليوم</option>
        <?php
        echo $weekday;
        foreach ($weekdays as $ar => $en) {
          $is_selected = '';
          if ($weekday == $ar) $is_selected = "selected='selected'";
          echo "<option $is_selected>$ar</option>";
        }
        ?>
      </select>
    </p>
    <p>
      <label>ميعاد بداية الاجتماع</label> <!-- convert to a normal select -->
      <input type="time" lang="en-US" name="data[from]" value="<?php echo $from; ?>" required>
      <!-- <input type="time" name="data[mtime][from]" class="timepicker" value="<? echo $from; ?>" required> -->
      <!-- <small><em>example: 8: 00pm - 9: 30pm</em></small> -->
    </p>
    <p>
      <label>ميعاد إنتهاء الاجتماع</label> <!-- convert to a normal select -->
      <input type="time" lang="en-US" name="data[to]" value="<?php echo $to; ?>" required>
      <!-- <input type="time" name="data[mtime][to]" class="timepicker" value="<?php echo $to; ?>" required> -->
      <!-- <small><em>example: 8: 00pm - 9: 30pm</em></small> -->
    </p>
    <p>
      <label>السعه</label>
      <input type="number" name="data[capacity]" alt="" value="<?php echo $capacity; ?>" min=0>
    </p>
    <p>
      <label>اللغة</label>
      <select name="data[lang]" required>
        <?php
        echo "<option";
        if ($lang == "العربية") echo " selected='selected'";
        echo ">";
        _e('العربية');
        echo "</option>";
        echo "<option";
        if ($lang == "الانجليزية") echo " selected='selected'";
        echo ">";
        _e('الانجليزية');
        echo "</option>";
        ?>
      </select>
    </p>
    <div class="clr"></div>
    <div class="misc">
      <label>اخري</label>
      <div class="checkbox <?php if($smoking==1) echo "active"; ?>"><input type="hidden" name="data[smoking]" value="<?php echo $smoking; ?>"><i class="fa fa-smoking"></i> <span data-true="مسموح بالتدخين" data-false="غير مسموح بالتدخين"></span></div>
      <div class="checkbox <?php if($accessible==1) echo "active"; ?>"><input type="hidden" name="data[accessible]" value="<?php echo $accessible; ?>"><i class="fa fa-universal-access"></i> <span data-true="مجهز لذوي الاحتياجات الخاصه" data-false="غير مجهز لذوي الاحتياجات الخاصه"></div>
      <div class="checkbox <?php if($open==1) echo "active"; ?>"><input type="hidden" name="data[open]" value="<?php echo $open; ?>"><i class="fa fa-circle-notch"></i> <span data-true="اجتماع مفتوح" data-false="اجتماع مغلق"></span></div>
      <div class="checkbox <?php if($candle==1) echo "active"; ?>"><input type="hidden" name="data[candle]" value="<?php echo $candle; ?>"><i class="fa fa-fire"></i> <span data-true="علي ضوء الشموع" data-false="ليس علي ضوء الشموع"></span></div>
      <div class="checkbox <?php if($parking==1) echo "active"; ?>"><input type="hidden" name="data[parking]" value="<?php echo $parking; ?>"><i class="fa fa-parking"></i> <span data-true="مسموح بالركن امام المكان" data-false="غير مسموح بالركن امام المكان"></span></div>
      <div>
        <label>الملاحظات</label>
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
      var save_url = "<?php bloginfo('url'); ?>/sv_func/";
      $("#edit_meeting button").attr("disabled", true).css("backgroundColor", "#44b215");
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