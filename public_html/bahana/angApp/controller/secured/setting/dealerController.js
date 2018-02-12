app.controller('DealerController', function ($scope, $http, $modal, Setting) {
    $scope.errors = [];
    $scope.dealer = {};

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadDealer = function () {
        $scope.main.promise = Setting.getSettingDealer().success(function (response) {
            $scope.dealer = response.dealer;
        });
    };

    $scope.data = function () {
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('dealer', $scope.dealer.setting_value);

        return formData;
    };

    $scope.save = function () {
        $scope.main.promise = Setting.updateSettingDealer($scope.data()).success(function (response) {
            if (response.result == 'success') {
                $scope.dealer = response.setting.dealer;
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.reloadDealer();
});