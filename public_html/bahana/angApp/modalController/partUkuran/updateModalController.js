app.controller('UpdatePartUkuranModalController', function ($scope, $http, $modalInstance, PartUkuran, UkuranResource, PartUkuranResource, partUkuran) {
    $scope.title      = "Mengubah Part Ukuran " + partUkuran.kode;
    $scope.partUkuran = angular.copy(partUkuran);
    $scope.statusCRUD = 'update';
    $scope.success    = false;
    $scope.errors     = [];

    $scope.selected        = {};
    $scope.selected.ukuran = null;

    $scope.partUkuran._method = 'PUT';

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.reloadUkuran = function () {
        $scope.CRUD.promise = UkuranResource.queryDropdown(function (response) {
            angular.forEach(response, function (value, key) {
                value.url = base_url + value.url;
            });
            $scope.ukurans = response;
            if ($scope.partUkuran.ukuran) {
                angular.forEach($scope.ukurans, function (value, key) {
                    if ($scope.partUkuran.ukuran.id == value.id) {
                        $scope.selected.ukuran                = {};
                        $scope.selected.ukuran.originalObject = value;
                        $scope.selected.ukuran.title          = value.nama;
                    }
                });
            }
        }).$promise;
    };
    $scope.reloadUkuran();

    $scope.save = function () {
        $scope.success = false;
        if ($scope.selected.ukuran) {
            $scope.partUkuran.ukuran = $scope.selected.ukuran.originalObject.id;
        }
        $scope.CRUD.promise = PartUkuranResource.update($scope.partUkuran, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.partUkuran);
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
