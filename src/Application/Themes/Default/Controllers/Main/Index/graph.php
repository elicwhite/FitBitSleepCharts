<div class="titlebar">
    Welcome
</div>

<div>
    <?php
    foreach ($this->Days as $day) {
      ?>
        <div class="sleepDay">
            <div class="sleepInfo">
                <ul>
                    <li>Days Asleep: 2</li>
                    <li>Minutes Awake: 4</li>
                    <li>Efficiency: 27</li>
                </ul>
            </div>
            <div class="chart_container" data-day="<?php echo $day?>">
                <div class="chart"></div>
            </div>
        </div>
      <?php
    }
    ?>
</div>

