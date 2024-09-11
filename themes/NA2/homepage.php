<?php

/**
 * Template Name: Home Page
 *
 */
get_header(); 
// Prepare pages
$meetings = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'meetings.php'
));
$meetings_url = get_permalink($meetings[0]->ID );
$meetings_label = $meetings[0]->post_title;

$events = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'events.php'
));
$events_url = get_permalink($events[0]->ID );
$events_label = $events[0]->post_title;

$contact = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'contactus.php'
));
$contact_url = get_permalink($contact[0]->ID );
$contact_label = $contact[0]->post_title;

$literature = home_url('/literature/');
if( ICL_LANGUAGE_CODE == 'en' ) $literature = "https://na.org/literature/recovery-literature-in-english-usa/";
?>
<div id="main" class="mb-50">
    <div class="container mb-30">
        <h1 class="centerTxt"><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
  <div class="container">
    <div class="six columns">
            <?php $helpline = get_field('helpline', 'option'); ?>
            <div class="helpline" itemscope itemtype="http://schema.org/Organization">
                <h3 class="mb-10"><?php echo $helpline['headline'] ?></h3>
                <p class="large mb-10" style="direction:ltr;">
                    <a href="tel:<?php echo $helpline['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][0]['number']; ?></a><br>
                    <a href="tel:<?php echo $helpline['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][1]['number']; ?></a></p>
					<h4 class="mb-10"><?php echo $helpline['headline2'] ?></h4>
				<p class="large mb-10" style="direction:ltr;">
					<a href="tel:<?php echo $helpline['numbers'][2]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][2]['number']; ?></a>
                </p>
                <small><?php echo $helpline['time_range']; ?></small>
                <p class="nmb"><a href="mailto:<?php echo $helpline['email']; ?>" itemprop="email"><?php echo $helpline['email']; ?></a></p>
            </div> <!-- .helpline -->
        
    </div>
    <div class="six columns">
  <?php 
                // echo "<a href='$meetings_url' class='btnBox'>$meetings_label</a>"; 
                echo "<a href='https://naegypt.org/na-meetings/recovery-meetings-schedule/?lang=".ICL_LANGUAGE_CODE."' class='btnBox'>".__('Recovery meetings schedule', 'NA')." <i class='fa-solid fa-table-list'></i></a>"; 
                echo "<a href='$literature' class='btnBox'";
                if( ICL_LANGUAGE_CODE == 'en' ) echo " target='_blank'";
                echo ">".__('Literature', 'NA')." <i class='fa-solid fa-book-open'></i></a>"; 
?>
    </div>
    
      <?php
              //  echo "<a href='$events_url' class='btnBox'>$events_label <i class='fa-solid fa-calendar-days'></i></a>";
              //  echo "<a href='$contact_url' class='btnBox'>$contact_label <i class='fa-solid fa-envelope'></i></a>";
            ?>
 
  </div>
    <div class="container">
      <div class="six columns">
          <?php $helpline3 = get_field('helpline_copy2', 'option'); ?>
            <div class="helpline" itemscope itemtype="http://schema.org/Organization">
                <h3 class="mb-10"><?php echo $helpline3['headline'] ?></h3>
                <p class="large mb-10" style="direction:ltr;">
                    <a href="tel:<?php echo $helpline3['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline3['numbers'][0]['number']; ?></a><br>
                    <a href="tel:<?php echo $helpline3['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline3['numbers'][1]['number']; ?></a></p>
					<h4 class="mb-10"><?php echo $helpline3['headline2'] ?></h4>
				<p class="large mb-10" style="direction:ltr;">
					<a href="tel:<?php echo $helpline3['numbers'][2]['number']; ?>" itemprop="telephone"><?php echo $helpline3['numbers'][2]['number']; ?></a>
                </p>
                <small><?php echo $helpline3['time_range']; ?></small>
                <p class="nmb"><a href="mailto:<?php echo $helpline3['email']; ?>" itemprop="email"><?php echo $helpline3['email']; ?></a></p>
            </div> <!-- .helpline -->
        </div>

        <div class="six columns">
            <?php $helpline2 = get_field('helpline_copy', 'option'); ?>
            <div class="helpline" itemscope itemtype="http://schema.org/Organization">
                <h3 class="mb-10"><?php echo $helpline2['headline'] ?></h3>
                <p class="large mb-10" style="direction:ltr;">
                    <a href="tel:<?php echo $helpline2['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline2['numbers'][0]['number']; ?></a><br>
                    <a href="tel:<?php echo $helpline2['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline2['numbers'][1]['number']; ?></a></p>
					<h4 class="mb-10"><?php echo $helpline2['headline2'] ?></h4>
				<p class="large mb-10" style="direction:ltr;">
					<a href="tel:<?php echo $helpline2['numbers'][2]['number']; ?>" itemprop="telephone"><?php echo $helpline2['numbers'][2]['number']; ?></a>
                </p>
                <small><?php echo $helpline2['time_range']; ?></small>
                <p class="nmb"><a href="mailto:<?php echo $helpline2['email']; ?>" itemprop="email"><?php echo $helpline2['email']; ?></a></p>
            </div> <!-- .helpline -->
        </div>

     </div>
</div> <!-- #main -->
<?php get_footer(); ?>