app.controller('UpdateAksesorisDetailModalController', function ($scope, $http, $modalInstance, AksesorisDetail, WarnaResource, AksesorisDetailResource, aksesorisDetail) {
    $scope.title           = "Mengubah Aksesoris Detail " + aksesorisDetail.kode;
    $scope.aksesorisDetail = angular.copy(aksesorisDetail);
    $scope.statusCRUD      = 'update';
    $scope.success         = false;
    $scope.errors          = [];

    $scope.selected       = {};
    $scope.selected.warna = null;

    $scope.aksesorisDetail._method = 'PUT';

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.reloadWarna = function () {
        $scope.CRUD.promise = WarnaResource.queryDropdown(function (response) {
            angular.forEach(response, function (value, key) {
                value.url = base_url + value.url;
            });
            $scope.warnas = response;
            if ($scope.aksesorisDetail.warna) {
                angular.forEach($scope.warnas, function (value, key) {
                    if ($scope.aksesorisDetail.warna.id == value.id) {
                        $scope.selected.warna                = {};
                        $scope.selected.warna.originalObject = value;
                        $scope.selected.warna.title          = value.nama;
                    }
                });
            }
        }).$promise;
    };
    $scope.reloadWarna();

    $scope.save = function () {
        $scope.success = false;
        if ($scope.selected.warna) {
            $scope.aksesorisDetail.warna = $scope.selected.warna.originalObject.id;
        }
        $scope.CRUD.promise = AksesorisDetailResource.update($scope.aksesorisDetail, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.aksesorisDetail);
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
