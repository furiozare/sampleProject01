app.controller('BookingServiceController', function ($scope, $rootScope, $http, $modal, Service, BookingServiceResource, DealerResource) {
    $scope.bookingServices    = [];
    $scope.dealers            = [];
    $scope.first              = true;
    $scope.startDate          = '';
    $scope.endDate            = '';
    $scope.dealer             = '';
    $rootScope.sorting        = "tanggal_waktu";
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

    $scope.selected        = {};
    $scope.selected.dealer = null;

    $scope.clearSelected = function (selected) {
        $scope.$broadcast('angucomplete-alt:clearInput', selected);
    };

    $scope.getBookingService = function () {
        if ($scope.selected.dealer) {
            $scope.dealer = $scope.selected.dealer.originalObject.id;
        } else {
            $scope.dealer = '';
        }
        $scope.main.promise = BookingServiceResource.queryBookingService({
            startDate: moment($scope.startDate).format('YYYY-MM-DD'),
            endDate: moment($scope.endDate).format('YYYY-MM-DD'),
            dealer: $scope.dealer
        }, function (response) {
            $scope.first = false;
            if (response.result == 'success') {
                $scope.bookingServices = response.bookingServices;
            }
        }).$promise;
    };

    $scope.reloadDealer = function () {
        $scope.main.promise = DealerResource.queryDropdown(function (response) {
            $scope.dealers = response;
        }).$promise;
    };
    $scope.reloadDealer();
});