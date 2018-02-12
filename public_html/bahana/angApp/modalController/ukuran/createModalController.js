app.controller('CreateUkuranModalController', function ($scope, $http, $modalInstance, Ukuran, UkuranResource) {
    $scope.title      = "Membuat Ukuran baru";
    $scope.statusCRUD = 'create';
    $scope.success    = false;
    $scope.errors     = [];
    $scope.ukuran     = new UkuranResource();

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

        formData.append('_method', 'POST');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = UkuranResource.save($scope.ukuran, function (response) {
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
