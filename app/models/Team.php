<?php
/**
 * Modèle de donnée des équipes du tournoi
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

class Team extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'team';

    public $timestamps = false;


    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');

    /**
     * Récupère l'objet Group de l'équipe
     *
     * @var Stage
     */
    public function group()
    {
        return $this->belongsTo('Group', 'group_id', 'id');
    }

    public function refreshTeamStats() {
        $played = 0;
        $wins = 0;
        $draws = 0;
        $losses = 0;

        $goals_for = 0;
        $goals_against = 0;
        $goals_diff = 0;

        $games = Game::whereRaw('(team1_id = ? OR team2_id = ?) AND stage_id IS NULL AND status = ?', array($this->id, $this->id, 'completed'))->get();

        foreach($games as $game) {
            $played++;

            if($game->winner_id != null){
                if($game->winner_id == $this->id)
                    $wins++;
                else
                    $losses++;
            }

            if($game->winner_id == null)
                $draws++;

            if($game->team1_id == $this->id){
                $goals_for = $goals_for + $game->team1_points;
                $goals_against = $goals_against + $game->team2_points;
            }else{
                $goals_for = $goals_for + $game->team2_points;
                $goals_against = $goals_against + $game->team1_points;
            }
        }

        $points = ($wins * 3) + $draws;
        $goals_diff = $goals_for - $goals_against;

        $this->games_played = $played;
        $this->wins = $wins;
        $this->draws = $draws;
        $this->losses = $losses;
        $this->goals_for = $goals_for;
        $this->goals_against = $goals_against;
        $this->goals_diff = $goals_diff;
        $this->points = $points;
        $this->save();
    }

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'name' => 'required|alpha_num|max:255',
        'flag' => 'required|alpha|max:2',
        'points' => 'required|numeric',
        'group_id' => 'exists:group,id',
    );
}