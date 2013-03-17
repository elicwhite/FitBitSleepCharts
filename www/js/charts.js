
$(function() {
     // Handler for .ready() called.
     $(".chart_container").each(function() {
         var day = $(this).attr("data-day");
         var chart = $(this).children(".chart")[0];

        var graph = new Rickshaw.Graph.Ajax( {
            element: chart,
            width: 500,
            height: 50,
            renderer: 'bar',
            dataURL: ROOT_URL+'/Index/getSleepJson/'+day,
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
                        var type = 'asleep';
                        if (parseInt(y) > 1) {
                            type = 'awake';
                        }

                        var date = '<span class="date">' + parseTime(new Date(x * 1000)) + '</span>';
                        var content = type +" at "+date;
                        return content;
                    }
                });

                x_axis.render();
            }
        });
     });
} );

function parseTime(d) {
    var a_p = "";

    var curr_hour = d.getUTCHours();

    if (curr_hour < 12) {
       a_p = "am";
    }
    else {
       a_p = "pm";
    }

    if (curr_hour == 0) {
       curr_hour = 12;
    }
    if (curr_hour > 12) {
       curr_hour = curr_hour - 12;
    }

    var curr_min = d.getUTCMinutes();
    return curr_hour + ":" + pad(curr_min, 2) + " " + a_p;
}

function pad (str, max) {
  return str.length < max ? pad("0" + str, max) : str;
}