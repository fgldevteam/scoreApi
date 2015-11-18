<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    

	public static function getScoreFeed($league, $sport)
	{
		$date = date('y-m-d');
	 	$feedContent = Feed::getFeedFromURL($date, $sport, $league);
		$filteredFeed = Feed::filterScoreFeed($feedContent, $sport, $league);
		
		// get last nights games
 		$date = date("Y-m-d", strtotime("yesterday"));
 		$yesterdaysFeed = Feed::getFeedFromURL($date, $sport, $league);
 		$yesterdaysFilteredFeed = Feed::filterScoreFeed($yesterdaysFeed, $sport, $league);

	 	if (count($yesterdaysFilteredFeed)>0) {
	 		foreach ($yesterdaysFilteredFeed as $y) {
	 			array_push($filteredFeed, $y);
	 		}
	 	}
		 usort($filteredFeed, function($a, $b)
			{
	    		return strcmp($a->startTime->datetime, $b->startTime->datetime);	
			});
	 	return $filteredFeed;
	}


	public static function filterScoreFeed($rawFeed , $sport, $league)
	{
		if ($rawFeed) {
			
			$events = ($rawFeed->apiResults[0]->league->season->eventType[0]->events);

			$counter = 0;
			
			$leagueGames =  array();

			foreach ($events as $event){
				$game =  array();
				if ($event->eventStatus->name == "In-Progress") {
				   
				    $game ["active"] = "true";
				    $game ["clock"]  = $event->eventStatus->inningDivision . " " . $event->eventStatus->inning; 
				}
				else{
					$game["active"] =  "false";
				}
				
				$game["startTime"]	= Feed::convertDatetime($event->startDate[1]->full);
				$game["gameStatus"] = $event->eventStatus->name;
				foreach ($event->teams as $team) {	
					$game[$team->teamLocationType->name."Id"]		=  $team->teamId;
					$game[$team->teamLocationType->name."Team"]		=  $team->location;
					$game[$team->teamLocationType->name."Nickname"] =  $team->nickname ;
					if($sport == 'baseball'){
						$game[$team->teamLocationType->name."Score"]=  $team->linescoreTotals->runs ;
					}
					else{
						if(isset($team->score)){
							$game[$team->teamLocationType->name."Score"]	= $team->score;
						}
					}	
					$game[$team->teamLocationType->name."Logo"]	 	= 	"/images/". $league ."/". 
													preg_replace("/ /", "-", strtolower($team->location)). "-" .
													preg_replace("/ /", "-", strtolower($team->nickname)) .".svg";			
				}
				array_push($leagueGames, json_decode(json_encode($game)));
				$counter++;
			}

			unset($game);
		
		}
		if (isset($leagueGames)){

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


	public static function getFeedFromURL($date, $sport, $league)
	{
		sleep(1);

		$sig = hash('sha256', env('API_KEY').env('SECRET').gmdate('U'));

		$url = "http://api.stats.com/v1/stats/".$sport."/". $league."/scores/?date=". $date ."&accept=json&api_key=".env('API_KEY')."&sig=".$sig;
		
		if (get_headers($url, 1)[0] == 'HTTP/1.1 404 Not Found'){

			return array();
		}

		$content =  file_get_contents($url);
		
		return json_decode($content);
	}

	public static function convertDatetime($datetimeStringISO)
	{
		$epochTime = strtotime($datetimeStringISO);
		$date = new \Datetime('@'.$epochTime);  

		$defaultTimezone = new \DateTimeZone('America/New_York'); 

		$dateConvertedToTimezone = date_timezone_set($date, $defaultTimezone);
		
		$returnResponse = [];
		$returnResponse["date"] = $dateConvertedToTimezone->format('Y-m-d');
		$returnResponse["hour"] = $dateConvertedToTimezone->format('h');
		$returnResponse["minute"] = $dateConvertedToTimezone->format('i');
		$returnResponse["datetime"]	= $dateConvertedToTimezone->format('Y-m-d H:i');
		$returnResponse["am"] = $dateConvertedToTimezone->format('a');
		$returnResponse["timezone"] ='America/New_York';

		return ($returnResponse);

	}

	
}
