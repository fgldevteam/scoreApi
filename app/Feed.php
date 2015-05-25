<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    

	public static function getScoreFeed($league, $sport)
	{
		$date = date('y-m-d');
		// $date = '2014-09-21';
		
		$sig = hash('sha256', env('API_KEY').env('SECRET').gmdate('U'));

		$url = "http://api.stats.com/v1/stats/".$sport."/". $league."/scores/?date=". $date ."&accept=json&api_key=".env('API_KEY')."&sig=".$sig;
		

		if(get_headers($url, 1)[0] == 'HTTP/1.1 404 Not Found'){

			return array();
		}

		$content =  file_get_contents($url);
		
		return json_decode($content);
			
	}


	public static function filterScoreFeed($rawFeed , $sport)
	{
		if($rawFeed) 
		{
			$events = ($rawFeed->apiResults[0]->league->season->eventType[0]->events);

			$counter = 0;
			
			$leagueGames =  array();

			foreach ($events as $event){
				
				$game =  array();
				if ($event->eventStatus->name == "In-Progress")
				{
				    $game ["active"] = "true";
				    $game ["clock"]  = $event->eventStatus->inningDivision . " " . $event->eventStatus->inning; 
				}
				else{
					$game["active"] =  "false";
					if($event->eventStatus->name == "Pre-Game"){
						$game["startTime"]	= $event->startDate[1]->full;
					}
					
				}
				$game["gameStatus"] = $event->eventStatus->name;
				foreach ($event->teams as $team){	
					$game[$team->teamLocationType->name."Id"]		=  $team->teamId;
					$game[$team->teamLocationType->name."Team"]		=  $team->location;
					$game[$team->teamLocationType->name."Nickname"] =  $team->nickname ;
					if($sport == 'baseball'){
						$game[$team->teamLocationType->name."Score"] 	=  $team->linescoreTotals->runs ;
					}
					else{
						if(isset($team->score)){
							$game[$team->teamLocationType->name."Score"]	= $team->score;
						}
					}						
				}
				array_push($leagueGames, json_decode(json_encode($game)));
				$counter++;
			}

			unset($game);
		
		}
		if(isset($leagueGames)){

			return ($leagueGames);
		}
		return array();


	}

	public static function getTeamsFeed($league, $sport)
	{
		$sig = hash('sha256', env('API_KEY').env('SECRET').gmdate('U'));

		$url = "http://api.stats.com/v1/stats/".$sport."/". $league."/teams/?accept=json&api_key=".env('API_KEY')."&sig=".$sig;
		
		if(get_headers($url, 1)[0] == 'HTTP/1.1 404 Not Found'){

			return array();
		}

		$content =  file_get_contents($url);
		
		return json_decode($content);

	}

	public static function filterTeamsFeed($rawFeed, $league)
	{
		$teamsJson 	=  array();
		$teamCounter = 0;
		$season = ($rawFeed->apiResults[0]->league->season);
		$conferences = $season->conferences;
		$conferenceCounter = 0;
		foreach ($conferences as $conference){
			
			$divisions =  $conference->divisions;
			$divisionCounter = 0;
			foreach($divisions as $division)
			{		
				$teams = $division->teams;
				foreach($teams as $team)
				{
					$teamJson = array();
					$teamJson["teamId"] 		= $team->teamId;
					$teamJson["teamLocation"] 	= $team->location;
					$teamJson["teamNickname"] 	= $team->nickname;
					$teamJson["logo"]			= "/images/". $league ."/". 
													preg_replace("/ /", "-", strtolower($team->location)). "-" .
													preg_replace("/ /", "-", strtolower($team->nickname)) .".svg";
					$teamsJson[$teamCounter]  	= $teamJson;
					$teamCounter++;
				}
				$divisionCounter++;
			}
			$conferenceCounter++;
		}

		if(isset($season->allstar))
		{
			$teams = $season->allstar->teams;
			foreach ($teams as $team) {
				$teamJson = array();
				$teamJson["teamId"] 		= $team->teamId;
				$teamJson["teamLocation"] 	= $team->location;
				$teamJson["teamNickname"] 	= $team->nickname;
				$teamJson["logo"]			= "/images/". $league ."/". 
												preg_replace("/ /", "-", strtolower($team->location)). "-" .
												preg_replace("/ /", "-", strtolower($team->nickname)) .".svg";
				$teamsJson[$teamCounter]  	= $teamJson;
				$teamCounter++;
			}
		}

		return $teamsJson;
	}

	

}
