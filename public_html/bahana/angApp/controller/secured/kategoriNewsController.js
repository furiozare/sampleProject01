app.controller('KategoriNewsController', function ($scope, $rootScope, $http, $modal, KategoriNews, KategoriNewsResource) {
    $scope.kategoriNewss      = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadKategoriNews = function () {
        $scope.main.promise = KategoriNewsResource.query(function (response) {
            $scope.kategoriNewss = response;
        }).$promise;
    };
    $scope.reloadKategoriNews();

    $scope.createKategoriNews = function () {
        var modalInstance = KategoriNews.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.kategoriNewss.push(addedItem);
        });
    };

    $scope.updateKategoriNews = function (kategoriNews) {
        var modalInstance = KategoriNews.updateModal(kategoriNews);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.kategoriNewss.length; i++) {
                if ($scope.kategoriNewss[i].id == editedItem.id) {
                    $scope.kategoriNewss[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteKategoriNews = function (kategoriNews) {
        var modalInstance = KategoriNews.deleteModal(kategoriNews);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.kategoriNewss.length; i++) {
                if ($scope.kategoriNewss[i].id == kategoriNews.id) {
                    $scope.kategoriNewss.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (kategori) {
        KategoriNewsResource.toogleActive(kategori, function (response) {
            for (var i = 0; i < $scope.kategoriNewss.length; i++) {
                if ($scope.kategoriNewss[i].id == response.kategoriNews.id) {
                    $scope.kategoriNewss[i] = response.kategoriNews;
                    break;
                }
            }
        });
    };
});