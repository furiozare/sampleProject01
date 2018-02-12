app.controller('UpdateHargaOTRModalController', function ($scope, $http, $modalInstance, HargaOTR, HargaOTRResource, KendaraanResource, KotaResource, hargaOTR) {
    $scope.title             = "Mengubah Harga OTR";
    $scope.hargaOTR          = angular.copy(hargaOTR);
    $scope.statusCRUD        = 'update';
    $scope.errors            = [];
    $scope.selectedKendaraan = $scope.hargaOTR.kendaraan.id;
    $scope.selectedKota      = $scope.hargaOTR.kota.id;

    $scope.hargaOTR._method = 'PUT';

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.reloadKendaraan = function () {
        $scope.CRUD.promise = KendaraanResource.queryDropdownFront(function (response) {
            $scope.kendaraans = response;
        }).$promise;
    };
    $scope.reloadKendaraan();

    $scope.reloadKota = function () {
        $scope.CRUD.promise = KotaResource.queryDropdown(function (response) {
            $scope.kotas = response;
        }).$promise;
    };
    $scope.reloadKota();

    $scope.save = function () {
        $scope.hargaOTR.kota      = $scope.selectedKota;
        $scope.hargaOTR.kendaraan = $scope.selectedKendaraan;
        $scope.CRUD.promise       = HargaOTRResource.update($scope.hargaOTR, function (response) {
            if (response.result == 'success') {
                $modalInstance.close(response.hargaOTR);
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
