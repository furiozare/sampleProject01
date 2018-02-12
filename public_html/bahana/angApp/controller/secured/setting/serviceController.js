app.controller('ServiceController', function ($scope, $http, $modal, Setting) {
    $scope.errors  = [];
    $scope.service = {};

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadService = function () {
        $scope.main.promise = Setting.getSettingService().success(function (response) {
            $scope.service = response.service;
        });
    };

    $scope.data = function () {
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('service', $scope.service.setting_value);

        return formData;
    };

    $scope.save = function () {
        $scope.main.promise = Setting.updateSettingService($scope.data()).success(function (response) {
            if (response.result == 'success') {
                $scope.service = response.setting.service;
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.reloadService();
});