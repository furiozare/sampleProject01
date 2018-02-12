app.controller('CreateHargaOTRFromKendaraanModalController', function ($scope, $http, $modalInstance, HargaOTR, HargaOTRResource, KotaResource, kendaraan) {
    $scope.title        = "Membuat Harga OTR baru";
    $scope.statusCRUD   = 'create';
    $scope.errors       = [];
    $scope.hargaOTR     = new HargaOTRResource();
    $scope.kendaraan    = kendaraan;
    $scope.kotas        = [];
    $scope.selectedKota = "";

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.reloadKota = function () {
        $scope.CRUD.promise = KotaResource.queryDropdown(function (response) {
            $scope.kotas = response;
        }).$promise;
    };
    $scope.reloadKota();

    $scope.save = function () {
        $scope.hargaOTR.kota      = $scope.selectedKota;
        $scope.hargaOTR.kendaraan = $scope.kendaraan.id;
        $scope.CRUD.promise       = HargaOTRResource.save($scope.hargaOTR, function (response) {
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
