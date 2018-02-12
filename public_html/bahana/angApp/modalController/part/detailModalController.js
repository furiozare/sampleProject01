app.controller('DetailPartModalController', function ($scope, $http, $modalInstance, PartUkuran, PartPhoto, PartResource, PartUkuranResource, PartPhotoResource, part) {
    $scope.title       = "Detail Part " + part.nama;
    $scope.part        = part;
    $scope.partUkurans = [];
    $scope.partPhotos  = [];

    $scope.loadingPartUkurans = angular.copy($scope.cgConf);
    $scope.loadingPartPhotos  = angular.copy($scope.cgConf);

    $scope.reloadPartUkuran = function () {
        $scope.loadingPartUkurans.promise = PartUkuranResource.queryPart({id: part.id}, function (response) {
            $scope.partUkurans = response;
        }).$promise;
    };
    $scope.reloadPartUkuran();

    $scope.createPartUkuran = function () {
        var modalInstance = PartUkuran.createModal(part);

        modalInstance.result.then(function (addedItem) {
            $scope.partUkurans.push(addedItem);
        });
    };

    $scope.updatePartUkuran = function (partUkuran) {
        var modalInstance = PartUkuran.updateModal(partUkuran);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.partUkurans.length; i++) {
                if ($scope.partUkurans[i].id == editedItem.id) {
                    $scope.partUkurans[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.removePartUkuran = function (partUkuran) {
        var modalInstance = PartUkuran.deleteModal(partUkuran);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.partUkurans.length; i++) {
                if ($scope.partUkurans[i].id == partUkuran.id) {
                    $scope.partUkurans.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.reloadPartPhoto = function () {
        $scope.loadingPartPhotos.promise = PartPhotoResource.queryPart({id: part.id}, function (response) {
            $scope.partPhotos = response;
        }).$promise;
    };
    $scope.reloadPartPhoto();

    $scope.createPartPhoto = function () {
        var modalInstance = PartPhoto.createModal(part);

        modalInstance.result.then(function (addedItem) {
            $scope.partPhotos.push(addedItem);
        });
    };

    $scope.removePartPhoto = function (partPhoto) {
        var modalInstance = PartPhoto.deleteModal(partPhoto);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.partPhotos.length; i++) {
                if ($scope.partPhotos[i].id == partPhoto.id) {
                    $scope.partPhotos.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
