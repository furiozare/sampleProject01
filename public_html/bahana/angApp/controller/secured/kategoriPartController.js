app.controller('KategoriPartController', function ($scope, $rootScope, $http, $modal, KategoriPart, KategoriPartResource) {
    $scope.kategoriParts      = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadKategoriPart = function () {
        $scope.main.promise = KategoriPartResource.query(function (response) {
            $scope.kategoriParts = response;
        }).$promise;
    };

    $scope.createKategoriPart = function () {
        var modalInstance = KategoriPart.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.kategoriParts.push(addedItem);
        });
    };

    $scope.updateKategoriPart = function (kategoriPart) {
        var modalInstance = KategoriPart.updateModal(kategoriPart);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.kategoriParts.length; i++) {
                if ($scope.kategoriParts[i].id == editedItem.id) {
                    $scope.kategoriParts[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteKategoriPart = function (kategoriPart) {
        var modalInstance = KategoriPart.deleteModal(kategoriPart);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kategoriParts.length; i++) {
                if ($scope.kategoriParts[i].id == kategoriPart.id) {
                    $scope.kategoriParts.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (kategoriPart) {
        KategoriPartResource.toogleActive({id: kategoriPart.id}, function (response) {
            for (var i = 0; i < $scope.kategoriParts.length; i++) {
                if ($scope.kategoriParts[i].id == response.kategoriPart.id) {
                    $scope.kategoriParts[i] = response.kategoriPart;
                    break;
                }
            }
        });
    };

    $scope.reloadKategoriPart();
});