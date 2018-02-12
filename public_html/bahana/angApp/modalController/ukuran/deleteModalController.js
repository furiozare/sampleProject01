app.controller('DeleteUkuranModalController', function ($scope, $http, $modalInstance, Ukuran, UkuranResource, ukuran) {
    $scope.title  = "Menghapus Ukuran";
    $scope.ukuran = angular.copy(ukuran);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.ukuran._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = UkuranResource.delete($scope.ukuran, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.ukuran);
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
