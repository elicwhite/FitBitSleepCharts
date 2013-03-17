<div>
    <?php
    foreach ($this->Days as $day) {
      ?>
        <div class="sleepDay">
            <div class="sleepInfo">
                <ul>
                    <li>Efficiency: <strong><?= $day->efficiency?>%</strong></li>
                    <li>Awakened: <?= $day->awakeningsCount ?> times</li>
                    <?php
                        $time = \Application\Classes\Utilities::convertTime($day->timeInBed);
                    ?>
                    <li>Time In Bed: <?= $time[0] ?> hours, <?= $time[1] ?> minutes</li>
                    <?php
                        $timeAsleep = \Application\Classes\Utilities::convertTime($day->timeInBed- $day->minutesAwake);
                    ?>
                    <li>Time Asleep: <?= $timeAsleep[0] ?> hours, <?= $timeAsleep[1] ?> minutes</li></li>
                </ul>
            </div>
            <div class="chart_container" data-day="<?= $day->day?>">
                <div class="chart"></div>
            </div>
        </div>
      <?php
    }
    ?>
</div>

