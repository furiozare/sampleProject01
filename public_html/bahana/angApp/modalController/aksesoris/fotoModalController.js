app.controller('FotoAksesorisModalController', function ($scope, $http, $modalInstance, AksesorisPhoto, AksesorisResource, AksesorisPhotoResource, aksesoris) {
    $scope.title           = "Foto Aksesoris " + aksesoris.nama;
    $scope.aksesoris       = aksesoris;
    $scope.aksesorisPhotos = [];

    $scope.loadingAksesorisPhotos = angular.copy($scope.cgConf);

    $scope.reloadAksesorisPhoto = function () {
        $scope.loadingAksesorisPhotos.promise = AksesorisPhotoResource.queryAksesoris({id: aksesoris.id}, function (response) {
            $scope.aksesorisPhotos = response;
        }).$promise;
    };
    $scope.reloadAksesorisPhoto();

    $scope.createAksesorisPhoto = function () {
        var modalInstance = AksesorisPhoto.createModal(aksesoris);

        modalInstance.result.then(function (addedItem) {
            $scope.aksesorisPhotos.push(addedItem);
        });
    };

    $scope.removeAksesorisPhoto = function (aksesorisPhoto) {
        var modalInstance = AksesorisPhoto.deleteModal(aksesorisPhoto);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.aksesorisPhotos.length; i++) {
                if ($scope.aksesorisPhotos[i].id == aksesorisPhoto.id) {
                    $scope.aksesorisPhotos.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
