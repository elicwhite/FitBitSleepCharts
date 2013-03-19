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
                        $time = \Application\Classes\Utilities::formatTime($day->timeInBed);
                    ?>
                    <li>Time In Bed: <?= $time ?></li>
                    <?php
                        $timeAsleep = \Application\Classes\Utilities::formatTime($day->timeInBed- $day->minutesAwake);
                    ?>
                    <li>Time Asleep: <?= $timeAsleep ?></li>
                </ul>
            </div>
            <div class="chart_container" data-day="<?= $day->day?>">
                <div class="chart"></div>
            </div>
            <div class="dateBox pull-right lead">
                <?= date('M jS', strtotime($day->day)) ?></h3>
            </div>
        </div>
      <?php
    }
    ?>
</div>

