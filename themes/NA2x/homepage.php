<?php

/**
 * Template Name: Home Page
 *
 */
get_header(); ?>
<div id="main" class="mb-50">
    <div class="container mb-30">
        <h1 class="centerTxt"><?php _e('زمالة المدمنين المجهولين مصر', 'NA'); ?></h1>
        <p class="centerTxt">برنامج زمالة المدمنين المجهولين هو زمالة أو جمعية لا تهدف إلى الربح وتتكون من رجال ونساء أصبحت المخدرات مشكلة رئيسية بالنسبة لهم فنحن مدمنون نتعافى ونجتمع معاً بانتظام لنساعد بعضنا البعض كي نبقى ممتنعين. إنه برنامج للامتناع التام عن كافة أنواع المخدرات وعضويته لا تتطلب إلا شيئاً واحداً وهو الرغبة في الامتناع عن التعاطي، نقترح عليك أن تكون متفتحاً ذهنياً وتعطي نفسك فرصة، برنامجنا عبارة عن مجموعة من المبادئ مكتوبة ببساطة شديدة ونستطيع إتباعها فى حياتنا اليومية وأهم ما يميزها هوأنها ناجحة. لا توجد قيود على زمالة المدمنين المجهولين فنحن غير منتسبين لأية منظمات أخرى وليس لنا أية رسوم إشتراك أو مستحقات ولا نوقع تعهدات ولا نقدم وعوداً لأي شخص ولا صلة لنا بأية جهة سياسية أو دينية أو بأجهزة تطبيق القانون ولا نخضع للمراقبة إطلاقاً. يستطيع أي شخص أن ينضم لنا بغض النظر عن عمره أو جنسه أو هويته الجنسية أو عقيدته أو ديانته أوإفتقاره إلى الدين.</p>
    </div>
    <div class="container">
        <div class="four columns">
            <a href="<?php echo esc_url(home_url('/na-meetings/recovery-meetings-schedule/')); ?>" class="btnBox">جدول الاجتماعات</a>
            <a href="http://www.na.org/?ID=ips-eng-index" class="btnBox" target="_blank">الادبيات</a>
        </div>
        <div class="four columns">
            <?php $helpline = get_field('helpline', 'option'); ?>
            <div class="helpline" itemscope itemtype="http://schema.org/Organization">
                <h3 class="mb-10"><?php echo $helpline['headline'] ?></h3>
                <p class="large mb-10">
                    <a href="tel:<?php echo $helpline['numbers'][0]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][0]['number']; ?></a><br>
                    <a href="tel:<?php echo $helpline['numbers'][1]['number']; ?>" itemprop="telephone"><?php echo $helpline['numbers'][1]['number']; ?></a>
                </p>
                <small><?php echo $helpline['time_range']; ?></small>
                <p class="nmb"><a href="mailto:<?php echo $helpline['email']; ?>" itemprop="email"><?php echo $helpline['email']; ?></a></p>
            </div> <!-- .helpline -->
        </div>
        <div class="four columns">
            <a href="<?php echo esc_url(home_url('/events/')); ?>" class="btnBox">الاحداث</a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btnBox">اتصل بنا</a>
        </div>
    </div>
</div> <!-- #main -->
<?php get_footer(); ?>