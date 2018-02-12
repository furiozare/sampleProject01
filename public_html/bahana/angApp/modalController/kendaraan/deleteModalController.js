app.controller('DeleteKendaraanModalController', function ($scope, $http, $modalInstance, Kendaraan, kendaraan) {
    $scope.title     = "Menghapus Kendaraan";
    $scope.kendaraan = angular.copy(kendaraan);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Kendaraan.deleteKendaraan($scope.kendaraan.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.kendaraan);
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
