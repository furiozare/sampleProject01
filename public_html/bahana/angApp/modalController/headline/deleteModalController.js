app.controller('DeleteHeadlineModalController', function ($scope, $http, $modalInstance, Headline, headline) {
    $scope.title    = "Menghapus Headline";
    $scope.headline = angular.copy(headline);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Headline.deleteHeadline($scope.headline.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.headline);
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
