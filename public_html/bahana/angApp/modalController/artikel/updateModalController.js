app.controller('UpdateArtikelModalController', function ($scope, $http, $modalInstance, KategoriNewsResource, ArtikelResource, artikel) {
    $scope.title         = "Mengubah Artikel " + artikel.judul;
    $scope.artikel       = angular.copy(artikel);
    $scope.statusCRUD    = 'update';
    $scope.success       = false;
    $scope.errors        = [];
    $scope.kategoriNewss = [];

    $scope.selected              = {};
    $scope.selected.kategoriNews = null;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.artikel._method = 'PUT';

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.reloadKategoriNews = function () {
        $scope.CRUD.promise = KategoriNewsResource.queryDropdown(function (response) {
            $scope.kategoriNewss = response;

            if ($scope.artikel.kategori_news) {
                angular.forEach($scope.kategoriNewss, function (value, key) {
                    if ($scope.artikel.kategori_news.id == value.id) {
                        $scope.selected.kategoriNews                = {};
                        $scope.selected.kategoriNews.originalObject = value;
                        $scope.selected.kategoriNews.title          = value.nama;
                    }
                });
            }
        })
    };
    $scope.reloadKategoriNews();

    $scope.save = function () {
        $scope.success = false;
        if ($scope.selected.kategoriNews) {
            $scope.artikel.kategori_news = $scope.selected.kategoriNews.originalObject.id;
        } else {
            $scope.artikel.kategori_news = '';
        }

        $scope.CRUD.promise = ArtikelResource.update($scope.artikel, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.artikel);
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
