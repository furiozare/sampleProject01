app.controller('DeleteKategoriPartModalController', function ($scope, $http, $modalInstance, KategoriPart, KategoriPartResource, kategoriPart) {
    $scope.title        = "Menghapus Kategori Part";
    $scope.kategoriPart = angular.copy(kategoriPart);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.kategoriPart._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = KategoriPartResource.delete($scope.kategoriPart, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.kategoriPart);
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
