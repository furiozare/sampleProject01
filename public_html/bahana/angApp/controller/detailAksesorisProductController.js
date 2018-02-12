app.controller('DetailAksesorisProductController', function ($scope, $http, $modal) {
    $scope.aksesorisPhotos  = photos;
    $scope.aksesorisDetails = details;
    $scope.selectedPhotoId  = selectedPhotoId;
    $scope.selectedDetailId = selectedDetailId;

    $scope.selectedPhoto  = null;
    $scope.selectedDetail = null;

    angular.forEach($scope.aksesorisPhotos, function (value, key) {
        if (value.id == $scope.selectedPhotoId) {
            $scope.selectedPhoto = value;
        }
    });

    angular.forEach($scope.aksesorisDetails, function (value, key) {
        if (value.id == $scope.selectedDetailId) {
            $scope.selectedDetail = value;
        }
    });

    $scope.selectPhoto = function (aksesorisPhoto) {
        $scope.selectedPhotoId = aksesorisPhoto.id;
        $scope.selectedPhoto   = aksesorisPhoto;
    };

    $scope.selectDetail = function (aksesorisDetail) {
        $scope.selectedDetailId = aksesorisDetail.id;
        $scope.selectedDetail   = aksesorisDetail;
    };
});