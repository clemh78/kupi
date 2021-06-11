/**
 * Controlleur des utilisateurs
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

angular.module('usersController', [])

    .controller('usersControllerModal', ["$scope", "serviceUser", "$cookies", "$modal", function($scope, User, $cookies, $modal) {

        $scope.ranking = function(){
            $modal.open({
                templateUrl: '/views/partials/rankingList.html?v=' + VERSION,
                controller: 'usersControllerListModalInstance',
                size: 'lg',
                resolve: {
                }
            });
        };

        $scope.account = function(user){
            $modal.open({
                templateUrl:'/views/partials/accountForm.html?v=' + VERSION,
                controller: 'usersControllerAccountModalInstance',
                resolve:{
                    user: function(){
                        return user;
                    }
                }
            });
        };

        $scope.room = function(user){
            $modal.open({
                templateUrl:'/views/partials/room.html?v=' + VERSION,
                controller: 'usersControllerRoomModalInstance',
                resolve:{
                    user: function(){
                        return user;
                    }
                }
            });
        };

    }])

    .controller('usersControllerListModalInstance', ["$scope", "$rootScope", "$filter", "serviceUser","$cookies", "$modalInstance", function($scope, $rootScope, $filter, User, $cookies, $modalInstance) {
        $scope.roomsTmp = [];
        $scope.rooms = [];

        angular.forEach($rootScope.user.rooms, function(roomUser, key) {
            $scope.roomsTmp.push(angular.copy(roomUser.room));
        });

        //TRIE + gestion des ex æquo
        angular.forEach($scope.roomsTmp, function(room, key) {
            if(room != undefined){
                users = $filter('orderBy')(room.users, ['-winPoints', 'display_name', 'id']);

                index = 1;
                rank = null;
                lastScore = null;
                angular.forEach(users, function(user, key) {
                    if(lastScore != user.winPoints)
                        rank = index;
                    user.rank = rank;

                    index++;
                    lastScore = user.winPoints;
                });
            }
        });

        angular.forEach($scope.roomsTmp, function(room, key) {
            if(room != undefined)
                $scope.rooms.push(room);
        });

        $scope.select = function(){
            $scope.usersSelect = $filter('orderBy')($scope.selector.users, ['-winPoints', 'display_name', 'id']);
        };

        $scope.callSearch = function(users, user_id) {
            return $filter('filter')(users, { id: user_id }, true)[0];
        };

        $scope.showRank = function(index){
            if(index == 0)
                return true;
            if($scope.usersSelect[index-1].rank != $scope.usersSelect[index].rank)
                return true;
            return false;
        }

        $scope.selector = $scope.rooms[0];
        $scope.select();
    }])

    .controller('usersControllerAccountModalInstance', ["$scope", "$rootScope", "$modalInstance", "$cookies", "serviceUser", "user", function($scope, $rootScope, $modalInstance, $cookies, User, user) {
        $scope.user = user;

        $scope.userData = {};

        $scope.ok = function () {
            User.update($cookies['token'], $cookies['user_id'], $scope.userData)
                .success(function(data){
                    $rootScope.user = data;
                });
            $modalInstance.dismiss('ok');
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    }])

    .controller('usersControllerRoomModalInstance', ["$scope", "$rootScope", "$modalInstance", "$cookies", "serviceUser", "user", "serviceRoom", function($scope, $rootScope, $modalInstance, $cookies, User, user, Room) {
        $scope.user = user;
        $scope.editedRoomName = [];

        $scope.addRoom = function(){
            User.join($cookies['token'], $scope.roomCode)
                .success(function(data){
                    $rootScope.user = data;
                    $scope.user = data;
                });
        };

        $scope.createRoom = function(){
            Room.create($cookies['token'], $scope.newRoomName, $scope.newRoomCode)
                .success(function(data){
                    $rootScope.user.rooms.push(data);
                });
        };

        $scope.leave = function(id){
            if (confirm("Vous allez quitter le salon !")) {
                Room.leave($cookies['token'], id)
                    .success(function(data){
                    });
            }
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };

        $scope.updateDisplayName = function (){
            Room.updateDisplayName($cookies['token'], $scope.editedRoom, $scope.editedRoomName[$scope.editedRoom])
                .success(function(data){
                    $scope.editedRoomRaw.display_name = $scope.editedRoomName[$scope.editedRoom];
                    $scope.editedRoom = undefined;
                });
        }

        $scope.editDisplayName = function (room){
            if(room == undefined){
                $scope.editedRoom = undefined;
                $scope.editedRoomRaw = undefined;
            }else{
                $scope.editedRoomRaw = room;
                $scope.editedRoom = room.room.id;
                $scope.editedRoomName[room.room.id] = angular.copy(room.display_name);
            }
        }
    }]);
