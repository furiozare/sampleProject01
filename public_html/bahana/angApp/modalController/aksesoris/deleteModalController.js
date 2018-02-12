app.controller('DeleteAksesorisModalController', function ($scope, $http, $modalInstance, Aksesoris, AksesorisResource, aksesoris) {
    $scope.title     = "Menghapus Aksesoris " + aksesoris.nama;
    $scope.aksesoris = angular.copy(aksesoris);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.aksesoris._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = AksesorisResource.delete($scope.aksesoris, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.aksesoris);
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
