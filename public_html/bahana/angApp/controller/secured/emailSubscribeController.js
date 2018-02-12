app.controller('EmailSubscribeController', function ($scope, $rootScope, $http, $modal, EmailSubscribe, EmailSubscribeResource) {
    $scope.emailSubscribes    = [];
    $rootScope.sorting        = "created_at";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadEmailSubscribe = function () {
        $scope.main.promise = EmailSubscribeResource.query(function (response) {
            $scope.emailSubscribes = response;
        });
    };
    $scope.reloadEmailSubscribe();

    $scope.toogleActiveEmailSubscribe = function (emailSubscribe) {
        var modalInstance = EmailSubscribe.toogleActiveModal(emailSubscribe);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.emailSubscribes.length; i++) {
                if ($scope.emailSubscribes[i].id == deletedItem.id) {
                    $scope.emailSubscribes[i] = deletedItem;
                    break;
                }
            }
        });
    };
});