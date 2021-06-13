<?php
/**
 * Modèle de donnée des salons de joueurs
 *
 * PHP version 5.5
 *
 * @category   Modèles
 * @package    worldcup\app\models
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */

class Room extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'room';

    public $timestamps = false;

    protected $fillable = array('name', 'code');

    public function toArray()
    {
        $array = parent::toArray();
        $array['nbUsers'] = $this->nbUsers;
        $array['users'] = $this->users;
        return $array;
    }

    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'name' => 'required|string|max:255',
        'code' => 'required|unique:room|alpha_num|max:10',
    );

    public function getUsersAttribute(){
        $users = [];

        foreach($this->roomUsers()->get() as $roomUser){
            $users[] = [
                "id" => $roomUser->user_id,
                "display_name" => $roomUser->display_name,
                "winPoints" => $roomUser->user->winPoints,
                "rank" => $roomUser->rank,
                "rankDayMinus1" => $roomUser->rankDayMinus1,
                "points" => $roomUser->points,
                "pointsDayMinus1" => $roomUser->pointsDayMinus1
            ];
        }

        return $users;
    }

    public function roomUsers()
    {
        return $this->hasMany('RoomUser', 'room_id', 'id');
    }

    public function getNbUsersAttribute()
    {
        return count($this->roomUsers()->get());
    }

    public function cmp($a, $b)
    {
        if($b["points"] == $a["points"] && $b["display_name"] != $a["display_name"])
            return strcasecmp($a["display_name"],$b["display_name"]);
        if($b["points"] == $a["points"])
            return $b['id']>$a['id']?1:-1;
        return intval($b["points"])-intval($a["points"]);
    }

    public function cmp3($a, $b)
    {
        if($b["pointsDayMinus1"] == $a["pointsDayMinus1"] && $b["display_name"] != $a["display_name"])
            return strcasecmp($a["display_name"],$b["display_name"]);
        if($b["pointsDayMinus1"] == $a["pointsDayMinus1"])
            return $b['id']>$a['id']?1:-1;
        return intval($b["pointsDayMinus1"])-intval($a["pointsDayMinus1"]);
    }

    public function refreshRoomStats(){
        $date = new DateTime("today");
        $dateMinus1 = clone $date;
        date_sub($dateMinus1, date_interval_create_from_date_string('1 days'));
        $datePlus1 = clone $date;
        date_add($datePlus1, date_interval_create_from_date_string('1 days'));

        $usersTmp = $this->roomUsers()->get();
        $usersTmp2 = array();
        $users = array();
        $usersSortByWinPointsLastDay = array();

        $games = Game::whereRaw('date < ? && date > ? && status = "completed"', array($datePlus1, $date))->get();

        if(count($games) == 0){
            //Si aucun match aujourd'hui, on calcul le classement d'hier
            date_sub($date, date_interval_create_from_date_string('1 days'));
            date_sub($dateMinus1, date_interval_create_from_date_string('1 days'));
            date_sub($datePlus1, date_interval_create_from_date_string('1 days'));
        }


        foreach($usersTmp as $user){
            $user['pointsDayMinus1'] = $this->getWinPointsDay($user['user_id'], $dateMinus1, $date);
            $user['points'] = $user->user->winPoints;

            foreach($user["user"]["rooms"] as $roomTmp){
                if($roomTmp["room_id"] == $this->id && $roomTmp["user_id"] == $user['id'])
                    $user['display_name'] = $roomTmp["display_name"];
            }
            unset($user["rooms"]);
            $usersTmp2[] = $user;
        }

        usort($usersTmp2, "Room::cmp");

        $pos = 1;
        foreach($usersTmp2 as $user){
            $user['rank'] = $pos++;
            $usersSortByWinPointsLastDay[] = $user;
        }

        usort($usersSortByWinPointsLastDay, "Room::cmp3");


        $pos = 1;
        foreach($usersSortByWinPointsLastDay as $user){
            $user['rankDayMinus1'] = $pos++;
            $users[] = $user;
        }

        foreach($users as $user){

            $roomUser = RoomUser::whereRaw('user_id = ? && room_id = ?', array($user->user_id, $user->room_id))->first();

            if($roomUser){
                $roomUser->pointsDayMinus1 = $user['pointsDayMinus1'];
                $roomUser->points = $user['points'];
                $roomUser->rankDayMinus1 = $user['rankDayMinus1'];
                $roomUser->rank = $user['rank'];
                $roomUser->save();
            }
        }
    }

    public function getWinPointsDay($user_id, $dateStart, $startEnd)
    {

        $total = DB::table('transaction')->where('user_id', '=', $user_id)->where('created_at', '<', $startEnd)->where('created_at', '>', $dateStart)->where(function($req){$req->where('type', '=', 'gain')->orWhere('type', '=', 'bonus');})->sum('value');
        $total = $total - DB::table('transaction')->where('created_at', '<', $startEnd)->where('created_at', '>', $dateStart)->where('user_id', '=', $user_id)->where(function($req){$req->where('type', '=', 'bet');})->sum('value');

        return $total;
    }

}