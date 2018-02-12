app.controller('UpdateUkuranModalController', function ($scope, $http, $modalInstance, Ukuran, UkuranResource, ukuran) {
    $scope.title      = "Mengubah Ukuran";
    $scope.ukuran     = angular.copy(ukuran);
    $scope.statusCRUD = 'update';
    $scope.success    = false;
    $scope.errors     = [];

    $scope.ukuran._method = 'PUT';

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
        var data     = $('#UkuranForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'PUT');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = UkuranResource.update($scope.ukuran, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.ukuran);
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
