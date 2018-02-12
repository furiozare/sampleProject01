app.controller('InformasiKontakController', function ($scope, $http, $modal, Setting) {
    $scope.errors  = [];
    $scope.alamat  = {};
    $scope.fax     = {};
    $scope.email   = {};
    $scope.telepon = {};

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadInformasiKontak = function () {
        $scope.main.promise = Setting.getSettingInformasiKontak().success(function (response) {
            $scope.alamat  = response.alamat;
            $scope.fax     = response.fax;
            $scope.telepon = response.telepon;
        });
    };

    $scope.data = function () {
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('alamat', $scope.alamat.setting_value);
        formData.append('fax', $scope.fax.setting_value);
        formData.append('telepon', $scope.telepon.setting_value);
        formData.append('email', $scope.email.setting_value);

        return formData;
    };

    $scope.save = function () {
        $scope.main.promise = Setting.updateSettingInformasiKontak($scope.data()).success(function (response) {
            if (response.result == 'success') {
                $scope.alamat  = response.setting.alamat;
                $scope.fax     = response.setting.fax;
                $scope.telepon = response.setting.telepon;
                $scope.email   = response.setting.email;
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };

    $scope.reloadInformasiKontak();
});