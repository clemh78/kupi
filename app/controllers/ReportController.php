<?php

class ReportController extends BaseController {


    /**
     * Renvoi tout les utilisateurs en JSON
     *
     * @return Response
     */
    public function index()
    {
        $roomID = 1;
        $room = Room::whereId($roomID)->first();
        $users = $room['users'];

        $date = new DateTime("today");
        $dateMinus1 = clone $date;
        date_sub($dateMinus1, date_interval_create_from_date_string('1 days'));

        function cmpRank($a, $b)
        {
            return intval($b["rank"])-intval($a["rank"]);
        }


        usort($users, "cmpRank");

        $games = Game::whereRaw('date < ? && date > ?', array($date, $dateMinus1))->get()->toArray();

        return View::make('pdf.dailyReport', array('date' => $date, 'users' => $users, 'room' => $room, 'games' => $games));
    }

}