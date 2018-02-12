app.controller('CreateUserModalController', function ($scope, $http, $modalInstance, User, roles) {
    $scope.title   = "Create New User";
    $scope.status  = 'create';
    $scope.success = false;
    $scope.errors  = [];
    $scope.roles   = roles;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.data = function () {
        var data     = $('#UserForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');
        //formData.append('file', $scope.file);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = User.createUser($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.user);
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
