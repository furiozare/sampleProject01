app.controller('TentangController', function ($scope, $http, $modal, Setting) {
    $scope.errors  = [];
    $scope.tentang = {};

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadTentang = function () {
        $scope.main.promise = Setting.getSettingTentang().success(function (response) {
            $scope.tentang = response.tentang;
        });
    };

    $scope.data = function () {
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('tentang', $scope.tentang.setting_value);

        return formData;
    };

    $scope.save = function () {
        $scope.main.promise = Setting.updateSettingTentang($scope.data()).success(function (response) {
            if (response.result == 'success') {
                $scope.tentang = response.setting.tentang;
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.reloadTentang();
});