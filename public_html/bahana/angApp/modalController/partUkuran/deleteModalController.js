app.controller('DeletePartUkuranModalController', function ($scope, $http, $modalInstance, PartUkuran, PartUkuranResource, partUkuran) {
    $scope.title      = "Menghapus Part Ukuran " + partUkuran.kode;
    $scope.partUkuran = angular.copy(partUkuran);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.partUkuran._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = PartUkuranResource.delete($scope.partUkuran, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.partUkuran);
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
