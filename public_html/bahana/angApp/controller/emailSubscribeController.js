app.controller('EmailSubscribeController', function ($scope, $rootScope, $http, $modal, EmailSubscribeFrontResource) {
    $scope.emailSubscribe = new EmailSubscribeFrontResource();
    $scope.errors         = [];
    $scope.success        = false;

    $scope.main                   = angular.copy($scope.cgConf);
    $scope.emailSubscribe._method = "POST";

    $scope.initializeData = function () {
        $scope.emailSubscribe = new EmailSubscribeFrontResource();
        $scope.errors         = [];
    };

    $scope.save = function () {
        $scope.success      = false;
        $scope.main.promise = EmailSubscribeFrontResource.save($scope.emailSubscribe, function (response) {
            if (response.result == "success") {
                $scope.success = true;
                $scope.initializeData();
            } else {
                $scope.errors = response.errors;
            }
        });
    };
});