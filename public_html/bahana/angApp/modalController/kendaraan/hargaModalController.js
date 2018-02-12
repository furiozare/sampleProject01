app.controller('HargaKendaraanModalController', function ($scope, $http, $modalInstance, HargaOTRResource, HargaOTR, kendaraan) {
    $scope.title     = "Harga OTR Kendaraan " + kendaraan.nama;
    $scope.kendaraan = kendaraan;
    $scope.hargaOTRs = [];

    $scope.sorting        = "kota.nama";
    $scope.sortingReverse = false;

    $scope.sortData = function (value) {
        if ($scope.sorting == value) {
            $scope.sortingReverse = !$scope.sortingReverse;
        } else {
            $scope.sorting        = value;
            $scope.sortingReverse = false;
        }
    };

    $scope.loadingHargaOTR = angular.copy($scope.cgConf);

    $scope.reloadHargaOTR = function () {
        $scope.loadingHargaOTR.promise = HargaOTRResource.queryKendaraan({id: kendaraan.id}, function (response) {
            $scope.hargaOTRs = response;
        }).$promise;
    };
    $scope.reloadHargaOTR();

    $scope.createHargaOTR = function () {
        var modalInstance = HargaOTR.createFromKendaraanModal(kendaraan);

        modalInstance.result.then(function (addedItem) {
            $scope.hargaOTRs.push(addedItem);
        });
    };

    $scope.updateHargaOTR = function (hargaOTR) {
        var modalInstance = HargaOTR.updateFromKendaraanModal(hargaOTR);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.hargaOTRs.length; i++) {
                if ($scope.hargaOTRs[i].id == editedItem.id) {
                    $scope.hargaOTRs[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.removeHargaOTR = function (hargaOTR) {
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

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
