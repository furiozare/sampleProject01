app.controller('CreateKategoriModalController', function ($scope, $http, $modalInstance, Kategori) {
    $scope.title      = "Membuat Kategori baru";
    $scope.statusCRUD = 'create';
    $scope.success    = false;
    $scope.errors     = [];
    $scope.kategori   = {};

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

        formData.append('_method', 'POST');
        formData.append('file', $scope.file);

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = Kategori.createKategori($scope.data())
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
