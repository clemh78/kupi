<?php
/**
 * Modèle de donnée des paris
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

class Bet extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'bet';

    /**
     * Liste des champs assignable en masse
     *
     * @var array
     */
    protected $fillable = array('user_id', 'game_id', 'winner_id', 'team1_points', 'team2_points');

    /**
     * Liste des champs qui peuvent servir de filter dans l'url
     *
     * @var array
     */
    public $filters = array('game_id', 'user_id', 'team1_points', 'team2_points');

    /**
     * Table corespondant au champ caché sur les retours JSON
     *
     * @var array
     */
    protected $hidden = array('updated_at');

    /**
     * Récupère l'objet Match indiqué
     *
     * @var Stage
     */
    public function game()
    {
        return $this->belongsTo('Game', 'game_id', 'id');
    }

    /**
     * Récupère l'objet User
     *
     * @var Stage
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

    public function getWinPointsAttribute()
    {
        $total = DB::table('transaction')->where('user_id', '=', $this->user_id)->where('game_id', '=', $this->game_id)->where(function($req){$req->where('type', '=', 'gain')->orWhere('type', '=', 'bonus');})->sum('value');
        $total = $total - DB::table('transaction')->where('user_id', '=', $this->user_id)->where('game_id', '=', $this->game_id)->where(function($req){$req->where('type', '=', 'bet');})->sum('value');

        return $total;
    }

    public function toArray()
    {
        $array = parent::toArray();
        foreach ($this->getMutatedAttributes() as $key)
        {
            if ( ! array_key_exists($key, $array)) {
                $array[$key] = $this->{$key};
            }
        }
        return $array;
    }

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'user_id' => 'exists:user,id',
        'game_id' => 'exists:game,id',
        'team1_points' => 'required|integer|min:0',
        'team2_points' => 'required|integer|min:0',
        'winner_id' => 'exists:team,id',
    );
}