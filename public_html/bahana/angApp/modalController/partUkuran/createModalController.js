app.controller('CreatePartUkuranModalController', function ($scope, $http, $modalInstance, PartUkuran, UkuranResource, PartUkuranResource, part) {
    $scope.title      = "Membuat Part Ukuran baru";
    $scope.statusCRUD = 'create';
    $scope.success    = false;
    $scope.part       = part;
    $scope.errors     = [];
    $scope.ukurans    = [];
    $scope.partUkuran = new PartUkuranResource();

    $scope.selected        = {};
    $scope.selected.ukuran = null;

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
        }).$promise;
    };
    $scope.reloadUkuran();

    $scope.save = function () {
        if ($scope.selected.ukuran) {
            $scope.partUkuran.ukuran = $scope.selected.ukuran.originalObject.id;
        }
        $scope.CRUD.promise = PartUkuranResource.create({id: part.id}, $scope.partUkuran, function (response) {
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
