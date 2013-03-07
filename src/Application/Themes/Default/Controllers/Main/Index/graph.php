<style>
#chart_container {
        font-family: Arial, Helvetica, sans-serif;
        padding-bottom: 24px;
        width: 500px;
        margin: auto;
}
#chart {
        position: relative;
}
#x_axis {
    position: relative;
    top: 0px;
    height: 40px;
}
.rickshaw_graph .detail .x_label { display: none }
.rickshaw_graph .x_tick .title {
    bottom: -24px;
    left: -18px;
}
</style>

<script>
$(function() {
     // Handler for .ready() called.

    var graph = new Rickshaw.Graph.Ajax( {
            element: document.querySelector("#chart"),
            width: 500,
            height: 100,
            renderer: 'bar',
            dataURL: '<?php echo $GLOBALS["registry"]->utils->makeLink("Index", "getSleepJson")?>',
            onData: function(d) {
                return d
            },
            series: [
                {
                    name: 'Sleep',
                    color: '#62AFB5',
                }
            ],
            onComplete: function(transport) {
                var graph = transport.graph;
                var x_axis = new Rickshaw.Graph.Axis.Time( {
                    graph: graph,
                    orientation: 'bottom',
                } );

                var hoverDetail = new Rickshaw.Graph.HoverDetail( {
                    graph: graph,
                    formatter: function(series, x, y) {
                        var date = '<span class="date">' + parseTime(new Date(x * 1000)) + '</span>';
                        var content = series.name + ": " + parseInt(y) + '<br>' + date;
                        return content;
                    }
                });

                x_axis.render();
            }
    } );


} );

function parseTime(d) {
    var a_p = "";

    var curr_hour = d.getUTCHours();

    if (curr_hour < 12)
       {
       a_p = "AM";
       }
    else
       {
       a_p = "PM";
       }
    if (curr_hour == 0)
       {
       curr_hour = 12;
       }
    if (curr_hour > 12)
       {
       curr_hour = curr_hour - 12;
       }

    var curr_min = d.getUTCMinutes();

    return curr_hour + ":" + curr_min + " " + a_p;
}
</script>


<div class="titlebar">
    Welcome
</div>

<div>
    <div id="chart_container">
        <div id="chart"></div>
    </div>
</div>

