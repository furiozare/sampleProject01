app.controller('DeleteKotaModalController', function ($scope, $http, $modalInstance, Kota, kota) {
    $scope.title = "Menghapus Kota";
    $scope.kota  = angular.copy(kota);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Kota.deleteKota($scope.kota.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.kota);
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
