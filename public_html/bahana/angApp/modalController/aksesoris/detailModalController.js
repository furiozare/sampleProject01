app.controller('DetailAksesorisModalController', function ($scope, $http, $modalInstance, AksesorisDetail, AksesorisResource, AksesorisDetailResource, AksesorisPhotoResource, aksesoris) {
    $scope.title            = "Detail Aksesoris " + aksesoris.nama;
    $scope.aksesoris        = aksesoris;
    $scope.aksesorisDetails = [];

    $scope.loadingAksesorisDetails = angular.copy($scope.cgConf);

    $scope.reloadAksesorisDetail = function () {
        $scope.loadingAksesorisDetails.promise = AksesorisDetailResource.queryAksesoris({id: aksesoris.id}, function (response) {
            $scope.aksesorisDetails = response;
        }).$promise;
    };
    $scope.reloadAksesorisDetail();

    $scope.createAksesorisDetail = function () {
        var modalInstance = AksesorisDetail.createModal(aksesoris);

        modalInstance.result.then(function (addedItem) {
            $scope.aksesorisDetails.push(addedItem);
        });
    };

    $scope.updateAksesorisDetail = function (aksesorisDetail) {
        var modalInstance = AksesorisDetail.updateModal(aksesorisDetail);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.aksesorisDetails.length; i++) {
                if ($scope.aksesorisDetails[i].id == editedItem.id) {
                    $scope.aksesorisDetails[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.removeAksesorisDetail = function (aksesorisDetail) {
        var modalInstance = AksesorisDetail.deleteModal(aksesorisDetail);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.aksesorisDetails.length; i++) {
                if ($scope.aksesorisDetails[i].id == aksesorisDetail.id) {
                    $scope.aksesorisDetails.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
