app.controller('KategoriController', function ($scope, $rootScope, $http, $modal, Kategori, KategoriResource) {
    $scope.kategoris          = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadKategori = function () {
        $scope.main.promise = KategoriResource.query(function (response) {
            $scope.kategoris = response;
        });
    };

    $scope.createKategori = function () {
        var modalInstance = Kategori.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.kategoris.push(addedItem);
        });
    };

    $scope.updateKategori = function (kategori) {
        var modalInstance = Kategori.updateModal(kategori);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.kategoris.length; i++) {
                if ($scope.kategoris[i].id == editedItem.id) {
                    $scope.kategoris[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteKategori = function (kategori) {
        var modalInstance = Kategori.deleteModal(kategori);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kategoris.length; i++) {
                if ($scope.kategoris[i].id == deletedItem.id) {
                    $scope.kategoris.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (kategori) {
        KategoriResource.toogleActive(kategori, function (response) {
            for (var i = 0; i < $scope.kategoris.length; i++) {
                if ($scope.kategoris[i].id == response.kategori.id) {
                    $scope.kategoris[i] = response.kategori;
                    break;
                }
            }
        });
    };

    $scope.reloadKategori();
});