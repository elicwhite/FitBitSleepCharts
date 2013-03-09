<div class="box-with-info">
    <div data-updater="progress">
        <div class="progress progress-striped active">
            <div class="bar" style="width: 40%;"></div>
        </div>

        <p class="lead text-center">12 / 22</p>
    </div>

    <div data-updater="success">
        <div class="alert alert-success text-center">
            All data is up to date.
        </div>
    </div>
</div>
<div class="box-with-info-info">
    In the last 3 months, you logged sleep for <strong><?php echo $this->TotalValid ?></strong> days.
    <strong><?php echo $this->TotalUpdated ?></strong> of those are days we haven't seen before.
</div>
