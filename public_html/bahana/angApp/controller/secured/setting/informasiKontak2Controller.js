app.controller('InformasiKontak2Controller', function ($scope, $http, $modal, Setting) {
    $scope.errors         = [];
    $scope.jamOperasional = {};
    $scope.kunjungiKami   = {};

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadInformasiKontak = function () {
        $scope.main.promise = Setting.getSettingInformasiKontak2().success(function (response) {
            $scope.jamOperasional = response.jamOperasional;
            $scope.kunjungiKami   = response.kunjungiKami;
        });
    };

    $scope.data = function () {
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('jamOperasional', $scope.jamOperasional.setting_value);
        formData.append('kunjungiKami', $scope.kunjungiKami.setting_value);

        return formData;
    };

    $scope.save = function () {
        $scope.main.promise = Setting.updateSettingInformasiKontak2($scope.data()).success(function (response) {
            if (response.result == 'success') {
                $scope.jamOperasional = response.setting.jamOperasional;
                $scope.kunjungiKami   = response.setting.kunjungiKami;
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.reloadInformasiKontak();
});