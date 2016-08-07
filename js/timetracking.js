/**
 * javascript functions related to timetracking
 *
 * is been called on load
 *
 * included by:
 *
 * @author     Thomas Mann
 * @uses:
 * @usedby:
 */
    
/**
* global variables
*/
var onLoadFunctions= new Array();
var ajax_edits= new Array();

var timeTrackingTable;
var timeTrackingForm;

onLoadFunctions.push(function() {
    timeTrackingTable = new TimeTrackingTable();
    timeTrackingForm = new TimeTrackingForm();
});

var tempBlock= {
    start:13,
    duration:230,
    title:"+",
    productivity:5,
    id:0,
    color:""
};


function TimeTrackingTable() {
    var ttt= this;

    ttt.days = 3;
    ttt.timeBlocks = {};

    ttt.start_time_today = undefined;
    ttt.end_time_today = undefined;

    ttt.DATE_WIDTH = 180;
    ttt.DAY_HEIGHT= 20;
    ttt.TIMELINE_HEIGHT = 20;

    ttt.FIRST_HOUR = 7;
    ttt.LAST_HOUR = 25;

    this.renderBlocks=function() 
    {
        var data=[];
        for( var key in this.timeBlocks) {
            data.push(this.timeBlocks[key]);
        }
        data.push(tempBlock);

        var selection= d3.select("div.d3")
                .selectAll("a")
                .data(data);

        selection
            .enter()
                .append('a');

        selection
            .data(data)
            .attr("class", function(d) {
                return "timeblock" + ((d.id == 0) ? " new":'' );
            })
            .style("background-color", function(d,i) { 
                return d.color; 
            } )
            .style("left", function(d,i) { 
                return (ttt.xFromTime(d.start) - 1) + "px"; 
            } )
            .style("top", function(d,i) { 
                var d = ttt.daysSinceToday(d.start);
                return  (ttt.height + (d-2) * ttt.DAY_HEIGHT - ttt.TIMELINE_HEIGHT + 2 ) + "px";
             } )
            .style("width", function(d,i) { 
                return Math.floor(ttt.xFromTime(d.start + d.duration) - ttt.xFromTime(d.start)) + "px";
            } )
            .style("height", function(d,i) { 
                //return (ttt.DAY_HEIGHT  * d.productivity / 5) + "px";
                return (ttt.DAY_HEIGHT - 5) + "px";
            } )
            .attr('href', function(d,i) {
                return d.id;
            })
            .text( function(d,i) {
                return (d.title);
            });

        selection
            .exit()
                .remove();
    }

    this.createGrid = function() {
        $('div.timetable svg').remove();

        var svgTable= d3.select("div.timetable")
                    .style('height', (this.NUM_DAYS_SHOWN * this.DAY_HEIGHT + this.TIMELINE_HEIGHT) + "px")
                    .append("svg");

        ttt.width= $("body").width();
        ttt.height= ttt.NUM_DAYS_SHOWN * ttt.DAY_HEIGHT + ttt.TIMELINE_HEIGHT;

        // Horizontal Lines and day-labels
        for(var i=0; i <= ttt.NUM_DAYS_SHOWN; ++i) {
            var dateOfRow= new Date( new Date().getTime() + 24*60*60*1000* (i+1-ttt.NUM_DAYS_SHOWN));
            var day = dateOfRow.getDay();
            var isWeekend = (day == 6) || (day == 0);                 

            var y = Math.floor(i * ttt.DAY_HEIGHT);
            svgTable
                .append('rect')
                .attr('x', 0)
                .attr('width', '100%')
                .attr('height', 1)
                .attr('y', y)
                ;

            if( i >= ttt.NUM_DAYS_SHOWN) 
                continue;

    
            svgTable
                .append('text')
                .attr('y', y + ttt.DAY_HEIGHT - 5)
                .attr('x', 5)
                .style('fill', isWeekend ? "#D13A4C" : "rgba(0,0,0,0.3)")
                .text( function(d) {
                    var f = d3.time.format("%b %d – %a");
                    return f(dateOfRow);
                })

    
            if(isWeekend) {
                svgTable
                    .append('rect')
                    .attr('x', 0)
                    .attr('width', '100%')
                    .attr('height', ttt.DAY_HEIGHT+1)
                    .attr('y', y)
                    .style('fill', "rgba(0,0,0,0.05)")
                    ;

            }
            
        }

        // Vertical Lines (hours)
        var hours = ttt.LAST_HOUR - ttt.FIRST_HOUR;
        for(var i=0; i <= hours; ++i) {
            var x=  Math.floor( ttt.xFromTime( (i + ttt.FIRST_HOUR) * 60*60 ));

            svgTable
                .append('rect')
                .attr('x', x)
                .attr('y', 0)
                .attr('width', 1)
                .attr('height', ttt.height- ttt.DAY_HEIGHT)
                ;

            svgTable
                .append('text')
                .text(i + ttt.FIRST_HOUR)
                .attr('text-anchor', 'middle')
                .attr('x',x)
                .attr('y', ttt.height- 3)
                ;

        }
    }

    this.daysSinceToday =  function(t) 
    {
        return Math.floor((t - this.start_time_today+60*60*2) / (60*60*24));
        //return Math.floor((t - 1*60*60) / (60*60*24));
    }

    
    this.xFromTime = function(t)  
    { 
        t -= this.daysSinceToday(t) *60*60*24;

        var _width= (ttt.width - this.DATE_WIDTH);
        var _ratio= (t - this.start_time_today) / (this.end_time_today - this.start_time_today);
        return _width * _ratio + this.DATE_WIDTH;
    }

    this.getNumberOfDaysShown = function()
    {
        var DEFAULT_NUMBER_OF_SHOWN_DAYS = 6;
        var daysFromParameter = parseInt(getURLParameter('days')); 
        daysFromParameter = Math.max(0, daysFromParameter);
        daysFromParameter = Math.min(60, daysFromParameter);

        return daysFromParameter || DEFAULT_NUMBER_OF_SHOWN_DAYS;
    }

    this.NUM_DAYS_SHOWN = this.getNumberOfDaysShown();


    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
    }


    this.updateCurrentTime = function()
    {
        var d= new Date();
        var x = ttt.xFromTime((Date.now() - d.getTimezoneOffset()*60*1000) / 1000);
        $('.currentTime').css('left', x );
    }

    this.updateCurrentTime();

    this.init = function()
    {
        window.timetracker = this; //very evil hack

        var start= new Date();
        start.setMinutes(59);
        start.setUTCHours(this.FIRST_HOUR-1);
        start.setSeconds(0);
        this.start_time_today = start/1000;


        var e= new Date();
        e.setMinutes(0);
        e.setUTCHours(this.LAST_HOUR);
        e.setSeconds(0);
        this.end_time_today = e/1000;


        this.createGrid();
        this.updateCurrentTime();

        var queryUrl = "./index.php?go=ajaxUserEfforts" + "&days=" + this.NUM_DAYS_SHOWN;

        $.ajax({
          url: queryUrl,
          cache: false,
          dataType: "JSON",
          context:this,
        }).done(function( data ) 
        {            
            this.timeBlocks = data;            
            this.renderBlocks();
            timeTrackingForm.setStartTimeFromLastBookedEffort(data)
        });

        $(window).resize(function(e) {
            ttt.renderBlocks();
            ttt.createGrid();
        });

        // Set time to update time indicator
        setInterval(this.updateCurrentTime, 5000);
    }
    this.init();
    return this;
}


function TimeTrackingForm() {

    var ttf = this;

    /*
    * Gather fields
    */
    ttf.$projectInput= $("input.project");
    if(ttf.$projectInput.length != 1) {
        console.warn("Couldn't find project field");
        return;
    }

    ttf.$projectId= $("#effort_project_id");
    if(ttf.$projectId.length != 1) {
        console.warn("Couldn't find project id field");
        return;
    }

    ttf.$taskId= $("#effort_task_id");
    if(ttf.$projectId.length != 1) {
        console.warn("Couldn't find task id field");
        return;
    }

    ttf.$taskInput= $("input.task");
    if(ttf.$taskInput.length != 1) {
        console.warn("Couldn't find task field");
        return;
    }
    

    ttf.$startTime= $("input#effort_start");
    if(ttf.$startTime.length != 1) {
        console.warn("Couldn't find start time field");
        return;
    }
    ttf.$startSeconds= $("input#effort_start_seconds");
    if(ttf.$startSeconds.length != 1) {
        console.warn("Couldn't find start time seconds field");
        return;
    }


    ttf.$duration= $("input#effort_duration");
    if(ttf.$duration.length != 1) {
        console.warn("Couldn't find duration field");
        return;
    }

    ttf.$endTime= $("input#effort_end");
    if(ttf.$endTime.length != 1) {
        console.warn("Couldn't find end time field");
        return;
    }



    ttf.$endSeconds= $("input#effort_end_seconds");
    if(ttf.$endSeconds.length != 1) {
        console.warn("Couldn't find end time seconds field");
        return;
    }



    /*
    * Setup project autocomplete search (should actually be preloaded...)
    */
    var ac= new $.Ninja.Autocomplete(ttf.$projectInput, {
        get:function (q, callback) {
            $.ajax({
                url: 'index.php',
                dataType: 'json',
                data: {
                    go: 'ajaxUserProjects',
                    q: q
                },
                success: function (data) {
                    var rich_value_map = {};

                    values= $.map(data, function (item) {
                      rich_value_map[item.name]= item.id;
                      return item.name;
                    });
                    ttf.$projectInput.data('rich-values', rich_value_map);
                    callback(values);
                },

            error: function (request, status, message) {
              $.ninja.error(message);
            }
          });
        },
        select:function() {
            var value = ttf.$projectInput.data('rich-values')[ this.$element.val() ];
            if( ttf.$projectId.val() != value) {
                ttf.$projectId.val( value );
                ttf.$taskInput.val('');
                ttf.$taskId.val(0);
            }
        }
    });

    /*
    * Setup Task autocomplete search (should actually be preloaded...)
    */
    var ac= new $.Ninja.Autocomplete(ttf.$taskInput, {
        get:function (q, callback) {
            $.ajax({
                url: 'index.php',
                dataType: 'json',
                data: {
                    go: 'ajaxUserTasks',
                    q: q,
                    prj: ttf.$projectId.val()
                },
                success: function (data) {
                    var rich_value_map = {};

                    values= $.map(data, function (item) {
                      rich_value_map[item.name]= item.id;
                      return item.name;
                    });
                    ttf.$taskInput.data('rich-values', rich_value_map);
                    callback(values);
                },

            error: function (request, status, message) {
              $.ninja.error(message);
            }
          });
        },
        select:function() {
            var fixedLineBreak = this.$element.val().replace("\n","")
            var value = ttf.$taskInput.data('rich-values')[ fixedLineBreak ];
            ttf.$taskId.val( value );
        }
    });



    this.getTimeStringFromSeconds = function( s )
    {
        var d = new Date(s*1000);
        var hours = d.getHours();
        var minutes = d.getMinutes();
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        return hours + ":" + minutes;
    }

    this.getTimeSecondsFromString = function( str , d)
    {
        var match_hours = /^\s*(\d+):?(\d*)\s*(am|pm)?\s*$/;
        if( match_hours.exec(str )) {
            var hours = RegExp.$1 * 1;
            var minutes = RegExp.$2 * 1;
            var ampm = RegExp.$3;
            if( ampm =='pm' || ampm=='PM' && hours <= 12) {
                hours+= 12;
            }

            //var t= new Date();
            d.setHours(hours);
            d.setMinutes(minutes);
            d.setSeconds(0);
            return d * 0.001;
        }
        return 0;
    }

    this.getDurationFromString = function( str )
    {
        if( str.match(/^\s*(\d+):?(\d*)\s*$/ ) ) {
            var hours = RegExp.$1 * 1;
            var minutes = RegExp.$2 * 1;

            return hours * 60 * 60 + minutes * 60;
        }

        var h = str * 1.0;
        if( h != 0) {
            return h * 60 * 60;
        }
        return 0;
    }

    /**
    * Timer to update duration
    */
    this.updateDuration = function() {
        var st = ttf.getStartTime();
        var et = ttf.getEndTime();
        if( et == 0) {
            et = Date.now() * 0.001;
        }

        if( st > 0 ) {
            ttf.$duration.attr('placeholder', ttf.getDurationStringFromSeconds( et-st ));
        }
        else {
            ttf.$duration.attr('placeholder', '???');
        }
        
        if(et-st <= 0 ) {
            ttf.$duration.addClass('error');
        }
        else {
            ttf.$duration.removeClass('error');
          
        }
        tempBlock.start = ttf.getStartTime() - new Date().getTimezoneOffset() * 60 ;
        tempBlock.duration = Math.max( et-st, 1000);
        //tempBlock.duration = 3000;
        timeTrackingTable.renderBlocks();

    }

    ttf.setStartTime= function(seconds) {
        var seconds = seconds << 0;
        ttf.$startSeconds.val(seconds);
        ttf.$startTime.val( ttf.getTimeStringFromSeconds(seconds) );
        ttf.updateDuration();

        
        var d = new Date( seconds * 1000);
        $('#effort_date').val( d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() );

    }
    ttf.getStartTime= function() {
        return ttf.$startSeconds.val() << 0;
    }

    ttf.setEndTime= function(seconds) {
        var seconds = seconds << 0;
        ttf.$endSeconds.val(seconds);
        ttf.$endTime.val( ttf.getTimeStringFromSeconds(seconds) );
        if( seconds ==0) {
            ttf.$endTime.addClass('now');
            ttf.$endTime.val('');
            ttf.$endTime.attr('placeholder','now');
        }
        ttf.updateDuration();
    }
    ttf.getEndTime= function() {
        return ttf.$endSeconds.val() << 0;
    }



    ttf.$startTime.click(function(event) {
        ttf.$startTime.select();
    });

    ttf.$startTime.blur(function(event){
        var v = ttf.$startTime.val();
        if( v!='') {
            var s = ttf.getTimeSecondsFromString(v, new Date(ttf.getStartTime() * 1000 ));
            ttf.setStartTime(s);
        }
    });
    
    $("#previous_date").click(function(){
      var st= ttf.getStartTime();
      
      $('#trigger_date').html("1974-07-30");            
  
    });
    


    /**
    * events for end time
    */
    ttf.$endTime.click(function(event) {
        ttf.$endTime.removeClass('now');
        ttf.$endTime.select();
    });

    ttf.$endTime.blur(function(event){
        var v = ttf.$endTime.val();
        if( v=='' || v == 'now') {
            ttf.setEndTime(0);
        }
        else {
            var referenceDay= new Date( ttf.getStartTime() * 1000 );
            var sec= ttf.getTimeSecondsFromString(v, referenceDay );
            if ( sec < ttf.getStartTime()) {
                sec += 24 * 60 * 60;
            }
            ttf.setEndTime( sec );
        }
    });


    ttf.$duration.blur(function(event){
        var d = ttf.getDurationFromString( ttf.$duration.val() );
        var st = ttf.getStartTime();
        var et = ttf.getEndTime();
        var now = Date.now() * 0.001;
        if( d > 0) {
            if( st == 0 && et == 0) {
                ttf.setStartTime( now - d );
            }
            else if ( st == 0) {
                ttf.setStartTime( et - d );
                ttf.$duration.val('');
            }
            else {
                ttf.setEndTime( d + st );
                ttf.$duration.val('');
            }
        }
    });


    this.getDurationStringFromSeconds= function(s) {
        var s= parseInt(s);
        if(s < 60 ) {
            return s+"s";
        }
        else {
            var seconds = s % 60;
            var minutes = (s/60) % 60 << 0;
            var hours = s / 60 / 60 << 0;

            seconds = seconds < 10 ? "0"+seconds : seconds;
            minutes = minutes < 10 ? "0"+minutes : minutes;

            hours   = hours   < 10 ? "0"+hours   : hours  ;
            return hours + ":" + minutes;
        }
    }


    /**
    * events for start time
    */
    if(ttf.$startSeconds.val() == '') {
        ttf.setStartTime( Date.now()*0.001 );
    }
    else {
        ttf.setStartTime( ttf.$startSeconds.val() * 1 );
    }


    ttf.setStartTimeFromLastBookedEffort = function(effertsBlock) 
    {
        var maxId = 0;
        var lastEnd=0;

        for( var key in effertsBlock) {
            var effort = effertsBlock[key];

            var fiveMinutes = 100 * 60;
            var createdRecently =  (Date.now() / 1000 - effort.created) < fiveMinutes;

            if(createdRecently && effort.id > maxId) {
                lastEnd = effort.start + effort.duration + new Date().getTimezoneOffset() * 60;
            }
        }
        if(lastEnd != 0) {
            ttf.setStartTime(lastEnd);
            ttf.setEndTime(lastEnd + 15*60);
            var lastEndDate= new Date(lastEnd*1000);
            $('#trigger_date').html(lastEndDate.getFullYear() + "-" + (lastEndDate.getMonth()+1) + "-" + lastEndDate.getDate());
        }
    }


    xcal = Calendar.setup({
        inputField  : "effort_date",
        ifFormat    : "%Y-%m-%d",
        button      : "trigger_date",
        onUpdate: function(e) {
            var st= ttf.getStartTime();
            $('#trigger_date').html(e.date.getFullYear() + "-" + (e.date.getMonth()+1) + "-" + e.date.getDate());
            
            var sd = new Date(st * 1000);
            sd.setFullYear( e.date.getFullYear());
            sd.setMonth( e.date.getMonth());
            sd.setDate( e.date.getDate());
            ttf.setStartTime( sd * 0.001 );
                        
            var et=ttf.getEndTime();
            var duration = (et==0) ? 60 * 60
                                   : et - st;
            ttf.setEndTime( sd * 0.001 + duration );
        }
    });

    setInterval(this.updateDuration, 1000);    
}


