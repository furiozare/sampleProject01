app.controller('CreateArtikelModalController', function ($scope, $http, $modalInstance, Artikel, ArtikelResource, KategoriNewsResource) {
    $scope.title         = "Membuat Artikel baru";
    $scope.statusCRUD    = 'create';
    $scope.success       = false;
    $scope.errors        = [];
    $scope.artikel       = new ArtikelResource();
    $scope.kategoriNewss = [];

    $scope.selected              = {};
    $scope.selected.kategoriNews = null;

    $scope.CRUD = angular.copy($scope.cgConf);

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
        if ($scope.selected.kategoriNews) {
            $scope.artikel.kategori_news = $scope.selected.kategoriNews.originalObject.id;
        } else {
            $scope.artikel.kategori_news = '';
        }
        $scope.CRUD.promise = ArtikelResource.create($scope.artikel, function (response) {
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
