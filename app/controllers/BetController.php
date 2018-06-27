<?php
/**
 * Controlleur permetant la gestion des paris
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


class BetController extends BaseController {


    /**
     * Renvoi tout les paris en JSON
     *
     * @return Response
     */
    public function index()
    {
        $user = User::getUserWithToken($_GET['token']);

        $bet = new Bet();
        $_GET['user_id'] = $user->id;

        return Response::json(
            array('success' => true,
                'payload' => $this->query_params($bet)->toArray(),
            ));
    }

    /**
     * Renvoi un paris
     *
     * @return Response
     */
    public function show($id)
    {

        $user = User::getUserWithToken($_GET['token']);

        return Response::json(
            array('success' => true,
                'payload' => Bet::with('game')->whereRaw('user_id = ? && id = ?', array($user->id), $id)->toArray(),
            ));
    }

    /**
     * Enregistre un nouveau paris
     *
     * @return Response
     */
    public function store()
    {
        $user = User::getUserWithToken($_GET['token']);

        $input = Input::all();
        $input['user_id'] = $user->id;

        $validator = Validator::make($input, Bet::$rules, BaseController::$messages);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $this->errorsArraytoString($validator->messages())
                ),
                400);

        //On vérifie si la date du match n'est pas dépassé
        if(new DateTime() > new DateTime(Game::find($input['game_id'])->date))
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Le date du match est dépassé !"
                ),
                400);

        $bet = Bet::whereRaw('user_id = ? && game_id = ?', array($input['user_id'], $input['game_id']))->first();
        //Si un paris sur le même match pour cet utilisateur existe, erreur envoyée.
        if($bet)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Un paris existe déjà sur ce match !"
                ),
                400);

        $game = Game::find($input['game_id']);

        //On vérifie si le winner est bien une équipe du match
        if($input['winner_id'] != $game->team1_id && $input['winner_id'] != $game->team2_id && $input['winner_id'] != null)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Veuillez mettre une équipe du match !"
                ),
                400);

        $input['winner_id'] = ($input['winner_id'] != null)?$input['winner_id']:null;

        if($game->kick_at_goal && $input['winner_id'] == null)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Veuillez mettre une équipe gagnante !"
                ),
                400);

        $bet = Bet::create($input);

        return Response::json(
            array('success' => true,
                'payload' => $bet->toArray(),
                'message' => 'Pari enregistré sur : '.$game->team1->name.' - '.$game->team2->name
            ));
    }

    /**
     * Modifie un pari existant
     *
     * @return Response
     */
    public function update($id)
    {
        $user = User::getUserWithToken($_GET['token']);
        $bet = Bet::find($id);

        if(!$bet){
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'message' => 'Le pari n\'existe pas !'
                ));
        }

        if($bet->user_id != $user->id){
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'message' => 'Le pari ne vous appartient pas !'
                ));
        }

        $input = Input::all();

        $validator = Validator::make($input, Bet::$rules, BaseController::$messages);

        if ($validator->fails())
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => $this->errorsArraytoString($validator->messages())
                ),
                400);

        //On vérifie si la date du match n'est pas dépassé
        if(new DateTime() > new DateTime($bet->game->date))
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "La date du match est dépassée !"
                ),
                400);

        $game = Game::find($bet->game->id);

        //On vérifie si le winner est bien une équipe du match
        if($input['winner_id'] != $game->team1_id && $input['winner_id'] != $game->team2_id && $input['winner_id'] != null)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Veuillez mettre une équipe du match !"
                ),
                400);

        $bet->winner_id = ($input['winner_id'] != null)?$input['winner_id']:null;
        $bet->team1_points = $input['team1_points'];
        $bet->team2_points = $input['team2_points'];

        if($game->kick_at_goal && $bet->winner_id == null)
            return Response::json(
                array('success' => false,
                    'payload' => array(),
                    'error' => "Veuillez mettre une équipe gagnante !"
                ),
                400);

        $bet->save();
        $user->save();

        $betArray = $bet->toArray();
        $betArray['user'] = $user->toArray();

        return Response::json(
            array('success' => true,
                'payload' => $betArray,
                'message' => 'Pari modifié sur : '.$game->team1->name.' - '.$game->team2->name
            ));
    }

}
