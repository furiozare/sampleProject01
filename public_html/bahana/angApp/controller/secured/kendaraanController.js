app.controller('KendaraanController', function ($scope, $rootScope, $http, $modal, Kendaraan, Kategori) {
    $scope.kendaraans         = [];
    $scope.kategoris          = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadKendaraan = function () {
        $scope.main.promise = Kendaraan.getKendaraan().success(function (response) {
            $scope.kendaraans = response;
        });
    };

    $scope.reloadKategori = function () {
        $scope.main.promise = Kategori.getKategoriDropdownAllSecured().success(function (response) {
            $scope.kategoris = response;
        });
    };

    $scope.createKendaraan = function () {
        var modalInstance = Kendaraan.createModal($scope.kategoris);

        modalInstance.result.then(function (addedItem) {
            $scope.kendaraans.push(addedItem);
        });
    };

    $scope.detailKendaraan = function (kendaraan) {
        var modalInstance = Kendaraan.detailModal(kendaraan);
    };

    $scope.hargaOTRKendaraan = function (kendaraan) {
        var modalInstance = Kendaraan.hargaOTRModal(kendaraan);
    };

    $scope.updateKendaraan = function (kendaraan) {
        var modalInstance = Kendaraan.updateModal(kendaraan, $scope.kategoris);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.kendaraans.length; i++) {
                if ($scope.kendaraans[i].id == editedItem.id) {
                    $scope.kendaraans[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.updateSpecification = function (kendaraan) {
        var modalInstance = Kendaraan.updateSpecificationModal(kendaraan);

        modalInstance.result.then(function (updatedItem) {
            for (var i = 0; i < $scope.kendaraans.length; i++) {
                if ($scope.kendaraans[i].id == updatedItem.id) {
                    $scope.kendaraans[i] = updatedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteKendaraan = function (kendaraan) {
        var modalInstance = Kendaraan.deleteModal(kendaraan);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kendaraans.length; i++) {
                if ($scope.kendaraans[i].id == deletedItem.id) {
                    $scope.kendaraans.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (kendaraan) {
        Kendaraan.toogleActive(kendaraan.id).success(function (response) {
            for (var i = 0; i < $scope.kendaraans.length; i++) {
                if ($scope.kendaraans[i].id == response.kendaraan.id) {
                    $scope.kendaraans[i] = response.kendaraan;
                    break;
                }
            }
        });
    };

    $scope.reloadKendaraan();
    $scope.reloadKategori();
});