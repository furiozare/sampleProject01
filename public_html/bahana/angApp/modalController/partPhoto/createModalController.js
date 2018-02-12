app.controller('CreatePartPhotoModalController', function ($scope, $http, $modalInstance, PartPhoto, PartPhotoResource, part) {
    $scope.title      = "Membuat Part Photo baru";
    $scope.statusCRUD = 'create';
    $scope.success    = false;
    $scope.part       = part;
    $scope.errors     = [];
    $scope.warnas     = [];
    $scope.partPhoto  = new PartPhotoResource();

    $scope.selected       = {};
    $scope.selected.warna = null;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.partPhoto.file = $scope.file;

        $scope.CRUD.promise = PartPhotoResource.create({id: part.id}, $scope.partPhoto, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.partPhoto);
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
