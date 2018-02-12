app.controller('UserController', function ($scope, $rootScope, $http, $modal, User, Role) {
    $scope.users       = [];
    $scope.roles       = [];
    $rootScope.sorting = "username";

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadUser = function () {
        $scope.main.promise = User.getUser().success(function (response) {
            $scope.users = response;
        });
    };

    $scope.reloadRole = function () {
        Role.getRole().success(function (response) {
            $scope.roles = response;
        });
    };

    $scope.createUser = function () {
        var modalInstance = User.createModal($scope.roles);

        modalInstance.result.then(function (addedItem) {
            $scope.users.push(addedItem);
        });
    };

    $scope.toogleActive = function (user) {
        User.toogleActive(user.id).success(function (response) {
            for (var i = 0; i < $scope.users.length; i++) {
                if ($scope.users[i].id == response.user.id) {
                    $scope.users[i] = response.user;
                    break;
                }
            }
        });
    };

    $scope.resetUser = function (user) {
        var modalInstance = User.resetModal(user);
    };

    $scope.reloadUser();
    $scope.reloadRole();
});