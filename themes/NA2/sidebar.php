<div id="sidebar" class="three columns mSidebar">
        <div class="greenLinkBox">
            <h3 class="nmb"><a href="<?php echo esc_url(home_url('/na-meetings/recovery-meetings-schedule/')); ?>" class="green"><strong><?php _e('Recovery meetings schedule', 'NA'); ?></strong></a></h3>
        </div> <!-- .helpline -->
        <div class="grayLinkBox">
            <h3 class="nmb"><a href="<?php echo esc_url(home_url('/na-meetings/service-committees-meetings/')); ?>"><strong><?php _e('Service meetings schedule', 'NA'); ?></strong></a></h3>
        </div> 
        <?php $helpline = get_field('helpline', 'option'); ?>
        <div class="helpline" itemscope itemtype="http://schema.org/Organization">
                <h3 class="mb-10"><?php echo $helpline['headline'] ?></h3>
                <p class="large mb-10" style="direction:ltr;">
                    <a href="tel:<?php echo $helpline['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][0]['number']; ?></a><br>
                    <a href="tel:<?php echo $helpline['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][1]['number']; ?></a>
                </p>
                <small><?php echo $helpline['time_range']; ?></small>
                <p class="nmb"><a href="mailto:<?php echo $helpline['email']; ?>" itemprop="email"><?php echo $helpline['email']; ?></a></p>
        </div> <!-- .helpline -->
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
</div> <!-- #sidebar -->