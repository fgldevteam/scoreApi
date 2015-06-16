<!DOCTYPE HTML>
<html>
<head>
	<title>
		
	</title>
	<link rel="stylesheet" type="text/css" href="/css/team-colours.css">
	<link rel="stylesheet" type="text/css" href="/css/cashwall.css">

</head>

<body>
	
<div id="scoreboard-container" >
		
</div>

<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>


<script>
$(document).ready(function(){

	var src = "http://scoreapi.flagshipapps.fglsports.com/files/scores.json";
	
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
	var getFeed = function(){
		$.getJSON( src , {
			data : {},
			
		})
		.done(function(data){
			$.each(data, function(index){
				if(index != null)
				{
					// response = $.merge( response , $.makeArray(data))	
					fillFeed(data)
				}
				
			})
	
		})
	}

	fillFeed = function(filteredFeed){

	var counter = 1;
	$.each(filteredFeed , function( sportKey, sportObj){

		$.each(sportObj , function (leagueKey, leagueObj){

			   $.each(leagueObj , function(gameKey, game){

			   		$("#scoreboard-container").append($('<div>', { class : "scoreboard",
	   													id    : "scoreboard"+counter }))
	   
				   $('#scoreboard'+counter).append($('<div>', { 
				   													class : "home-team  team"+game["homeId"] ,
				   											 }))

				   $('#scoreboard'+counter).append($('<div>', { 
				   													class : "away-team team"+game["awayId"],

				   											}))
				   
				   $('<div class="logo"><img src= http://scoreapi.flagshipapps.fglsports.com/'+game["homeLogo"]+'></div>').appendTo('#scoreboard-container #scoreboard'+counter + ' .home-team' )
				   $("<div class=\"team-info\"><p class=\"city\">"+ game["homeTeam"] +"</p><p class=\"team\">"+ game["homeNickname"] +"</p> </div>").appendTo('#scoreboard-container #scoreboard'+counter + ' .home-team' )
				   
				   if(game["gameStatus"] == "In-Progress" || game["gameStatus"] == "Final"){
				   
				   		$("<div class=\"score\">"+ game["homeScore"]+"</div>").appendTo('#scoreboard-container #scoreboard'+counter + ' .home-team' )
				   
				   }
				   
				   $('<div class="logo"> <img src= http://scoreapi.flagshipapps.fglsports.com/'+game["awayLogo"]+'></div>').appendTo('#scoreboard-container #scoreboard'+counter + ' .away-team' )
				   
				   $("<div class=\"team-info\"><p class=\"city\">"+ game["awayTeam"] +"</p><p class=\"team\">"+ game["awayNickname"] +"</p> </div>").appendTo('#scoreboard-container #scoreboard'+counter + ' .away-team' )
				   
				   if(game["gameStatus"] == "In-Progress" || game["gameStatus"] == "Final"){

				   		$("<div class=\"score\">"+ game["awayScore"] +"</div>").appendTo('#scoreboard-container #scoreboard'+counter + ' .away-team')

				   	}		
				   if(game["gameStatus"] == "Pre-Game" || game["gameStatus"] == "Delayed"){
				   		
				   		$('<div class=\"game-state\"><p>' + dateExtractor(game["startTime"]) + "</p></div>").appendTo('#scoreboard-container #scoreboard'+counter )

				   }
				   else if(game["gameStatus"] == "In-Progress"){
				   		
				   		$('<div class=\"game-state\"><p>' + game["clock"] + "</p></div>").appendTo('#scoreboard-container #scoreboard'+counter )

				   }
				   else if(game["gameStatus"] == "Final"){
				   		
				   		$('<div class=\"game-state\"><p>' + game["gameStatus"] + "</p></div>").appendTo('#scoreboard-container #scoreboard'+counter )

				   }
				  counter++; 


			   })
			   
			
		})

		
	} )
			
	animateFeed()
}

animateFeed= function(){
	var feedCounter  = 1;
	var totalScoreboards =  $(".scoreboard").length;
	var lastCounter  = totalScoreboards;
	
	
	$("#scoreboard"+feedCounter+" .home-team").show("slide", {direction : "right"},500);
	$("#scoreboard"+feedCounter+" .away-team").show("slide", {direction : "left"},500, function(){
		$("#scoreboard"+(feedCounter)+" .game-state").show();
	});

	
	var intervalId = setInterval( function(){
		
		if(feedCounter > totalScoreboards){
			clearInterval(intervalId)
			feedCounter = 1;
			lastCounter = totalScoreboards;
			$("#scoreboard"+(lastCounter)+" .game-state").hide();
			$("#scoreboard"+(feedCounter)+" .home-team").show("slide", {direction : "right"},500, function(){
				setTimeout(0)
			});
			$("#scoreboard"+(feedCounter)+" .away-team").show("slide", {direction : "left"},500, function(){
				setTimeout(0);
			});

			$(".scoreboard").remove();
			getFeed();
		}

		lastCounter = feedCounter;
		feedCounter++;
		$("#scoreboard"+(feedCounter-1)+" .home-team").hide("slide", {direction : "left"},500, function(){
			if(feedCounter > totalScoreboards){
				$("#scoreboard"+(feedCounter-1)+" .home-team").hide("slide", {direction : "left"},500)
				clearInterval(intervalId);
				$(".scoreboard").remove();
				getFeed();
			}
			else{
				$("#scoreboard"+(feedCounter)+" .home-team").show("slide", {direction : "right"},500, function(){
				})	
			}
			
		});
		$("#scoreboard"+(lastCounter)+" .game-state").hide();
		
		$("#scoreboard"+(feedCounter-1)+" .away-team").hide("slide", {direction : "right"},500, function(){
			$("#scoreboard"+(feedCounter)+" .away-team").show("slide", {direction : "left"},500, function(){
				$("#scoreboard"+(feedCounter)+" .game-state").show();

			})
		});
	
	}, 5000);
				
}
	
getFeed();

})

</script>
</body>
</html>