app.controller('UkuranController', function ($scope, $rootScope, $http, $modal, Ukuran, UkuranResource) {
    $scope.ukurans            = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadUkuran = function () {
        $scope.main.promise = UkuranResource.query(function (response) {
            $scope.ukurans = response;
        }).$promise;
    };

    $scope.createUkuran = function () {
        var modalInstance = Ukuran.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.ukurans.push(addedItem);
        });
    };

    $scope.updateUkuran = function (ukuran) {
        var modalInstance = Ukuran.updateModal(ukuran);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.ukurans.length; i++) {
                if ($scope.ukurans[i].id == editedItem.id) {
                    $scope.ukurans[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteUkuran = function (ukuran) {
        var modalInstance = Ukuran.deleteModal(ukuran);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.ukurans.length; i++) {
                if ($scope.ukurans[i].id == ukuran.id) {
                    $scope.ukurans.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (ukuran) {
        UkuranResource.toogleActive({id: ukuran.id}, function (response) {
            for (var i = 0; i < $scope.ukurans.length; i++) {
                if ($scope.ukurans[i].id == response.ukuran.id) {
                    $scope.ukurans[i] = response.ukuran;
                    break;
                }
            }
        });
    };

    $scope.reloadUkuran();
});