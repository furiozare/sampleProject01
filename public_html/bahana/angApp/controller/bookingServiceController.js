app.controller('BookingServiceController', function ($scope, $http, $modal, Service, Dealer) {
    $scope.dealers = [];
    $scope.errors  = [];
    $scope.success = false;

    $scope.main = angular.copy($scope.cgConf);

    $scope.status = {
        tanggal_waktu: {
            opened: false
        }
    };

    $scope.open = function (name) {
        $scope.status[name].opened = true;
    };

    $scope.reloadDealer = function () {
        $scope.main.promise = Dealer.getDealerDropdownAktif().success(function (response) {
            $scope.dealers = response;
        });
    };

    $scope.data = function () {
        var data     = $('#BookingServiceForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.errors       = [];
        $scope.main.promise = Service.saveBookingService($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                }
                if (typeof response.errors !== 'undefined') {
                    $scope.errors = response.errors;
                }
            });
    };

    $scope.reloadDealer();
});