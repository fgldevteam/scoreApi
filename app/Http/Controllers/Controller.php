<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Feed as Feed;

class Controller extends BaseController
{
    private $leagues = array();

    public function __construct()
    {
    	$this->leagues 	=  [ 'mlb'=>'baseball','nba'=>'basketball', 'nhl'=>'hockey', 'nfl'=>'football'];

    }

	public function getScoreByLeague($league)
	{
	
		$sport = $this->leagues[$league];
		
		$rawFeed = Feed::getScoreFeed($league, $sport);

		$processedFeed = Feed::filterScoreFeed($rawFeed, $sport);

		$filteredFeed[$league] = json_decode(json_encode( $processedFeed, JSON_FORCE_OBJECT)); 

		return json_encode($filteredFeed);
	}	

	public function getAllScores()
	{
		$filteredFeed = [];
		$returnFeed   = [];
		foreach($this->leagues as $league=>$sport)
		{
			$rawFeed = Feed::getScoreFeed($league, $sport);

			$processedFeed = Feed::filterScoreFeed($rawFeed, $sport);

			if(! empty($processedFeed) ){

				$filteredFeed[$sport] = json_decode(json_encode( $processedFeed, JSON_FORCE_OBJECT)); 

			}

		}
		$returnFeed["sports"] = $filteredFeed;
		
		file_put_contents( "/Applications/XAMPP/htdocs/scorefeed-api/public/files/scores.json", json_encode($returnFeed));

		return $returnFeed;
	}	

	public function getTeamsByLeague($league)
	{
	
		$filteredTeams = [];
		
		$sport = $this->leagues[$league];

		$rawFeed = Feed::getTeamsFeed($league, $sport);

		$processedTeams = Feed::filterTeamsFeed($rawFeed, $league);

		if(!empty($processedTeams)){

			$filteredTeams = $processedTeams ;
		}
	
		return ($filteredTeams);
	}	

	public function getAllTeams()
	{
		$filteredTeams = [];
		
		foreach($this->leagues as $league=>$sport)
		{
			$rawFeed = Feed::getTeamsFeed($league, $sport);

			$processedTeams = Feed::filterTeamsFeed($rawFeed, $league);

			if(!empty($processedTeams)){

				$filteredTeams = array_merge($filteredTeams,$processedTeams) ;
			}
		}
		return ($filteredTeams);
	}

	

}
