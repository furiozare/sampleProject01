app.controller('UpdateAksesorisModalController', function ($scope, $http, $modalInstance, Aksesoris, AksesorisResource, aksesoris) {
    $scope.title      = "Mengubah Aksesoris " + aksesoris.nama;
    $scope.aksesoris  = angular.copy(aksesoris);
    $scope.statusCRUD = 'update';
    $scope.success    = false;
    $scope.errors     = [];

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.aksesoris._method = 'PUT';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = AksesorisResource.update($scope.aksesoris, function (response) {
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
