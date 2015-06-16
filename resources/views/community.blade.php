<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="refresh" content="3600">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
        <link rel="stylesheet" type="text/css" href="css/community.css">
    
    </head>

    <body>
        <ul id="gallery"></ul>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/modernizr.custom.43373.js"></script>
        <script type="text/javascript" src="js/jquery.bxslider.js"></script>

        <script type="text/javascript">
        $(document).ready(function()  
        {  
            
            var sport = "";
            var feed ="http://scoreapi.flagshipapps.fglsports.com/files/scores.json";
            var timezoneoffset = -2;

            var dateExtractor = function(UTCTime){
        
                var date = new Date(UTCTime);
                var h = date.getHours();
                var m = date.getMinutes();
                var pm = "am";
                if(h > 12 ){
                    h = h - 12;
                    pm = "pm";
                }

                if(m < 10){
                    m = "0" + m;
                }

                return h +":"+ m + " " + pm
            }
    
            var setupScores = function(){
                $.get(feed, function(data){  

                    $.each(data.sports, function(i, item){  
                        
                        $.each(data.sports[i], function(j, jtem) {

                            var clock = "";
                            
                            switch( data.sports[i][j].gameStatus ){
                        
                            case "In-Progress":
                                clock = data.sports[i][j].clock;
                                break;
                            case "Final":
                                clock = "Final";
                                break;
                            case "Delayed":
                                clock = "Delayed";
                                break;
                            case "Pre-Game":
                                clock = dateExtractor(data.sports[i][j].startTime);
                                break;
                            }

                            var html = "<li class='item'><table class='scoretable'>";

                            html +=   "<tr>";
                            html +=   "    <td class='team home'>";
                            html +=   "        <span >"+ data.sports[i][j].homeTeam +"</span>";
                            html +=   "    </td>";
                            html +=   "    <td>";
                            if(data.sports[i][j].hasOwnProperty("homeScore")){
                            html +=   "        <span class='score' id='hscore'>"+ data.sports[i][j].homeScore +"</span>";                                        
                            }
                            else{
                            html +=   "        <span class='score' id='hscore'>"+ 0 +"</span>";
                            }
                            html +=   "    </td>";
                            html +=     "<td rowspan='2' class='period' id='time'>"+clock+"</td>";
                            html +=     "<td class='note'></td>";                    
                            html +=   "</tr>";
                            html +=   "<tr>";
                            html +=   "    <td class='team away'>";
                            html +=   "        <span>"+ data.sports[i][j].awayTeam +"</span>";
                            html +=   "    </td>";
                            html +=   "    <td>";
                            if(data.sports[i][j].hasOwnProperty("awayScore")){
                            html +=   "        <span class='score' id='vscore'>"+ data.sports[i][j].awayScore +"</span>";
                            }
                            else{
                            html +=   "        <span class='score' id = 'vscore'>"+ 0 +"</span>";
                            }
                            html +=   "    </td>";
                            html +=   "</tr>";

                            html +=  "</table>";
                            html += '</li>';
                            $('#gallery').append($(html));  

                        });
    
                        

    
                        
                    });  //end looping through scorefeed

               

                });  

            } // end setupScores

            var clearScoreboard = function(){
                $("#gallery").empty();
            }


            setupScores();

            var intervalId = setInterval(function(){ 
                clearInterval(intervalId);
                clearScoreboard();
                setupScores(); 

            },300000);

            // setInterval(function(){ setupScores(); },3600000);
            // setInterval(function(){ updateScores(); },5000);

            setInterval(function(){
              console.log("looped");
              $('#gallery li:first-child').fadeOut(120,  function(){
                $(this).next('li').fadeIn(120).end().appendTo('#gallery');
              });
            }, 8000);

        });


        

    
        </script>
        
    </body>

</html>