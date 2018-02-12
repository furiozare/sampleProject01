app.controller('CreateWarnaModalController', function ($scope, $http, $modalInstance, Warna) {
    $scope.title   = "Membuat Warna baru";
    $scope.status  = 'create';
    $scope.success = false;
    $scope.errors  = [];
    $scope.warna   = {};

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
        var data     = $('#WarnaForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('file', $scope.file);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = Warna.createWarna($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.warna);
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
