app.controller('CreatePartModalController', function ($scope, $http, $modalInstance, Part, PartResource, KategoriPartResource) {
    $scope.title         = "Membuat Part baru";
    $scope.statusCRUD    = 'create';
    $scope.success       = false;
    $scope.errors        = [];
    $scope.part          = new PartResource();
    $scope.kategoriParts = [];

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.reloadKategoriPart = function () {
        $scope.CRUD.promise = KategoriPartResource.queryDropdown(function (response) {
            $scope.kategoriParts = response;
        }).$promise;
    };
    $scope.reloadKategoriPart();

    $scope.selected              = {};
    $scope.selected.kategoriPart = null;

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.save = function () {
        if ($scope.selected.kategoriPart) {
            $scope.part.kategoriPart = $scope.selected.kategoriPart.originalObject.id;
        }
        $scope.CRUD.promise = PartResource.save($scope.part, function (response) {
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
