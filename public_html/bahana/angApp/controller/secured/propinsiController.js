app.controller('PropinsiController', function ($scope, $rootScope, $http, $modal, Propinsi) {
    $scope.propinsis          = [];
    $rootScope.sorting        = "created_at";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadPropinsi = function () {
        $scope.main.promise = Propinsi.getPropinsi().success(function (response) {
            $scope.propinsis = response;
        });
    };

    $scope.createPropinsi = function () {
        var modalInstance = Propinsi.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.propinsis.push(addedItem);
        });
    };

    $scope.updatePropinsi = function (propinsi) {
        var modalInstance = Propinsi.updateModal(propinsi);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.propinsis.length; i++) {
                if ($scope.propinsis[i].id == editedItem.id) {
                    $scope.propinsis[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deletePropinsi = function (propinsi) {
        var modalInstance = Propinsi.deleteModal(propinsi);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.propinsis.length; i++) {
                if ($scope.propinsis[i].id == deletedItem.id) {
                    $scope.propinsis.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (propinsi) {
        Propinsi.toogleActive(propinsi.id).success(function (response) {
            for (var i = 0; i < $scope.propinsis.length; i++) {
                if ($scope.propinsis[i].id == response.propinsi.id) {
                    $scope.propinsis[i] = response.propinsi;
                    break;
                }
            }
        });
    };

    $scope.reloadPropinsi();
});