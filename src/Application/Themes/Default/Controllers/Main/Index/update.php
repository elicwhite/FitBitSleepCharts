<div class="box-with-info">
    <div data-updater="progress">
        <div class="progress progress-striped active">
            <div class="bar" style="width: 0%;"></div>
        </div>

        <p class="lead text-center">
            <span id="progress">0</span> / <span id="total"><?php echo $this->TotalToUpdate ?></span>
        </p>
    </div>

    <div data-updater="success">
        <div class="alert alert-success text-center">
            All data is up to date.
        </div>
    </div>
</div>
<?php
if ($this->TotalToUpdate > 0) {
?>
    <div class="box-with-info-info">
        <ul class="log">
            <li>Loading new data...</li>
        </ul>
    </div>
<?php
}
?>
