app.controller('DeleteWarnaModalController', function ($scope, $http, $modalInstance, Warna, warna) {
    $scope.title = "Menghapus Warna";
    $scope.warna = angular.copy(warna);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Warna.deleteWarna($scope.warna.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.warna);
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
