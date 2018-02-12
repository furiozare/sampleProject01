app.controller('DeleteKendaraanPhotoModalController', function ($scope, $http, $modalInstance, KendaraanPhoto, kendaraanPhoto) {
    $scope.title          = "Menghapus Foto Kendaraan";
    $scope.kendaraanPhoto = angular.copy(kendaraanPhoto);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = KendaraanPhoto.deleteKendaraanPhoto($scope.kendaraanPhoto.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.kendaraanPhoto);
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
