app.controller('DeletePartModalController', function ($scope, $http, $modalInstance, Part, PartResource, part) {
    $scope.title = "Menghapus Part " + part.nama;
    $scope.part  = angular.copy(part);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.part._method = 'DELETE';

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = PartResource.delete($scope.part, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.part);
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
