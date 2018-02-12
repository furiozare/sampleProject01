app.controller('CreateAksesorisPhotoModalController', function ($scope, $http, $modalInstance, AksesorisPhoto, WarnaResource, AksesorisPhotoResource, aksesoris) {
    $scope.title          = "Membuat Aksesoris Photo baru";
    $scope.statusCRUD     = 'create';
    $scope.success        = false;
    $scope.aksesoris      = aksesoris;
    $scope.errors         = [];
    $scope.warnas         = [];
    $scope.aksesorisPhoto = new AksesorisPhotoResource();

    $scope.selected       = {};
    $scope.selected.warna = null;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.aksesorisPhoto.file = $scope.file;

        $scope.CRUD.promise = AksesorisPhotoResource.create({id: aksesoris.id}, $scope.aksesorisPhoto, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.aksesorisPhoto);
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
