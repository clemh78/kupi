/**
 * Controlleur des matchs
 *
 * AngularJS version 1.2.0
 *
 * @category   angular controller
 * @package    worldcup\public\js\controllers
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */

angular.module('gamesController', [])

    .controller('gamesControllerList', ["$scope", "games", "gamesPrevious", "bracket", "groups", function($scope, games, gamesPrevious, bracket, groups) {
        $scope.games = games.data;
        $scope.gamesPrevious = gamesPrevious.data;
        $scope.groups = groups.data;

        $("#rounds").gracket({
            src : bracket.data['rounds'],
            cornerRadius : 10,
            canvasLineGap : 10,
            roundLabels : bracket.data['labels']
        });

        $("#third").gracket({
            src : bracket.data['third'],
            cornerRadius : 10,
            canvasLineGap : 10
        });

        // add some labels
        $("#bracket .secondary-bracket .g_winner")
            .parent()
            .css("position", "relative")
            .prepend("<h4>3ème place</h4>")

        $("#bracket > div").eq(0).find(".g_winner")
            .parent()
            .css("position", "relative")
            .prepend("<h4>Gagnant</h4>")

        $('#groups').hide();
        $('#bracket').hide();
        $('#gamesPrevious').hide();
        $('#games').show();

        $scope.betColor = function(game, teamDisplay){

            if(!game.user_bet)
                return null;
            
            if(game.user_bet.team1_points == game.user_bet.team2_points && game.user_bet.winner_id != null) {
                if (game.user_bet.winner_id == game.team1_id && teamDisplay == 1)
                    return 'btn-success';

                if (game.user_bet.winner_id == game.team2_id && teamDisplay == 2)
                    return 'btn-success';

                return 'btn-warning';
            }

            if(teamDisplay == 1)
                return (game.user_bet.team1_points>game.user_bet.team2_points) ? 'btn-success' : ((game.user_bet.team1_points<game.user_bet.team2_points) ? 'btn-danger' : 'btn-warning');
            else
                return (game.user_bet.team2_points>game.user_bet.team1_points) ? 'btn-success' : ((game.user_bet.team2_points<game.user_bet.team1_points) ? 'btn-danger' : 'btn-warning');
        }

        $scope.filterList = function(){
            $('#filter-gamesPrevious').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-groups').parent('li').removeClass('active');
            $('#filter-list').parent('li').addClass('active');
            $('.bracket-header').hide();
            $('#bracket').hide();
            $('.game-header').show();
            $('#games').show();
            $('.game-previous-header').hide();
            $('#gamesPrevious').hide();
            $('#groups').hide();
            $('.groups-header').hide();
        };

        $scope.filterBracket = function(){
            $('#filter-list').parent('li').removeClass('active');
            $('#filter-gamesPrevious').parent('li').removeClass('active');
            $('#filter-groups').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').addClass('active');
            $('.game-header').hide();
            $('#games').hide();
            $('.bracket-header').show();
            $('#bracket').show();
            $('.game-previous-header').hide();
            $('#gamesPrevious').hide();
            $('#groups').hide();
            $('.groups-header').hide();
        };

        $scope.filterGamesPrevious = function(){
            $('#filter-list').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-groups').parent('li').removeClass('active');
            $('#filter-gamesPrevious').parent('li').addClass('active');
            $('.game-header').hide();
            $('#games').hide();
            $('.bracket-header').hide();
            $('#bracket').hide();
            $('.game-previous-header').show();
            $('#gamesPrevious').show();
            $('#groups').hide();
            $('.groups-header').hide();
        };

        $scope.filterGroups = function(){
            $('#filter-gamesPrevious').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-groups').parent('li').addClass('active');
            $('#filter-list').parent('li').removeClass('active');
            $('.bracket-header').hide();
            $('#bracket').hide();
            $('.game-header').hide();
            $('#games').hide();
            $('.game-previous-header').hide();
            $('#gamesPrevious').hide();
            $('#groups').show();
            $('.groups-header').show();
        };
    }])

    .controller('gamesControllerModal', function ($scope, $modal) {

        $scope.open = function (game) {
            $modal.open({
                templateUrl: '/views/partials/gameInfo.html?v=' + VERSION,
                controller: 'gamesControllerModalInstance',
                resolve: {
                    game: function(){
                        return game;
                    },
                    bets: [ "serviceGame", "$cookies", function(Game, $cookies){
                        return Game.GetBets($cookies['token'], game.id);
                    }]
                }
            });
        };
    })


    .controller('gamesControllerModalInstance', ["$scope", "$modalInstance", "$cookies", "game", "bets", function ($scope, $modalInstance, $cookies, game, bets) {
        $scope.game = game;

        $scope.teams = [game.team1, game.team2];

        $scope.bets = bets.data;

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    }])

    .controller('helpControllerModal', function ($scope, $modal) {

        $scope.open = function () {
            $modal.open({
                templateUrl: '/views/partials/help.html?v=' + VERSION,
                controller: 'helpControllerModalInstance',
                resolve: {
                }
            });
        };
    })


    .controller('helpControllerModalInstance', ["$scope", "$modalInstance", "$cookies", function ($scope, $modalInstance, $cookies) {

    }]);