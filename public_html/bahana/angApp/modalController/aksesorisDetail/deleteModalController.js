app.controller('DeleteAksesorisDetailModalController', function ($scope, $http, $modalInstance, AksesorisDetail, AksesorisDetailResource, aksesorisDetail) {
    $scope.title           = "Menghapus Aksesoris Detail " + aksesorisDetail.kode;
    $scope.aksesorisDetail = angular.copy(aksesorisDetail);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.aksesorisDetail._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = AksesorisDetailResource.delete($scope.aksesorisDetail, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.aksesorisDetail);
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
