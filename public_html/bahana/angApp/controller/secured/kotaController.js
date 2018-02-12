app.controller('KotaController', function ($scope, $rootScope, $http, $modal, Kota, Propinsi) {
    $scope.kotas              = [];
    $scope.propinsis          = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadKota = function () {
        $scope.main.promise = Kota.getKota().success(function (response) {
            $scope.kotas = response;
        });
    };

    $scope.reloadPropinsi = function () {
        $scope.main.promise = Propinsi.getPropinsiDropdownAllSecured().success(function (response) {
            $scope.propinsis = response;
        });
    };

    $scope.createKota = function () {
        var modalInstance = Kota.createModal($scope.propinsis);

        modalInstance.result.then(function (addedItem) {
            $scope.kotas.push(addedItem);
        });
    };

    $scope.updateKota = function (kota) {
        var modalInstance = Kota.updateModal(kota, $scope.propinsis);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.kotas.length; i++) {
                if ($scope.kotas[i].id == editedItem.id) {
                    $scope.kotas[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteKota = function (kota) {
        var modalInstance = Kota.deleteModal(kota);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kotas.length; i++) {
                if ($scope.kotas[i].id == deletedItem.id) {
                    $scope.kotas.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (kota) {
        Kota.toogleActive(kota.id).success(function (response) {
            for (var i = 0; i < $scope.kotas.length; i++) {
                if ($scope.kotas[i].id == response.kota.id) {
                    $scope.kotas[i] = response.kota;
                    break;
                }
            }
        });
    };

    $scope.reloadKota();
    $scope.reloadPropinsi();
});