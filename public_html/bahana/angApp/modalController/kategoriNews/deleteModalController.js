app.controller('DeleteKategoriNewsModalController', function ($scope, $http, $modalInstance, KategoriNewsResource, kategoriNews) {
    $scope.title        = "Menghapus Kategori News " + kategoriNews.nama;
    $scope.kategoriNews = angular.copy(kategoriNews);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.kategoriNews._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = KategoriNewsResource.delete($scope.kategoriNews, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.kategoriNews);
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
