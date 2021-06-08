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
            $users[] = ["id" => $roomUser->user_id, "display_name" => $roomUser->display_name, "winPoints" => $roomUser->user->winPoints];
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

}