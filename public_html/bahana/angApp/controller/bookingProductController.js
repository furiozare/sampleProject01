app.controller('BookingProductController', function ($scope, $http, $modal, BookingOrderFrontResource, DealerFrontResource, HargaOTRFrontResource) {
    $scope.kendaraanSlug    = kendaraanSlug;
    $scope.kategoriSlug     = kategoriSlug;
    $scope.kendaraanWarnaId = kendaraanWarnaId;
    $scope.bookingOrder     = new BookingOrderFrontResource();
    $scope.dealers          = [];
    $scope.hargaOTRs        = [];
    $scope.success          = false;
    $scope.selectedDealer   = null;
    $scope.selectedHargaOTR = null;
    $scope.errors           = [];
    $scope.jenisKelamin     = 1;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.status = {
        tanggalLahir: {
            opened: false
        }
    };

    $scope.open = function (name) {
        $scope.status[name].opened = true;
    };

    $scope.changeDealer = function (value) {
        $scope.selectedDealer = value;
        if ($scope.selectedDealer) {
            angular.forEach($scope.hargaOTRs, function (value, key) {
                if (value.kota.id == $scope.selectedDealer.kota.id) {
                    $scope.selectedHargaOTR = value;
                    found                   = true;
                }
            });
        } else {
            $scope.selectedHargaOTR = value;
        }
    };

    $scope.reloadDealer = function () {
        $scope.CRUD.promise = DealerFrontResource.queryDropdown(function (response) {
            $scope.dealers = response;
        }).$promise;
    };
    $scope.reloadDealer();

    $scope.reloadHargaOTR = function () {
        $scope.CRUD.promise = HargaOTRFrontResource.queryKendaraanSlug({
            kategoriSlug: $scope.kategoriSlug,
            kendaraanSlug: $scope.kendaraanSlug
        }, function (response) {
            $scope.hargaOTRs = response;
        }).$promise;
    };
    $scope.reloadHargaOTR();

    $scope.save = function () {
        $scope.success                   = false;
        $scope.bookingOrder.jenisKelamin = $scope.jenisKelamin;
        $scope.bookingOrder.dealer       = $scope.selectedDealer ? $scope.selectedDealer.id : "";
        $scope.bookingOrder.tanggalLahir = moment($scope.bookingOrder.tanggalLahir).format('YYYY-MM-DD');
        $scope.bookingOrder.hargaOTR     = $scope.selectedHargaOTR ? $scope.selectedHargaOTR.id : "";

        $scope.CRUD.promise = BookingOrderFrontResource.create({
            kategoriSlug: $scope.kategoriSlug,
            kendaraanSlug: $scope.kendaraanSlug,
            kendaraanWarnaId: $scope.kendaraanWarnaId
        }, $scope.bookingOrder, function (response) {
            if (response.result == 'success') {
                $scope.success = true;
            }
            if (typeof response.errors !== 'undefined') {
                $scope.errors = response.errors;
            }
        });
    };
});