app.controller('KontakController', function ($scope, $http, $modal, Kontak) {
    $scope.errors  = [];
    $scope.success = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.data = function () {
        var data     = $('#KontakForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.errors       = [];
        $scope.main.promise = Kontak.saveKontak($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                }
                if (typeof response.errors !== 'undefined') {
                    $scope.errors = response.errors;
                }
            });
    };
});