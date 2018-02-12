app.controller('DetailPartController', function ($scope, $http, $modal) {
    $scope.partPhotos       = photos;
    $scope.partUkurans      = ukurans;
    $scope.selectedPhotoId  = selectedPhotoId;
    $scope.selectedUkuranId = selectedUkuranId;

    $scope.selectedPhoto  = null;
    $scope.selectedUkuran = null;

    angular.forEach($scope.partPhotos, function (value, key) {
        if (value.id == $scope.selectedPhotoId) {
            $scope.selectedPhoto = value;
        }
    });

    angular.forEach($scope.partUkurans, function (value, key) {
        if (value.id == $scope.selectedUkuranId) {
            $scope.selectedUkuran = value;
        }
    });

    $scope.selectPhoto = function (partPhoto) {
        $scope.selectedPhotoId = partPhoto.id;
        $scope.selectedPhoto   = partPhoto;
    };

    $scope.selectUkuran = function (partUkuran) {
        $scope.selectedUkuranId = partUkuran.id;
        $scope.selectedUkuran   = partUkuran;
    };
});