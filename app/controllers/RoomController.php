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

}