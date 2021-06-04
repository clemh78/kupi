<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('RoleTableSeeder');
        $this->call('GroupTableSeeder');
        $this->call('TeamTableSeeder');
        $this->call('StageTableSeeder');
        $this->call('GameTableSeeder');
        $this->call('BetBonusTypeTableSeeder');
        //$this->call('TestSeeder');
    }

}

/**
 * Population de la table "role"
 */
class RoleTableSeeder extends Seeder {
    public function run()
    {
        DB::table('role')->delete();
        Role::create(array('label' => 'Administrateur', 'description' => 'Accès à l\'ensemble de l\'application', 'access_level' => 2));
        Role::create(array('label' => 'Membre', 'description' => 'Accès aux fonctionnalités premières de l\'applciation', 'access_level' => 1));
    }
}

class GroupTableSeeder extends Seeder {

    public function run()
    {
        DB::table('group')->delete();

        Group::create(array('name' => 'Groupe A', 'code' => 'A')); //1
        Group::create(array('name' => 'Groupe B', 'code' => 'B')); //2
        Group::create(array('name' => 'Groupe C', 'code' => 'C')); //3
        Group::create(array('name' => 'Groupe D', 'code' => 'D')); //4
        Group::create(array('name' => 'Groupe E', 'code' => 'E')); //5
        Group::create(array('name' => 'Groupe F', 'code' => 'F')); //6
    }

}

class TeamTableSeeder extends Seeder {

    public function run()
    {
        DB::table('team')->delete();

        //Groupe A
        Team::create(array('name' => 'Italie', 'code' => 'ITA', 'group_id' => 1)); //1
        Team::create(array('name' => 'Suisse', 'code' => 'SUI', 'group_id' => 1));
        Team::create(array('name' => 'Turquie', 'code' => 'TUR', 'group_id' => 1));
        Team::create(array('name' => 'Pays de Galles', 'code' => 'WAL', 'group_id' => 1));

        //Groupe B
        Team::create(array('name' => 'Belgique', 'code' => 'BEL', 'group_id' => 2)); //5
        Team::create(array('name' => 'Danemark', 'code' => 'DEN', 'group_id' => 2));
        Team::create(array('name' => 'Finlande', 'code' => 'FIN', 'group_id' => 2));
        Team::create(array('name' => 'Russie', 'code' => 'RUS', 'group_id' => 2));

        //Groupe C
        Team::create(array('name' => 'Autriche', 'code' => 'AUT', 'group_id' => 3)); //9
        Team::create(array('name' => 'Pays-Bas', 'code' => 'NED', 'group_id' => 3));
        Team::create(array('name' => 'Macédoine du Nord', 'code' => 'MKD', 'group_id' => 3));
        Team::create(array('name' => 'Ukraine', 'code' => 'UKR', 'group_id' => 3));

        //Groupe D
        Team::create(array('name' => 'Croatie', 'code' => 'CRO', 'group_id' => 4)); //13
        Team::create(array('name' => 'Rép. tchèque', 'code' => 'CZE', 'group_id' => 4));
        Team::create(array('name' => 'Angleterre', 'code' => 'ENG', 'group_id' => 4));
        Team::create(array('name' => 'Écosse', 'code' => 'SCO', 'group_id' => 4));


        //Groupe E
        Team::create(array('name' => 'Pologne', 'code' => 'POL', 'group_id' => 5)); //17
        Team::create(array('name' => 'Slovaquie', 'code' => 'SVK', 'group_id' => 5));
        Team::create(array('name' => 'Espagne', 'code' => 'ESP', 'group_id' => 5));
        Team::create(array('name' => 'Suède', 'code' => 'SWE', 'group_id' => 5));

        //Groupe F
        Team::create(array('name' => 'France', 'code' => 'FRA', 'group_id' => 6)); //21
        Team::create(array('name' => 'Allemagne', 'code' => 'GER', 'group_id' => 6));
        Team::create(array('name' => 'Hongrie', 'code' => 'HUN', 'group_id' => 6));
        Team::create(array('name' => 'Portugal', 'code' => 'POR', 'group_id' => 6));
    }

}

class StageTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stage')->delete();

        Stage::create(array('name' => 'Finale'));
        Stage::create(array('name' => '1/2 finales', 'next_stage' => 1));
        Stage::create(array('name' => '1/4 de finale', 'next_stage' => 2));
        Stage::create(array('name' => '1/8 de finale', 'next_stage' => 3));

        Stage::create(array('name' => '3e place'));
    }

}

class GameTableSeeder extends Seeder {

    public function run()
    {
        DB::table('game')->delete();

        //Pools
        //Journée 1
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024447, 'team1_id' => 3, 'team2_id' => 1, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-11T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024448, 'team1_id' => 4, 'team2_id' => 2, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-12T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024449, 'team1_id' => 6, 'team2_id' => 7, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-12T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024450, 'team1_id' => 5, 'team2_id' => 8, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-12T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024451, 'team1_id' => 15, 'team2_id' => 13, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-13T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024442, 'team1_id' => 9, 'team2_id' => 11, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-13T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024441, 'team1_id' => 10, 'team2_id' => 12, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-13T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024452, 'team1_id' => 16, 'team2_id' => 14, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-14T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024454, 'team1_id' => 17, 'team2_id' => 18, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-14T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024453, 'team1_id' => 19, 'team2_id' => 20, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-14T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024455, 'team1_id' => 23, 'team2_id' => 24, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-15T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024456, 'team1_id' => 21, 'team2_id' => 22, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-15T21:00:00.000Z"))));

        //Journée 2
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024460, 'team1_id' => 7, 'team2_id' => 8, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-16T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024457, 'team1_id' => 3, 'team2_id' => 4, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-16T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024458, 'team1_id' => 1, 'team2_id' => 2, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-16T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024444, 'team1_id' => 12, 'team2_id' => 11, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-17T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024459, 'team1_id' => 6, 'team2_id' => 5, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-17T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024443, 'team1_id' => 10, 'team2_id' => 9, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-17T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024464, 'team1_id' => 20, 'team2_id' => 18, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-18T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024462, 'team1_id' => 13, 'team2_id' => 14, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-18T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024461, 'team1_id' => 15, 'team2_id' => 16, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-18T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024465, 'team1_id' => 23, 'team2_id' => 21, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-19T15:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024466, 'team1_id' => 24, 'team2_id' => 22, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-19T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024463, 'team1_id' => 19, 'team2_id' => 17, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-19T21:00:00.000Z"))));

        //Journée 3
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024468, 'team1_id' => 1, 'team2_id' => 4, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-20T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024467, 'team1_id' => 2, 'team2_id' => 3, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-20T18:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024446, 'team1_id' => 12, 'team2_id' => 9, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-21T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024445, 'team1_id' => 11, 'team2_id' => 10, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-21T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024470, 'team1_id' => 7, 'team2_id' => 5, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-21T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024469, 'team1_id' => 8, 'team2_id' => 6, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-21T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024471, 'team1_id' => 14, 'team2_id' => 15, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-22T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024472, 'team1_id' => 13, 'team2_id' => 16, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-22T21:00:00.000Z"))));

        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024474, 'team1_id' => 20, 'team2_id' => 17, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-23T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024473, 'team1_id' => 18, 'team2_id' => 19, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-23T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024475, 'team1_id' => 22, 'team2_id' => 23, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-23T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => false, 'fifa_match_id' => 2024476, 'team1_id' => 24, 'team2_id' => 21, 'date' => DateTime::createFromFormat("U", strtotime("2021-06-23T21:00:00.000Z"))));

        //8e
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024478, 'stage_id' => 4, 'team1_tmp_name' => '2A', 'team2_tmp_name' => '2B', 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-26T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024477, 'stage_id' => 4, 'team1_tmp_name' => '1A', 'team2_tmp_name' => '2C', 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-26T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024480, 'stage_id' => 4, 'team1_tmp_name' => '1C', 'team2_tmp_name' => '3D/E/F', 'stage_game_num' => 3, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-27T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024479, 'stage_id' => 4, 'team1_tmp_name' => '1B', 'team2_tmp_name' => '3A/D/E/F', 'stage_game_num' => 4, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-27T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024482, 'stage_id' => 4, 'team1_tmp_name' => '2D', 'team2_tmp_name' => '2E', 'stage_game_num' => 5, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-28T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024481, 'stage_id' => 4, 'team1_tmp_name' => '1F', 'team2_tmp_name' => '3A/B/C', 'stage_game_num' => 6, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-28T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024484, 'stage_id' => 4, 'team1_tmp_name' => '1D', 'team2_tmp_name' => '2F', 'stage_game_num' => 7, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-29T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024483, 'stage_id' => 4, 'team1_tmp_name' => '1E', 'team2_tmp_name' => '3A/B/C/D', 'stage_game_num' => 8, 'date' => DateTime::createFromFormat('U', strtotime("2021-06-29T18:00:00.000Z"))));

        //Quarts
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024485, 'stage_id' => 3, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-02T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024486, 'stage_id' => 3, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-02T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024488, 'stage_id' => 3, 'stage_game_num' => 3, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-03T18:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024487, 'stage_id' => 3, 'stage_game_num' => 4, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-03T21:00:00.000Z"))));

        //Demi
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024489, 'stage_id' => 2, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-06T21:00:00.000Z"))));
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024490, 'stage_id' => 2, 'stage_game_num' => 2, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-07T21:00:00.000Z"))));

        //Finale
        Game::create(array('kick_at_goal' => true, 'fifa_match_id' => 2024491, 'stage_id' => 1, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-11T21:00:00.000Z"))));

        //Petite Finale
        //Game::create(array('kick_at_goal' => true, 'fifa_match_id' => , 'stage_id' => 5, 'stage_game_num' => 1, 'date' => DateTime::createFromFormat('U', strtotime("2021-07-14T16:00:00.000Z"))));

    }

}

class BetBonusTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('bet_bonus_type')->delete();

        BetBonusType::create(array('label' => 'Vainqueur', 'date' => DateTime::createFromFormat("U", strtotime("2021-06-26T18:00:00.000Z")), 'trigger_data_type' => 'GAME', 'trigger_data_id' => 51, 'trigger_condition' => 'WINNER', 'trigger_points' => 50));
        BetBonusType::create(array('label' => 'Vainqueur (raté)', 'date' => DateTime::createFromFormat("U", strtotime("2021-06-26T18:00:00.000Z")), 'trigger_data_type' => 'GAME', 'trigger_data_id' => 51, 'trigger_condition' => 'LOOSER', 'trigger_points' => 25, 'linked_bbt_id' => 1));

        BetBonusType::create(array('label' => 'Finaliste', 'date' => DateTime::createFromFormat("U", strtotime("2021-06-26T18:00:00.000Z")), 'trigger_data_type' => 'GAME', 'trigger_data_id' => 51, 'trigger_condition' => 'LOOSER', 'trigger_points' => 50));
        BetBonusType::create(array('label' => 'Finaliste (raté)', 'date' => DateTime::createFromFormat("U", strtotime("2021-06-26T18:00:00.000Z")), 'trigger_data_type' => 'GAME', 'trigger_data_id' => 51, 'trigger_condition' => 'WINNER', 'trigger_points' => 25, 'linked_bbt_id' => 3));

    }

}

class TestSeeder extends Seeder {

    public function run()
    {
        User::create(array('login' => 'admin', 'firstname' => 'Admin', 'lastname' => 'A', 'password' => Hash::make('admin'), 'role_id' => 1));
        User::create(array('login' => 'user', 'firstname' => 'User', 'lastname' => 'A',  'password' => Hash::make('user'), 'role_id' => 2));

        Bet::create(array('user_id' => 1, 'game_id' => 1, 'team1_points' => 12, 'team2_points' => 1, 'winner_id' => 1));
        Bet::create(array('user_id' => 1, 'game_id' => 2, 'team1_points' => 1, 'team2_points' => 2, 'winner_id' => 3));

        Transaction::create(array('user_id' => 1, 'bet_id' => 1, "value" => 120, "type" => "gain"));
        Transaction::create(array('user_id' => 1, 'bet_id' => 2, "value" => 10, "type" => "bet"));

        $game = Game::where('id', 3)->get()->first();
        $game->team1_points = 1;
        $game->team2_points = 5;
        $game->minute = 34;
        $game->save();

        $game = Game::where('id', 1)->get()->first();
        $game->team1_points = 1;
        $game->team2_points = 10;
        $game->winner_id = 1;
        $game->save();
    }

}