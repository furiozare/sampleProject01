app.controller('BookingOrderController', function ($scope, $rootScope, $http, $modal, BookingOrderResource, KendaraanResource) {
    $scope.bookingOrders      = [];
    $scope.kendaraans         = [];
    $scope.first              = true;
    $scope.startDate          = '';
    $scope.endDate            = '';
    $scope.kendaraan          = '';
    $rootScope.sorting        = "created_at";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.status = {
        startDate: {
            opened: false
        },
        endDate: {
            opened: false
        }
    };

    $scope.open = function (name) {
        $scope.status[name].opened = true;
    };

    $scope.selected           = {};
    $scope.selected.kendaraan = null;

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.getBookingOrder = function () {
        if ($scope.selected.kendaraan) {
            $scope.kendaraan = $scope.selected.kendaraan.originalObject.id;
        } else {
            $scope.kendaraan = '';
        }
        $scope.main.promise = BookingOrderResource.queryBookingOrder({
            startDate: moment($scope.startDate).format('YYYY-MM-DD'),
            endDate: moment($scope.endDate).format('YYYY-MM-DD'),
            kendaraan: $scope.kendaraan
        }, function (response) {
            $scope.first = false;
            if (response.result == 'success') {
                $scope.bookingOrders = response.bookingOrders;
            }
        }).$promise;
    };

    $scope.reloadKendaraan = function () {
        $scope.main.promise = KendaraanResource.queryDropdown(function (response) {
            $scope.kendaraans = response;
        }).$promise;
    };
    $scope.reloadKendaraan();
});