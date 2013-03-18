<?php
    // If we have a last day
    if ($this->LastDay) {
        $date = strtotime($this->LastDay);
        $now = time();
        $diff = floor(($now-$date)/(60*60*24));
    }

    // If we don't have a last day, or our last day of data is more than two days ago.
    if (!$this->LastDay || $diff > 1) {
    ?>
    <div class="alert alert-info clearfix">
        <?php
        if (!$this->LastDay) {
        ?>
            You don't have any imported data!
        <?php
        }
        else
        {
        ?>
            Last day of data was on <?= $this->LastDay?>, <strong><?= $diff?> days ago.</strong>
        <?php
        }
        ?>
        <button class="btn btn-primary pull-right" data-href="<?=$GLOBALS["registry"]->utils->makeLink("Index", "update")?>" type="button">Update</button>
    </div>
    <?php
    }
?>
<div>
    <p class="lead text-center">
        Hi, <?= $this->Data->displayName?> <br />
        Go check out your sleep charts!
    </p>
</div>