<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="/css/jquery.simplyscroll.css" media="all" type="text/css">
        <link rel="stylesheet" href="/css/logos.css" media="all" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/fonts.css">
        <link rel="stylesheet" type="text/css" href="/css/sportsdesk-scores.css">
        <style type="text/css">

                
                .simply-scroll .simply-scroll-clip {

                background: rgba(31,29,31,1);
                background: -moz-linear-gradient(left, rgba(31,29,31,1) 0%, rgba(31,29,31,1) 100%);
                background: -webkit-gradient(left top, right top, color-stop(0%, rgba(31,29,31,1)), color-stop(100%, rgba(31,29,31,1)));
                background: -webkit-linear-gradient(left, rgba(31,29,31,1) 0%, rgba(31,29,31,1) 100%);
                background: -o-linear-gradient(left, rgba(31,29,31,1) 0%, rgba(31,29,31,1) 100%);
                background: -ms-linear-gradient(left, rgba(31,29,31,1) 0%, rgba(31,29,31,1) 100%);
                background: linear-gradient(to right, rgba(31,29,31,1) 0%, rgba(31,29,31,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1f1d1f', endColorstr='#1f1d1f', GradientType=1 );
            }


        </style>
    </head>

    <body class="scoredesk2">

        <ul id="scroller">

        </ul>
        <input type="text" hidden name="timezoneoffset" value={{$timezoneoffset}}>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.simplyscroll.js"></script>
        <script type="text/javascript" src="/js/moment.min.js"></script>
		<script src="/js/utils.js"></script>
		
        <script type="text/javascript">
        var htmlString ="";
        var timezoneoffset = $('input[name= "timezoneoffset"]').val();

        var formatTime = function( startTime ){
            var hour = parseInt( startTime["hour"]) + parseInt(timezoneoffset);
            var minute = startTime["minute"];
            var am = "am";
            if(hour > 12 ){
                hour = hour - 12;
                am = "pm";
            }
            else if(hour == 12){
                am = "pm";
            }
            return hour + ":" + minute + " " +  am; 
        }

        $.getJSON( "/files/scores.json", function( data ) {

            var logo = "";
            $.each(data.sports, function(i, item) {
                console.log(i);
                switch(i){

                    case "baseball":
                        // logo="<li class='slim mlblogo'><img src='mlb.png' /></li>";
                        league="MLB";
                    break;

                    case "basketball":
                        // logo="<li class='slim nbalogo'><img src='nba.png' /></li>";
                        league="NBA";
                    break;

                    case "hockey":
                        // logo="<li class='slim nhllogo'><img src='nhl.png' /></li>";
                        league="NHL";
                    break;

                }

                htmlString += logo;

                $.each(data.sports[i], function(j, jtem) {

					switch( data.sports[i][j].gameStatus ){
						
						case "In-Progress":
						
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].awayNickname+"</div>";;
							
                            htmlString += "     </td>";
                            htmlString += "     <td class='score-sportsdesk'>" + data.sports[i][j].awayScore + "</td>";
							htmlString += "     <td class='at'></td>";                             
                                                         
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].homeNickname+"</div>";
							
                            htmlString += "     </td>"; 
                            htmlString += "     <td class='score-sportsdesk'>" + data.sports[i][j].homeScore + "</td>";                            
                            htmlString += "     <td class='clock-sportsdesk'>" + data.sports[i][j].clock + "</td>";                            
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
                            						
							break;
							
						case "Final":
						
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].awayNickname+"</div>";;
							
                            htmlString += "     </td>";
                            htmlString += "     <td class='score-sportsdesk'>" + data.sports[i][j].awayScore + "</td>";
							htmlString += "     <td class='at'></td>";                             
                                                         
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].homeNickname+"</div>";
							
                            htmlString += "     </td>"; 
                            htmlString += "     <td class='score-sportsdesk'>" + data.sports[i][j].homeScore + "</td>";
                            htmlString += "     <td class='clock-sportsdesk'>FINAL</td>";                            
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
							break;
							
						case "Pre-Game":
					
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                                                       
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].awayNickname+"</div>";
							
                            htmlString += "     </td>";
							htmlString += "     <td class='at'>at</td>";                            
                                                         
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].homeNickname+"</div>";
							
                            htmlString += "     </td>";                            
                            htmlString += "     <td class='clock-sportsdesk'>" + formatTime(data.sports[i][j].startTime) + "</td>";
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
						
							break;	
							
						case "Delayed":
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].awayNickname+"</div>";;
							
                            htmlString += "     </td>";
                            htmlString += "     <td class='score-sportsdesk'>" + data.sports[i][j].awayScore + "</td>";
                                                         
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname-sportsdesk'>"+data.sports[i][j].homeNickname+"</div>";
							
                            htmlString += "     </td>"; 
                            htmlString += "     <td class='score-sportsdesk'>" + data.sports[i][j].homeScore + "</td>";                            
                            htmlString += "     <td class='clock-sportsdesk'>DELAYED</td>";                            
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
						
							break;						
											
					}

                });
            });
        })
        .done(function() {
        //    console.log( htmlString );
            $('#scroller').append( htmlString );
            $("#scroller").simplyScroll({
                frameRate : 50
            });
        });
      

        </script>


        <script type="text/javascript">
        // (function($) {
        //     $(function() { //on DOM ready
        //         $("#scroller").simplyScroll();
        //     });
        //  })(jQuery);

        </script>

    </body>

    </html>
