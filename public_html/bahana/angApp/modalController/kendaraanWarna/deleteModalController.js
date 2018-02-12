app.controller('DeleteKendaraanWarnaModalController', function ($scope, $http, $modalInstance, KendaraanWarna, kendaraanWarna) {
    $scope.title          = "Menghapus Warna Kendaraan";
    $scope.kendaraanWarna = angular.copy(kendaraanWarna);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = KendaraanWarna.deleteKendaraanWarna($scope.kendaraanWarna.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.kendaraanWarna);
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
