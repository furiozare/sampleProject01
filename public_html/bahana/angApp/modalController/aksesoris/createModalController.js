app.controller('CreateAksesorisModalController', function ($scope, $http, $modalInstance, Aksesoris, AksesorisResource, kendaraan) {
    $scope.title      = "Membuat Aksesoris baru";
    $scope.statusCRUD = 'create';
    $scope.success    = false;
    $scope.kendaraan  = kendaraan;
    $scope.errors     = [];
    $scope.aksesoris  = new AksesorisResource();

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.CRUD.promise = AksesorisResource.create({id: kendaraan.id}, $scope.aksesoris, function (response) {
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
