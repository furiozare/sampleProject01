app.controller('BlastArtikelModalController', function ($scope, $http, $modalInstance, ArtikelResource, artikel) {
    $scope.title   = "Blast Artikel " + artikel.judul;
    $scope.artikel = angular.copy(artikel);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.artikel._method = 'POST';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = ArtikelResource.blast($scope.artikel, function (response) {
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
