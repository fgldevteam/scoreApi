<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// $app->get('/', function() use ($app) {
//     return $app->welcome();
// });

$app->get('/', function(){

	return view('viewlist');

});

$app->get('scores/{league}', 'App\Http\Controllers\Controller@getScoreByLeague' );

$app->get('scores', 'App\Http\Controllers\Controller@getAllScores' );

$app->get('api/teams/{league}', 'App\Http\Controllers\Controller@getTeamsByLeague' );

$app->get('api/teams', 'App\Http\Controllers\Controller@getAllTeams' );

$app->get('api/scores', function(){
	$scores =  file_get_contents('files/scores.json');
	return $scores;
});	

$app->get('teams', function(){
	
	$teamsJson = json_decode(file_get_contents('files/teams.json'));
	return view('teams')->withteams($teamsJson);
	
});


$app->get('halo/{timezoneoffset}', function($timezoneoffset= null){

	return view('halo')->with('timezoneoffset', $timezoneoffset);

});

$app->get('halo', function(){

	return view('halo')->with('timezoneoffset', 0);
});

$app->get('sportsdesk', function(){

	return view('sportsdesk')->with('timezoneoffset', $timezoneoffset);

});

$app->get('cash/{timezoneoffset}', function($timezoneoffset){

	return view('cash')->with('timezoneoffset', $timezoneoffset);

});

$app->get('community', function(){

	return view('community')->with('timezoneoffset', $timezoneoffset);

});

$app->get('flip/{timezoneoffset}', function($timezoneoffset){

	return view('flip')->with('timezoneoffset', $timezoneoffset);

});

$app->get('flip-ls/{timezoneoffset}', function($timezoneoffset){

	return view('flip-ls')->with('timezoneoffset', $timezoneoffset);

});

$app->get('sportsdesk1/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-black')->with('timezoneoffset', $timezoneoffset);

});
$app->get('sportsdesk2/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-grey-gradient')->with('timezoneoffset', $timezoneoffset);

});
$app->get('sportsdesk3/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-grey1')->with('timezoneoffset', $timezoneoffset);

});
$app->get('sportsdesk4/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-grey2')->with('timezoneoffset', $timezoneoffset);

});

$app->get('sportsdesk-score/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-score')->with('timezoneoffset', $timezoneoffset);
	
});


$app->get('sportsdesk-score', function(){

	return view('sportsdesk-score')->with('timezoneoffset', 0);
	
});

$app->get('sportsdesk-score2/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-score2')->with('timezoneoffset', $timezoneoffset);
	
});

$app->get('sportsdesk-score2', function(){

	return view('sportsdesk-score2')->with('timezoneoffset', 0);
	
});

$app->get('sportsdesk-score3/{timezoneoffset}', function($timezoneoffset){

	return view('sportsdesk-score3')->with('timezoneoffset', $timezoneoffset);
	
});

$app->get('sportsdesk-score3', function(){

	return view('sportsdesk-score3')->with('timezoneoffset', 0);
	
});