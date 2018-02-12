app.controller('ToogleActiveEmailSubscribeModalController', function ($scope, $http, $modalInstance, EmailSubscribeResource, emailSubscribe) {
    $scope.title          = "Mengganti status Email";
    $scope.emailSubscribe = angular.copy(emailSubscribe);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = EmailSubscribeResource.toogleActive($scope.emailSubscribe, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.emailSubscribe);
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
