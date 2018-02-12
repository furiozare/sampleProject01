app.controller('UpdateKategoriPartModalController', function ($scope, $http, $modalInstance, KategoriPart, KategoriPartResource, kategoriPart) {
    $scope.title        = "Mengubah Kategori Part";
    $scope.kategoriPart = angular.copy(kategoriPart);
    $scope.statusCRUD   = 'update';
    $scope.success      = false;
    $scope.errors       = [];

    $scope.kategoriPart._method = 'PUT';

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
        var data     = $('#KategoriPartForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'PUT');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.kategoriPart.file = $scope.file;
        $scope.CRUD.promise      = KategoriPartResource.update($scope.kategoriPart, function (response) {
            if (response.result == 'success') {
                $modalInstance.close(response.kategoriPart);
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
