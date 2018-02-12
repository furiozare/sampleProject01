app.controller('KontakController', function ($scope, $rootScope, $http, $modal, Kontak) {
    $scope.kontaks            = [];
    $rootScope.sorting        = "created_at";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadKontak = function () {
        $scope.main.promise = Kontak.getAllKontakSecured().success(function (response) {
            $scope.kontaks = response;
        });
    };

    $scope.reloadKontak();
});