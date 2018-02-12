app.controller('PartController', function ($scope, $rootScope, $http, $modal, Part, PartResource) {
    $scope.parts              = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadPart = function () {
        $scope.main.promise = PartResource.query(function (response) {
            $scope.parts = response;
        }).$promise;
    };

    $scope.createPart = function () {
        var modalInstance = Part.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.parts.push(addedItem);
        });
    };

    $scope.updatePart = function (part) {
        var modalInstance = Part.updateModal(part);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.parts.length; i++) {
                if ($scope.parts[i].id == editedItem.id) {
                    $scope.parts[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.detailPart = function (part) {
        var modalInstance = Part.detailModal(part);
    };

    $scope.deletePart = function (part) {
        var modalInstance = Part.deleteModal(part);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.parts.length; i++) {
                if ($scope.parts[i].id == part.id) {
                    $scope.parts.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (part) {
        PartResource.toogleActive({id: part.id}, function (response) {
            for (var i = 0; i < $scope.parts.length; i++) {
                if ($scope.parts[i].id == response.part.id) {
                    $scope.parts[i] = response.part;
                    break;
                }
            }
        });
    };

    $scope.reloadPart();
});