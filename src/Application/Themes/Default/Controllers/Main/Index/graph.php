<div class="titlebar">
    Welcome
</div>

<div>
    <?php
    foreach ($this->Days as $day) {
      ?>
         <div class="chart_container" data-day="<?php echo $day?>">
            <div class="chart"></div>
        </div>
      <?php
    }
    ?>
</div>

