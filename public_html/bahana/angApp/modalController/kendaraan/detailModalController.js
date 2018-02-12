app.controller('DetailKendaraanModalController', function ($scope, $http, $modalInstance, Kendaraan, Aksesoris, AksesorisResource, KendaraanWarna, KendaraanPhoto, kendaraan) {
    $scope.title           = "Detail Kendaraan " + kendaraan.nama;
    $scope.kendaraan       = kendaraan;
    $scope.kendaraanWarnas = [];
    $scope.kendaraanPhotos = [];
    $scope.aksesorises     = [];

    $scope.loadingKendaraanWarna = angular.copy($scope.cgConf);
    $scope.loadingKendaraanPhoto = angular.copy($scope.cgConf);
    $scope.loadingAksesoris      = angular.copy($scope.cgConf);

    $scope.reloadAksesoris = function () {
        $scope.loadingAksesoris.promise = AksesorisResource.queryKendaraan({id: kendaraan.id}, function (response) {
            $scope.aksesorises = response;
        }).$promise;
    };
    $scope.reloadAksesoris();

    $scope.createAksesoris = function () {
        var modalInstance = Aksesoris.createModal(kendaraan);

        modalInstance.result.then(function (addedItem) {
            $scope.aksesorises.push(addedItem);
        });
    };

    $scope.updateAksesoris = function (aksesoris) {
        var modalInstance = Aksesoris.updateModal(aksesoris);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.aksesorises.length; i++) {
                if ($scope.aksesorises[i].id == editedItem.id) {
                    $scope.aksesorises[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.detailAksesoris = function (aksesoris) {
        var modalInstance = Aksesoris.detailModal(aksesoris);
    };

    $scope.fotoAksesoris = function (aksesoris) {
        var modalInstance = Aksesoris.fotoModal(aksesoris);
    };

    $scope.removeAksesoris = function (aksesoris) {
        var modalInstance = Aksesoris.deleteModal(aksesoris);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.aksesorises.length; i++) {
                if ($scope.aksesorises[i].id == aksesoris.id) {
                    $scope.aksesorises.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActiveAksesoris = function (aksesoris) {
        AksesorisResource.toogleActive({id: aksesoris.id}, function (response) {
            for (var i = 0; i < $scope.aksesoriss.length; i++) {
                if ($scope.aksesorises[i].id == response.aksesoris.id) {
                    $scope.aksesorises[i] = response.aksesoris;
                    break;
                }
            }
        });
    };

    $scope.reloadKendaraanWarna = function () {
        $scope.loadingKendaraanWarna.promise = KendaraanWarna.getKendaraanWarnaByKendaraan(kendaraan.id).success(function (response) {
            $scope.kendaraanWarnas = response;
        });
    };
    $scope.reloadKendaraanWarna();

    $scope.createWarna = function () {
        var modalInstance = KendaraanWarna.createModal(kendaraan);

        modalInstance.result.then(function (addedItem) {
            $scope.kendaraanWarnas.push(addedItem);
        });

    };

    $scope.removeWarna = function (kendaraanWarna) {
        var modalInstance = KendaraanWarna.deleteModal(kendaraanWarna);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kendaraanWarnas.length; i++) {
                if ($scope.kendaraanWarnas[i].id == deletedItem.id) {
                    $scope.kendaraanWarnas.splice(i, 1);
                    break;
                }
            }
        });

    };

    $scope.reloadKendaraanPhoto = function () {
        $scope.loadingKendaraanPhoto.promise = KendaraanPhoto.getKendaraanPhotoByKendaraan(kendaraan.id).success(function (response) {
            $scope.kendaraanPhotos = response;
        });
    };
    $scope.reloadKendaraanPhoto();

    $scope.createPhoto = function () {
        var modalInstance = KendaraanPhoto.createModal(kendaraan);

        modalInstance.result.then(function (addedItem) {
            $scope.kendaraanPhotos.push(addedItem);
        });

    };

    $scope.removePhoto = function (kendaraanPhoto) {
        var modalInstance = KendaraanPhoto.deleteModal(kendaraanPhoto);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kendaraanPhotos.length; i++) {
                if ($scope.kendaraanPhotos[i].id == deletedItem.id) {
                    $scope.kendaraanPhotos.splice(i, 1);
                    break;
                }
            }
        });

    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
