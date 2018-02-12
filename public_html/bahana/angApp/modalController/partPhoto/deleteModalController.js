app.controller('DeletePartPhotoModalController', function ($scope, $http, $modalInstance, PartPhoto, PartPhotoResource, partPhoto) {
    $scope.title     = "Menghapus Part Photo " + partPhoto.kode;
    $scope.partPhoto = angular.copy(partPhoto);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.partPhoto._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = PartPhotoResource.delete($scope.partPhoto, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.partPhoto);
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
