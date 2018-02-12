app.controller('UpdateKategoriNewsModalController', function ($scope, $http, $modalInstance, KategoriNewsResource, kategoriNews) {
    $scope.title        = "Mengubah Kategori News " + kategoriNews.nama;
    $scope.kategoriNews = angular.copy(kategoriNews);
    $scope.statusCRUD   = 'update';
    $scope.success      = false;
    $scope.errors       = [];

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.kategoriNews._method = 'PUT';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = KategoriNewsResource.update($scope.kategoriNews, function (response) {
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
