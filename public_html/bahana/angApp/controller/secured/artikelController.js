app.controller('ArtikelController', function ($scope, $rootScope, $http, $modal, Artikel, ArtikelResource) {
    $scope.artikels           = [];
    $rootScope.sorting        = "judul";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadArtikel = function () {
        $scope.main.promise = ArtikelResource.query(function (response) {
            $scope.artikels = response;
        }).$promise;
    };
    $scope.reloadArtikel();

    $scope.createArtikel = function () {
        var modalInstance = Artikel.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.artikels.push(addedItem);
        });
    };

    $scope.updateArtikel = function (artikel) {
        var modalInstance = Artikel.updateModal(artikel);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.artikels.length; i++) {
                if ($scope.artikels[i].id == editedItem.id) {
                    $scope.artikels[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteArtikel = function (artikel) {
        var modalInstance = Artikel.deleteModal(artikel);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.artikels.length; i++) {
                if ($scope.artikels[i].id == artikel.id) {
                    $scope.artikels.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.blastArtikel = function (artikel) {
        var modalInstance = Artikel.blastModal(artikel);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.artikels.length; i++) {
                if ($scope.artikels[i].id == artikel.id) {
                    $scope.artikels[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (kategori) {
        ArtikelResource.toogleActive(kategori, function (response) {
            for (var i = 0; i < $scope.artikels.length; i++) {
                if ($scope.artikels[i].id == response.artikel.id) {
                    $scope.artikels[i] = response.artikel;
                    break;
                }
            }
        });
    };
});