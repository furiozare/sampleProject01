app.controller('UpdatePropinsiModalController', function ($scope, $http, $modalInstance, Propinsi, propinsi) {
    $scope.title      = "Mengubah Propinsi";
    $scope.propinsi   = angular.copy(propinsi);
    $scope.statusCRUD = 'update';
    $scope.success    = false;
    $scope.errors     = [];

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.status = {
        tanggal_mulai: {
            opened: false
        },
        tanggal_akhir: {
            opened: false
        }
    };

    $scope.open = function (name) {
        $scope.status[name].opened = true;
    };

    $scope.data = function () {
        var data     = $('#PropinsiForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'PUT');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Propinsi.updatePropinsi($scope.propinsi.id, $scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.propinsi);
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
