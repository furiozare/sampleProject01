app.controller('CreateKendaraanWarnaModalController', function ($scope, $http, $modalInstance, WarnaResource, KendaraanWarna, kendaraan) {
    $scope.title     = "Membuat Kendaraan Warna baru";
    $scope.status    = 'create';
    $scope.success   = false;
    $scope.kendaraan = kendaraan;
    $scope.errors    = [];
    $scope.warnas    = [];
    WarnaResource.queryDropdown(function (data) {
        angular.forEach(data, function (value, key) {
            value.url = base_url + value.url;
        });
        $scope.warnas = data;
    });

    $scope.selected       = {};
    $scope.selected.warna = null;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.data = function () {
        var data     = $('#KendaraanWarnaForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');
        if ($scope.selected.warna) {
            formData.append('warna', $scope.selected.warna.originalObject.id);
        }
        formData.append('kendaraan', $scope.kendaraan.id);

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = KendaraanWarna.createKendaraanWarna($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.kendaraanWarna);
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
