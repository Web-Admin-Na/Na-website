<div id="sidebar" class="three columns mSidebar">
    <?php
    if (!is_page('na-meetings')) {
        $helpline = get_field('helpline', 'option');
        ?>
        <div class="helpline" itemscope itemtype="http://schema.org/Organization">
            <h3 class="mb-10"><?php echo $helpline['headline'] ?></h3>
            <p class="large mb-10">
                <a href="tel:<?php echo $helpline['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][0]['number']; ?></a>
                <a href="tel:<?php echo $helpline['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][1]['number']; ?></a>
            </p>
            <small><?php echo $helpline['time_range']; ?></small>
            <p class="nmb"><a href="mailto:<?php echo $helpline['email']; ?>" itemprop="email"><?php echo $helpline['email']; ?></a></p>
        </div> <!-- .helpline -->
        <?php
            $announcements = get_field('announcements', 'option');
            if (!empty($announcements)) {
                echo '<div class="announcement"><h3>' . $announcements["title"] . '</h3>';
                echo '<p>' . $announcements["body"] . '</p>';
                $alink = $announcements["link"];
                if (!empty($alink)) echo "<a href='$alink'>";
                _e('تحميل', 'NA');
                echo "</a>";
                echo "</div> <!-- .announcement -->";
            }
            /* Banner */
            // $na_ebiurl = get_option('na_ebiurl');
            // $na_eblink = get_option('na_eblink');
            // if( !empty( $na_ebiurl ) ) echo "<a href='$na_eblink' class='mb-20'><img src='$na_ebiurl'></a>";
            /* Share Plugin */
            ?>
    <?php } else { ?>
        <div class="greenLinkBox">
            <h3 class="nmb"><a href="<?php echo esc_url(home_url('/na-meetings/recovery-meetings-schedule/')); ?>" class="green"><strong>جدول اجتماعات التعافي</strong></a></h3>
        </div> <!-- .helpline -->
        <div class="grayLinkBox">
            <h3 class="nmb"><a href="<?php echo esc_url(home_url('/na-meetings/service-committee-meetings/')); ?>"><strong>اجتماعات اللجان الخدمية</strong></a></h3>
        </div> <!-- .announcement -->
        <div class="helpline" itemscope itemtype="http://schema.org/Organization">
            <h3 class="mb-10"><?php echo $helpline['headline'] ?></h3>
            <p class="large mb-10">
                <a href="tel:<?php echo $helpline['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][0]['number']; ?></a><br>
                <a href="tel:<?php echo $helpline['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][1]['number']; ?></a>
            </p>
            <small><?php echo $helpline['time_range']; ?></small>
            <p class="nmb"><a href="mailto:<?php echo $helpline['email']; ?>" itemprop="email"><?php echo $helpline['email']; ?></a></p>
        </div> <!-- .helpline -->
    <?php } ?>
</div> <!-- #sidebar -->