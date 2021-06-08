<?php
/**
 * Modèle de donnée des appartenances d'utilisateurs à des salons
 *
 * PHP version 5.5
 *
 * @category   Modèles
 * @package    worldcup\app\models
 * @author     Clément Hémidy <clement@hemidy.fr>
 * @copyright  2021 Clément Hémidy
 * @version    1.0
 * @since      0.1
 */

class RoomUser extends Eloquent {

    /**
     * Table corespondant sur le SGBD
     *
     * @var string
     */
    protected $table = 'room_user';

    public $timestamps = false;

    protected $fillable = array('user_id', 'room_id', 'display_name');

    protected $with = array('room');

    /**
     * Définition des règles de vérifications pour les entrées utilisateurs et le non retour des erreur mysql
     *
     * @var array
     */
    public static $rules = array(
        'user_id' => 'required|exists:user,id',
        'room_id' => 'required|exists:room,id',
        'display_name' => 'required|max:255',
    );

    public function room()
    {
        return $this->belongsTo('Room', 'room_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

}