<?php
/*
Template Name: export csv
*/

mb_internal_encoding('UTF-8');

  function get_meetings_arr($day)
  {

      $csv_lines = array();

      $m_args = array(
          'post_type' => 'meeting',
          'meta_query' => array(
              array(
                  'key' => 'day',
                  'value' => $day
              )
          ),
          'posts_per_page' => -1
      );

      $m_query = new WP_Query($m_args);

      while ($m_query->have_posts()) : $m_query->the_post();

          $pgroup = get_field('pgroup');
          $group_post = get_post($pgroup);

        //   echo "<pre>".print_r($pgroup,1)."</pre>"; die;
          $topic = wp_get_post_terms(get_the_ID(), 'topic');

        //   $csv_line['ID'] = get_the_ID();
          $csv_line['day'] = get_field('day');
          $csv_line['topic'] = $topic[0]->name;
          $csv_line['group'] = $group_post->post_title;
          $contact_info = get_field('contact_info', $pgroup);
          $csv_line['address'] = $contact_info['address'];
          $csv_line['contact_person'] = $contact_info['contact_person'];
          $csv_line['contact_number'] = $contact_info['contact_number'];

          $geo = get_meeting_geo( $pgroup );

          $csv_line['area'] = $geo['area'];
          $csv_line['city'] = $geo['city'];

          $fromf = get_field('from', false, false, false);
          $tof = get_field('to', false, false, false);

          $csv_line['from'] = date("g:i A", strtotime($fromf));
          $csv_line['to'] = date("g:i A", strtotime($tof));
	      $csv_line['open'] = (get_field('open')==1)? "مفتوح" : "مغلق";
          $csv_line['lang'] = get_field('lang');
          $csv_line['capacity'] = get_field('capacity');
          $csv_line['smoking'] = (get_field('smoking')==1)? "مسموح" : "غير مسموح";
          $csv_line['accessible'] = (get_field('accessible')==1)? "مجهز" : "غير مجهز";
          $csv_line['candle'] = (get_field('candle')==1)? "علي ضوء الشموع" : ".";
          $csv_line['parking'] = (get_field('parking')==1)? "يوجد" : "لا يوجد";
          $csv_line['notes'] = get_field('notes');
          
          $csv_lines[] = $csv_line;

      endwhile;

    //   echo "<pre>".print_r($csv_line,1)."</pre>------<br>";
      return $csv_lines;

  }
  $csv_head = array("اليوم","الموضوع","المجموعة","العنوان","المسؤول","الموبايل","المنطقة","المدينة","الوقت من","الوقت الي","مفتوح/مغلق","اللغة","السعة","التدخين","مجهز لذوي الاحتياجات","علي ضوء الشموع","التدخين","باركينج","ملاحظات");
  $csv_arr0 = array($csv_head);

  $csv_arr1 = get_meetings_arr('السبت');
  $csv_arr2 = get_meetings_arr('الاحد');
  $csv_arr3 = get_meetings_arr('الاثنين');
  $csv_arr4 = get_meetings_arr('الثلاثاء');
  $csv_arr5 = get_meetings_arr('الاربعاء');
  $csv_arr6 = get_meetings_arr('الخميس');
  $csv_arr7 = get_meetings_arr('الجمعة');
  
  $csv_final = array_merge($csv_arr0, $csv_arr1, $csv_arr2, $csv_arr3, $csv_arr4, $csv_arr5, $csv_arr6, $csv_arr7);

//   echo "<pre>".print_r($csv_final,1)."</pre>";

  function array2csv(array &$array)
  {
      if (count($array) == 0) {
          return null;
      }
      ob_start();
      $df = fopen("php://output", 'w');
      fputcsv($df, array_keys(reset($array)));
      foreach ($array as $row) {
          fputcsv($df, $row);
      }
      fclose($df);
      return ob_get_clean();
  }

  function download_send_headers($filename) {
      // disable caching
      $now = gmdate("D, d M Y H:i:s");
      header('Content-Encoding: UTF-8');
      header("Content-Type: text/csv; charset=UTF-8");
    //   header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
      header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
      header("Last-Modified: {$now} GMT");
      // force download  
    //   header("Content-Type: application/force-download");
    //   header("Content-Type: application/octet-stream");
    //   header("Content-Type: application/download");

      // disposition / encoding on response body
      header("Content-Disposition: attachment; filename={$filename}");
      header("Content-Transfer-Encoding: binary");
      echo "\xEF\xBB\xBF"; // UTF-8 BOM

  }

  download_send_headers("meetings_export_" . date("Y-m-d") . ".csv");

  echo array2csv($csv_final);

  exit;

?>