app.controller('UpdateKategoriModalController', function ($scope, $http, $modalInstance, Kategori, kategori) {
    $scope.title      = "Mengubah Kategori";
    $scope.kategori   = angular.copy(kategori);
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
        var data     = $('#KategoriForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'PUT');
        formData.append('file', $scope.file);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Kategori.updateKategori($scope.kategori.id, $scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.kategori);
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
