app.controller('CreateKategoriNewsModalController', function ($scope, $http, $modalInstance, KategoriNews, KategoriNewsResource) {
    $scope.title        = "Membuat Kategori News baru";
    $scope.statusCRUD   = 'create';
    $scope.success      = false;
    $scope.errors       = [];
    $scope.kategoriNews = new KategoriNewsResource();

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.CRUD.promise = KategoriNewsResource.create($scope.kategoriNews, function (response) {
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
