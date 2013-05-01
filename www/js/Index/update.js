"use strict";

$(function() {
    var PROCESS = WEB_ROOT + "Index/process";
    var TEST = WEB_ROOT + "Index/test";

    var counter = 1;

    $("div[data-updater='success']").hide();

    if ($("#progress").text() != $("#total").text()) {
        // Run async requests
        // Heroku can't handle processing more than one at a time.
        doItems(1);
    }
    else
    {
        // No objects to do
        finished();
    }

    function doItems(num) {
        if (num <= 0)
            return;

        doNextItem(counter++);
        setTimeout(function() {
                doItems(num-1);
            },
            50);
    }

    function doNextItem(thread) {
        $.ajax({
            url: PROCESS,
            cache: false,
            statusCode: {
                200: function(data) {
                    if (!data.processed) {
                        finished();
                    }
                    increaseValue(data.processed);
                    $.each(data.results, function(index, item) {
                        logItem(item, thread);
                    });
                    doNextItem(thread);

                },
                204: function(data) {
                    finished();
                }
            }
        });
    }

    // Move the progress bar and increase the counter
    function increaseValue(num) {
         var value = parseInt($("#progress").text()) + num;
         $("#progress").text(value);
         var percent = (value / parseInt($("#total").text())) * 100;

         $(".bar").width(percent+"%");
    }

    var isCompleted = false;
    function finished() {
        if (isCompleted) {
            return;
        }

        isCompleted = true;
        $('.progress').removeClass('active');
        $("div[data-updater='progress']").hide();
        $("div[data-updater='success']").show();
    }

    function logItem(item, counter) {
        //console.log(item.day+ " == "+ counter);
        $('.log').append(
            $('<li>').append(item.day)
        );
    }
});