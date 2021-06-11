<?php
/**
 * Controlleur permetant la gestion des salons
 *
 * PHP version 5.5
 *
 * @category   Controller
 * @package    worldcup\app\controllers
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */


class RoomController extends BaseController {

    /**
     * Enregistre un nouveau salon
     *
     * @return Response
     */
    public function store()
    {
        $user = User::getUserWithToken($_GET['token']);
        $input = Input::all();

        $validator = Validator::make($input, Room::$rules);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $validator->messages()
                ),
                400);

        $room = Room::create($input);
        $room->save();

        $userRoom = RoomUser::create(["user_id" => $user->id, "room_id" => $room->id, "display_name" => $user->login]);
        $userRoom->save();

        $return = $userRoom->toArray();
        $return['room'] = $room;

        return Response::json(
            array('success' => true,
                'payload' => $return,
                'message' => 'Le salon '.$room->name.' a été créé'
            ));
    }

    public function updateDisplayName($id){
        $user = User::getUserWithToken($_GET['token']);
        $roomUser = RoomUser::whereRaw('user_id = ? && room_id = ?', array($user->id, $id))->first();

        if(!$roomUser){
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => 'Vous n\'êtes pas dans ce salon !'
                ),
                400);
        }

        $input = Input::all();

        if(isset($input['display_name']) && $input['display_name'] != ""){
            $roomUser->display_name = $input['display_name'];
            $roomUser->save();

            return Response::json(
                array('success' => true,
                    'payload' => $roomUser,
                    'message' => 'Vous avez modifié votre nom dans le salon '.$roomUser->room->name
                ));
        }else{
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => 'Vous devez renseigner un nom d\'affichage !'
                ),
                400);
        }

    }

    public function leave($id){
        $user = User::getUserWithToken($_GET['token']);
        $roomUser = RoomUser::whereRaw('user_id = ? && room_id = ?', array($user->id, $id))->first();
        $count = RoomUser::whereRaw('user_id = ?', array($user->id))->count();

        if($count <= 1){
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => 'Vous devez être dans au moins 1 salon !'
                ),
                400);
        }

        if(!$roomUser){
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => 'Vous n\'êtes pas dans ce salon !'
                ),
                400);
        }

        $roomUser->delete();

        return Response::json(
            array('success' => true,
                'payload' => $roomUser,
                'message' => 'Vous avez quitté le salon '.$roomUser->room->name
            ));

    }

}