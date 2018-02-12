app.controller('CreateAksesorisDetailModalController', function ($scope, $http, $modalInstance, AksesorisDetail, WarnaResource, AksesorisDetailResource, aksesoris) {
    $scope.title           = "Membuat Aksesoris Detail baru";
    $scope.statusCRUD      = 'create';
    $scope.success         = false;
    $scope.aksesoris       = aksesoris;
    $scope.errors          = [];
    $scope.warnas          = [];
    $scope.aksesorisDetail = new AksesorisDetailResource();

    $scope.selected       = {};
    $scope.selected.warna = null;

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
        }).$promise;
    };
    $scope.reloadWarna();

    $scope.save = function () {
        if ($scope.selected.warna) {
            $scope.aksesorisDetail.warna = $scope.selected.warna.originalObject.id;
        }
        $scope.CRUD.promise = AksesorisDetailResource.create({id: aksesoris.id}, $scope.aksesorisDetail, function (response) {
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
