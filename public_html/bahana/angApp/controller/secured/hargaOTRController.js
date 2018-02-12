app.controller('HargaOTRController', function ($scope, $rootScope, $http, $modal, HargaOTR, HargaOTRResource) {
    $scope.hargaOTRs          = [];
    $rootScope.sorting        = "kota.nama";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadHargaOTR = function () {
        $scope.main.promise = HargaOTRResource.query(function (response) {
            $scope.hargaOTRs = response;
        }).$promise;
    };
    $scope.reloadHargaOTR();

    $scope.createHargaOTR = function () {
        var modalInstance = HargaOTR.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.hargaOTRs.push(addedItem);
        });
    };

    $scope.updateHargaOTR = function (hargaOTR) {
        var modalInstance = HargaOTR.updateModal(hargaOTR);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.hargaOTRs.length; i++) {
                if ($scope.hargaOTRs[i].id == editedItem.id) {
                    $scope.hargaOTRs[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteHargaOTR = function (hargaOTR) {
        var modalInstance = HargaOTR.deleteModal(hargaOTR);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.hargaOTRs.length; i++) {
                if ($scope.hargaOTRs[i].id == hargaOTR.id) {
                    $scope.hargaOTRs.splice(i, 1);
                    break;
                }
            }
        });
    };
});