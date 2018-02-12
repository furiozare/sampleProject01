app.controller('DeleteAksesorisPhotoModalController', function ($scope, $http, $modalInstance, AksesorisPhoto, AksesorisPhotoResource, aksesorisPhoto) {
    $scope.title          = "Menghapus Aksesoris Photo " + aksesorisPhoto.kode;
    $scope.aksesorisPhoto = angular.copy(aksesorisPhoto);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.aksesorisPhoto._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = AksesorisPhotoResource.delete($scope.aksesorisPhoto, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.aksesorisPhoto);
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
