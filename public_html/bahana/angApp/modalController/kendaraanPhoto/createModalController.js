app.controller('CreateKendaraanPhotoModalController', function ($scope, $http, $modalInstance, KendaraanPhoto, kendaraan) {
    $scope.title     = "Membuat Kendaraan Photo baru";
    $scope.status    = 'create';
    $scope.success   = false;
    $scope.kendaraan = kendaraan;
    $scope.errors    = [];

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.data = function () {
        var data     = $('#KendaraanPhotoForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');
        formData.append('file', $scope.file);
        formData.append('kendaraan', $scope.kendaraan.id);

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = KendaraanPhoto.createKendaraanPhoto($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.kendaraanPhoto);
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
