app.controller('ChangePasswordModalController', function ($scope, $http, $modalInstance, User) {
    $scope.title   = "Ubah Password";
    $scope.success = false;
    $scope.errors  = [];

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.data = function () {
        var data     = $('#ChangePasswordForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');
        //formData.append('file', $scope.file);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = User.changePasswordUser($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close();
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
