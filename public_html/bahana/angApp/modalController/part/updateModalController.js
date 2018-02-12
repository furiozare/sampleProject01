app.controller('UpdatePartModalController', function ($scope, $http, $modalInstance, Part, PartResource, KategoriPartResource, part) {
    $scope.title         = "Mengubah Part " + part.nama;
    $scope.part          = angular.copy(part);
    $scope.statusCRUD    = 'update';
    $scope.success       = false;
    $scope.errors        = [];
    $scope.kategoriParts = [];

    $scope.part._method = 'PUT';

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.selected              = {};
    $scope.selected.kategoriPart = null;

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.reloadKategoriPart = function () {
        $scope.CRUD.promise = KategoriPartResource.queryDropdown(function (response) {
            $scope.kategoriParts = response;
            if ($scope.part.kategori_part) {
                angular.forEach($scope.kategoriParts, function (value, key) {
                    if ($scope.part.kategori_part.id == value.id) {
                        $scope.selected.kategoriPart                = {};
                        $scope.selected.kategoriPart.originalObject = value;
                        $scope.selected.kategoriPart.title          = value.nama;
                        //$scope.$broadcast('angucomplete-alt:changeInput', 'kategoriPart', $scope.kategoriParts[key]);
                        console.log(value);
                        console.log($scope.selected);
                    }
                });
            }
        }).$promise;
    };
    $scope.reloadKategoriPart();

    $scope.save = function () {
        if ($scope.selected.kategoriPart) {
            $scope.part.kategoriPart = $scope.selected.kategoriPart.originalObject.id;
        }
        $scope.CRUD.promise = PartResource.update($scope.part, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
                $modalInstance.close(response.part);
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
