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
        Hi, <?= $this->DisplayName?> <br />
        Go check out your averages!
    </p>

    <div class="avgBox">
        <table class="table">
            <tr>
                <th></th>
                <th>Efficiency</th>
                <th>Awakened</th>
                <th>Fell asleep in</th>
                <th>Time in bed</th>
                <th>Minutes awake</th>
                <th>Start time deviation</th>
            </tr>
            <?php
                foreach($this->Data as $data)
                {
            ?>
            <tr>
                <td><?= $data["title"]?></td>
                <td><?=round($data["data"]->efficiency)?>%</td>
                <td><?=round($data["data"]->awakeningsCount)?> times</td>
                <td><?=round($data["data"]->minutesToFallAsleep)?> minutes</td>
                <td><?= \Application\Classes\Utilities::formatTime($data["data"]->timeInBed) ?></td>
                <td><?=round($data["data"]->minutesAwake)?> minutes</td>
                <td><?= \Application\Classes\Utilities::formatTime($data["data"]->stdDevMin) ?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>

</div>