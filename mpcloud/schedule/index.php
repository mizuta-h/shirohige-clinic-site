
<?php require_once('./schedule.php'); ?>

<?php if($display_hours){ ?>
<section>
    <h3 class="shcedule_title">本日の診療時間<i class="time_close">✖</i></h3>
    <div class="shcedule_box">
        <div class="shcedule_today">
            <p class="shcedule_status"><?= $status_message; ?></p>
            <?php if(!empty($schedule_times)){ ?>
            <dl class="schedule_time">
                <?php foreach((array)$schedule_times as $row){ ?>
                <dt><?= $row['title']; ?></dt>
                <dd><i></i><?= $row['from']; ?>～<?= $row['to']; ?></dd>
                <?php } ?>
            </dl>
            <?php } ?>
        </div>
    </div>
    <?php if($schedule_comment && $display_comment){ ?>
    <div class="shcedule_today_footer">
        <p class="schedule_comment"><?= nl2br($schedule_comment); ?></p>
    </div>
    <?php } ?>
</section>
<?php } ?>
