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
        <link rel="stylesheet" href="/css/jquery.simplyscroll.css?<?=time();?>" media="all" type="text/css">
        <link rel="stylesheet" href="/css/halo.css?<?=time();?>" media="all" type="text/css">

		<style>
		
		
		.sc-front{
                top: 0px;
                left: 1254px;
                background: url('/images/sc-front.png?<?=time();?>') top left no-repeat;
        }

        .sc-back{
                top: -5px;
                left: 0px;

                background: url('/images/sc-back.png?<?=time();?>') top left no-repeat;
        }
		</style>
    </head>

    <body>
        <div class='scroll-overlay'></div>
        <div class='sc-logo sc-front'></div>
        <div class='sc-logo sc-back'></div>
        <ul id="scroller"></ul>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js?<?=time();?>"></script>
        <script type="text/javascript" src="/js/jquery.simplyscroll.js?<?=time();?>"></script>
        <script type="text/javascript" src="/js/moment.min.js?<?=time();?>"></script>
		<script src="js/utils.js?<?=time();?>"></script>
		
		


        <script type="text/javascript">
        var htmlString ="";

        $.getJSON( "http://scoreapi.flagshipapps.fglsports.com/files/scores.json", function( data ) {
            //var json = $.parseJSON(data);
            var logo = "";
            $.each(data.sports, function(i, item) {

                switch(i){

                    // case "baseball":
                    //     logo="<li class='slim mlblogo'><img src='/images/mlb.png' /></li>";
                    //     league="MLB";
                    // break;

                    // case "basketball":
                    //     logo="<li class='slim nbalogo'><img src='/images/nba.png' /></li>";
                    //     league="NBA";
                    // break;

                    // case "hockey":
                    //     logo="<li class='slim nhllogo'><img src='/images/nhl.png' /></li>";
                    //     league="NHL";
                    // break;

                }

                htmlString += logo;
                $.each(data.sports[i], function(j, jtem) {

					switch( data.sports[i][j].gameStatus ){
						
						case "In-Progress":
						
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].awayLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>"; 
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname'>"+data.sports[i][j].awayTeam+"</div>";;
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].awayNickname+"</div>";
                            htmlString += "     </td>";
                            htmlString += "     <td class='score'>" + data.sports[i][j].awayScore + "</td>";
							htmlString += "     <td class='at'></td>";                             
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].homeLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>";                             
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname'>"+data.sports[i][j].homeTeam+"</div>";
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].homeNickname+"</div>";                            
                            htmlString += "     </td>"; 
                            htmlString += "     <td class='score'>" + data.sports[i][j].homeScore + "</td>";                            
                            htmlString += "     <td class='clock'>" + data.sports[i][j].clock + "</td>";                            
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
                            						
							break;
							
						case "Final":
						
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].awayLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>"; 
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname'>"+data.sports[i][j].awayTeam+"</div>";;
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].awayNickname+"</div>";
                            htmlString += "     </td>";
                            htmlString += "     <td class='score'>" + data.sports[i][j].awayScore + "</td>";
							htmlString += "     <td class='at'></td>";                             
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].homeLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>";                             
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname'>"+data.sports[i][j].homeTeam+"</div>";
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].homeNickname+"</div>";                            
                            htmlString += "     </td>"; 
                            htmlString += "     <td class='score'>" + data.sports[i][j].homeScore + "</td>";
                            htmlString += "     <td class='clock'>FINAL</td>";                            
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
							break;
							
						case "Pre-Game":
						
							var date = new Date(data.sports[i][j].startTime);
                            var h = date.getHours();
                            var m = date.getMinutes();
                            var pm = "";
                            if(h > 12 ){
                                h = h - 12;
                                pm = "pm";
                            }

                            if(m < 10){
                                m = "0" + m;
                            }

                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].awayLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>";                            
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname'>"+data.sports[i][j].awayTeam+"</div>";;
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].awayNickname+"</div>";
                            htmlString += "     </td>";
							htmlString += "     <td class='at'>at</td>";                            
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].homeLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>";                             
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname'>"+data.sports[i][j].homeTeam+"</div>";
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].homeNickname+"</div>";                            
                            htmlString += "     </td>";                            
                            htmlString += "     <td class='clock'>" + h +":"+ m + " " + pm + "</td>";
                            htmlString += " </tr>";
                            htmlString += "</table>";
                            htmlString += "</li>";
						
							break;	
							
						case "Delayed":
                            htmlString += "<li>";
                            htmlString += "<table>";
                            htmlString += " <tr>";
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].awayLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>"; 
                            htmlString += "     <td>";
							htmlString += "			<div class='cityname'>"+data.sports[i][j].awayTeam+"</div>";;
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].awayNickname+"</div>";
                            htmlString += "     </td>";
                            htmlString += "     <td class='score'>" + data.sports[i][j].awayScore + "</td>";
                            htmlString += "     <td>";
                            htmlString += "			<span class='teamlogo' style='background: transparent url(http://scoreapi.flagshipapps.fglsports.com"+(data.sports[i][j].homeLogo).replace('.svg', '.png')+") center center no-repeat;'></span>";
                            htmlString += "     </td>";                             
                            htmlString += "     <td>";
                            htmlString += "			<div class='cityname'>"+data.sports[i][j].homeTeam+"</div>";
							htmlString += "   		<div class='teamname'>"+data.sports[i][j].homeNickname+"</div>";                            
                            htmlString += "     </td>"; 
                            htmlString += "     <td class='score'>" + data.sports[i][j].homeScore + "</td>";                            
                            htmlString += "     <td class='clock'>DELAYED</td>";                            
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
            $("#scroller").simplyScroll();
        });
        // $( document ).ready(function() {
        //     $("#scroller").simplyScroll();
        // });
        // (function($) {
        // 	$(function() { //on DOM ready
        //     	$("#scroller").simplyScroll();
        // 	});
        //  })(jQuery);

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
