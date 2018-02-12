app.controller('UpdateKendaraanModalController', function ($scope, $http, $modalInstance, Kendaraan, kendaraan, kategoris) {
    $scope.title      = "Mengubah Kendaraan";
    $scope.kendaraan  = angular.copy(kendaraan);
    $scope.statusCRUD = 'update';
    $scope.success    = false;
    $scope.errors     = [];
    $scope.kategoris  = kategoris;

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
        var data     = $('#KendaraanForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'PUT');
        formData.append('description', $scope.kendaraan.description);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = Kendaraan.updateKendaraan($scope.kendaraan.id, $scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.kendaraan);
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
