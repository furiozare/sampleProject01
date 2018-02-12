app.controller('DetailProductController', function ($scope, $http, $modal) {
    $scope.kendaraanPhotos = photos;
    $scope.kendaraanWarnas = warnas;
    $scope.selectedPhotoId = selectedPhotoId;
    $scope.selectedWarnaId = selectedWarnaId;
    $scope.kendaraanSlug   = kendaraanSlug;
    $scope.kategoriSlug    = kategoriSlug;

    $scope.selectedPhoto = null;
    $scope.selectedWarna = null;

    angular.forEach($scope.kendaraanPhotos, function (value, key) {
        if (value.id == $scope.selectedPhotoId) {
            $scope.selectedPhoto = value;
        }
    });

    angular.forEach($scope.kendaraanWarnas, function (value, key) {
        if (value.id == $scope.selectedWarnaId) {
            $scope.selectedWarna = value;
        }
    });

    $scope.selectPhoto = function (kendaraanPhoto) {
        $scope.selectedPhotoId = kendaraanPhoto.id;
        $scope.selectedPhoto   = kendaraanPhoto;
    };

    $scope.selectWarna = function (kendaraanWarna) {
        $scope.selectedWarnaId = kendaraanWarna.id;
        $scope.selectedWarna   = kendaraanWarna;
    };

    $scope.pesanProduct = function () {
        window.location.href = base_url + 'product/pesan/' + $scope.kategoriSlug + '/' + $scope.kendaraanSlug + '/' + $scope.selectedWarnaId;
    };
});