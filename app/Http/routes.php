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

$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->get('api/scores/{league}', 'App\Http\Controllers\Controller@getScoreByLeague' );

$app->get('api/scores', 'App\Http\Controllers\Controller@getAllScores' );

$app->get('api/teams/{league}', 'App\Http\Controllers\Controller@getTeamsByLeague' );

$app->get('api/teams', 'App\Http\Controllers\Controller@getAllTeams' );

$app->get('teams', function(){
	
	$teamsJson = json_decode(file_get_contents('files/teams.json'));
	return view('teams')->withteams($teamsJson);
	
});


$app->get('halo', function(){

	return view('halo');

});

$app->get('sportsdesk', function(){

	return view('sportsdesk');

});

$app->get('cash', function(){

	return view('cash');

});

$app->get('community', function(){

	return view('community');

});

$app->get('flip', function(){

	return view('flip');

});