app.controller('DealerController', function ($scope, $rootScope, $http, $modal, Dealer, Kota) {
    $scope.dealers            = [];
    $scope.kotas              = [];
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadDealer = function () {
        $scope.main.promise = Dealer.getDealer().success(function (response) {
            $scope.dealers = response;
        });
    };

    $scope.reloadKota = function () {
        $scope.main.promise = Kota.getKotaDropdownAllSecured().success(function (response) {
            $scope.kotas = response;
        });
    };

    $scope.createDealer = function () {
        var modalInstance = Dealer.createModal($scope.kotas);

        modalInstance.result.then(function (addedItem) {
            $scope.dealers.push(addedItem);
        });
    };

    $scope.updateDealer = function (dealer) {
        var modalInstance = Dealer.updateModal(dealer, $scope.kotas);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.dealers.length; i++) {
                if ($scope.dealers[i].id == editedItem.id) {
                    $scope.dealers[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteDealer = function (dealer) {
        var modalInstance = Dealer.deleteModal(dealer);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.dealers.length; i++) {
                if ($scope.dealers[i].id == deletedItem.id) {
                    $scope.dealers.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (dealer) {
        Dealer.toogleActive(dealer.id).success(function (response) {
            for (var i = 0; i < $scope.dealers.length; i++) {
                if ($scope.dealers[i].id == response.dealer.id) {
                    $scope.dealers[i] = response.dealer;
                    break;
                }
            }
        });
    };

    $scope.reloadDealer();
    $scope.reloadKota();
});