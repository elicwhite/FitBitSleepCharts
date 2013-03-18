"use strict";

<?php
    header("Content-type: application/x-javascript");
?>

var WEB_ROOT = "<?= $_SERVER["ROOT"]?>";

$(function() {
     // Handler for .ready() called.
     $("button[data-href]").each(function() {
        $(this).click(function() {
            var url = $(this).attr("data-href");
            window.location = url;
        });
     });
});