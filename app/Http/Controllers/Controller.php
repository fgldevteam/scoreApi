<?php
namespace App\Http\Controllers;

use App\Feed as Feed;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private $leagues       = array();
    private $leagueSeasons = array();
    public function __construct()
    {
        $this->leagues       = ['mlb' => 'baseball', 'nba' => 'basketball', 'nhl' => 'hockey', 'nfl' => 'football', 'cfl' => 'football'];
        $this->leagueSeasons = ['mlb' => [
            'start' => '2015-02-15',
            'end'   => '2015-11-07',
        ],
            'nhl'                         => [
                'start' => '2015-09-18',
                'end'   => '2016-06-25',
            ],
            'nba'                         => [
                'start' => '2015-10-27',
                'end'   => '2016-06-25',
            ],
            'nfl'                         => [
                'start' => '2015-08-08',
                'end'   => '2016-02-10',
            ],
            'cfl'                         => [
                'start' => '2015-06-20',
                'end'   => '2015-12-03',

            ],
        ];

    }

    public function getScoreByLeague($league)
    {

        $sport                 = $this->leagues[$league];
        $feed                  = Feed::getScoreFeed($league, $sport);
        $filteredFeed[$league] = json_decode(json_encode($feed, JSON_FORCE_OBJECT));
        return json_encode($filteredFeed);

    }

    public function getAllScores()
    {
        $filteredFeed = [];
        $returnFeed   = [];
        foreach ($this->leagues as $league => $sport) {
            if ((date('Y-m-d') >= $this->leagueSeasons[$league]['start']) && (date('Y-m-d') <= $this->leagueSeasons[$league]['end'])) {
                \Log::info($league . ' active');
                $feed = Feed::getScoreFeed($league, $sport);
            }

            if (!empty($feed)) {
                $filteredFeed[$sport] = json_decode(json_encode($feed, JSON_FORCE_OBJECT));
                unset($feed);
            }

        }
        $returnFeed["sports"] = $filteredFeed;
        file_put_contents("/var/www/vhosts/scoreapi/public/files/scores.json", json_encode($returnFeed));
        return $returnFeed;
    }

    public function getTeamsByLeague($league)
    {

        $filteredTeams = [];

        $sport = $this->leagues[$league];

        $rawFeed = Feed::getTeamsFeed($league, $sport);

        $processedTeams = Feed::filterTeamsFeed($rawFeed, $league);

        if (!empty($processedTeams)) {

            $filteredTeams = $processedTeams;
        }

        return ($filteredTeams);
    }

    public function getAllTeams()
    {
        $filteredTeams = [];

        foreach ($this->leagues as $league => $sport) {
            $rawFeed = Feed::getTeamsFeed($league, $sport);

            $processedTeams = Feed::filterTeamsFeed($rawFeed, $league);

            if (!empty($processedTeams)) {

                $filteredTeams = array_merge($filteredTeams, $processedTeams);
            }
        }
        return ($filteredTeams);
    }

}
