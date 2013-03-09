<?php
    $date = strtotime($this->LastDay);
    $now = time();
    $diff = floor(($now-$date)/(60*60*24));

    if ($diff > 0) {
    ?>
    <div class="alert alert-info clearfix">
        Last day of data was on <?= $this->LastDay?>, <strong><?= $diff?> days ago.</strong>
        <button class="btn btn-primary pull-right" type="button">Update</button>
    </div>
    <?php
    }
?>
<pre>
    <?php
        print_r($this->Data);
    ?>
</pre>