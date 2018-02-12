app.controller('DeleteKategoriModalController', function ($scope, $http, $modalInstance, Kategori, kategori) {
    $scope.title    = "Menghapus Kategori";
    $scope.kategori = angular.copy(kategori);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Kategori.deleteKategori($scope.kategori.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.kategori);
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
