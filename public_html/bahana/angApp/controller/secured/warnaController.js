app.controller('WarnaController', function ($scope, $rootScope, $http, $modal, Warna) {
    $scope.warnas             = [];
    $rootScope.sorting        = "created_at";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadWarna = function () {
        $scope.main.promise = Warna.getWarna().success(function (response) {
            $scope.warnas = response;
        });
    };

    $scope.createWarna = function () {
        var modalInstance = Warna.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.warnas.push(addedItem);
        });
    };

    $scope.updateWarna = function (warna) {
        var modalInstance = Warna.updateModal(warna);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.warnas.length; i++) {
                if ($scope.warnas[i].id == editedItem.id) {
                    $scope.warnas[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteWarna = function (warna) {
        var modalInstance = Warna.deleteModal(warna);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.warnas.length; i++) {
                if ($scope.warnas[i].id == deletedItem.id) {
                    $scope.warnas.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (warna) {
        Warna.toogleActive(warna.id).success(function (response) {
            for (var i = 0; i < $scope.warnas.length; i++) {
                if ($scope.warnas[i].id == response.warna.id) {
                    $scope.warnas[i] = response.warna;
                    break;
                }
            }
        });
    };

    $scope.reloadWarna();
});