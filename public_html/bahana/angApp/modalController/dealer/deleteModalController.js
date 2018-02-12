app.controller('DeleteDealerModalController', function ($scope, $http, $modalInstance, Dealer, dealer) {
    $scope.title  = "Menghapus Dealer";
    $scope.dealer = angular.copy(dealer);

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.save = function () {
        $scope.success = false;

        $scope.CRUD.promise = Dealer.deleteDealer($scope.dealer.id)
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close($scope.dealer);
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
