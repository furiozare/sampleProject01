app.controller('DeleteHargaOTRModalController', function ($scope, $http, $modalInstance, HargaOTR, HargaOTRResource, hargaOTR) {
    $scope.title    = "Menghapus Harga OTR";
    $scope.hargaOTR = angular.copy(hargaOTR);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.hargaOTR._method = 'DELETE';

    $scope.save = function () {
        $scope.CRUD.promise = HargaOTRResource.delete($scope.hargaOTR, function (response) {
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
