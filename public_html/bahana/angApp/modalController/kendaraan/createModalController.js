app.controller('CreateKendaraanModalController', function ($scope, $http, $modalInstance, Kendaraan, kategoris) {
    $scope.title     = "Membuat Kendaraan baru";
    $scope.status    = 'create';
    $scope.success   = false;
    $scope.errors    = [];
    $scope.kendaraan = {};
    $scope.kategoris = kategoris;

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

        formData.append('_method', 'POST');
        formData.append('description', $scope.kendaraan.description);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = Kendaraan.createKendaraan($scope.data())
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
