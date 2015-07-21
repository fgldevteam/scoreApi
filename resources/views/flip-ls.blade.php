<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>flip - landscape</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	 	<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/boxroll-slider.css">
		<link rel="stylesheet" href="css/logo-landscape.css">
		<script src="js/modernizr-2.6.1.min.js"></script>

    </head>

    <body class="landscape-scoreboard">

		<div class="slider" id="gallery">

		</div>


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="js/jquery.boxroll-slider.js"></script>
		<script src="js/utils.js"></script>

		<script>

		totalGames = 0;
		resetInterval = 200;

        $(document).ready(function() {

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
		        else if(h == 12){
		        	pm = "pm";
		        }

		        if(m < 10){
		            m = "0" + m;
		        }

		        return h +":"+ m + " " + pm
			}

            var setupScores = function(){

                $.get(feed, function(data){

                	console.log("grabbed new json: "+ Date.now() );

                    $.each(data.sports, function(i, item){

                    	totalGames = totalGames + Object.keys(data.sports[i]).length;
                    	console.log("totalGames:" + totalGames);

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

                        	var html = "<div class='item'><table>";

	                        html +=   "<tr class='scorebar'>";
	                        html +=   "    <td class='logo'>";
	                        html +=   "        <span class='minilogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+data.sports[i][j].homeLogo+") center center no-repeat;'></span>";
	                        html +=   "    </td>";
	                        html +=   "    <td class='cityteam'>";
	                        html +=   "        <span class='team-city'>"+ data.sports[i][j].homeTeam + " " + data.sports[i][j].homeNickname +"</span>";
	                        html +=   "    </td>";
	                        html +=   "    <td>";
	                        if(data.sports[i][j].hasOwnProperty("homeScore")){
	                        html +=   "        <span class='score hscore'>"+ data.sports[i][j].homeScore +"</span>";
	                        }
	                        else{
	                    	html +=   "        <span class='score hscore'>"+ 0 +"</span>";
	                    	}
	                        html +=   "    </td>";
	                        html +=   "    <td style='width: 70px;'></td>";
	                        html +=   "    <td>";
	                        html +=   "        <span class='minilogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+data.sports[i][j].awayLogo+") center center no-repeat;'></span>";
	                        html +=   "    </td>";
	                        html +=   "    <td class='cityteam'>";
	                        html +=   "        <span class='team-city'>"+ data.sports[i][j].awayTeam +" "+ data.sports[i][j].awayNickname +"</span>";
	                        html +=   "    </td>";
	                        html +=   "    <td>";
	                        if(data.sports[i][j].hasOwnProperty("awayScore")){
	                        html +=   "        <span class='score vscore'>"+ data.sports[i][j].awayScore +"</span>";
	                    	}
	                    	else{
	                    	html +=   "        <span class='score vscore'>"+ 0 +"</span>";
	                    	}
	                        html +=   "    </td>";
							html +=   "		<td><span class='clock time'>"+ clock +"</span></td>";
	                        html +=   "</tr>";

		                  	html +=  "</table>";
		                    html += '</div>';

	                        $('#gallery').append($(html));

                        });

						resetInterval = 7000 * totalGames;
            			console.log("resetInterval:" + resetInterval);

                    });  //end looping through scorefeed

					(function($){
					  $('.slider').boxRollSlider({
						timer: 7000
					  });
					}(jQuery))

                });

				//totalGames = 0;
            }; //send setup

            var clearScoreboard = function(){
            	$("#gallery").empty();
            }

			setupScores();

			var myFunction = function(){
				totalGames = 0;
			    clearInterval(interval);
 				clearScoreboard();
 				setupScores();
			    interval = setInterval(myFunction, resetInterval);
			}
			var interval = setInterval(myFunction, resetInterval);

		});

		</script>
    </body>

</html>
