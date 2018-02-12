app.controller('HeadlineController', function ($scope, $rootScope, $http, $modal, Headline) {
    $scope.headlines          = [];
    $rootScope.sorting        = "created_at";
    $rootScope.sortingReverse = true;

    $scope.main = angular.copy($scope.cgConf);

    $scope.reloadHeadline = function () {
        $scope.main.promise = Headline.getHeadline().success(function (response) {
            $scope.headlines = response;
        });
    };

    $scope.createHeadline = function () {
        var modalInstance = Headline.createModal();

        modalInstance.result.then(function (addedItem) {
            $scope.headlines.push(addedItem);
        });
    };

    $scope.updateHeadline = function (headline) {
        var modalInstance = Headline.updateModal(headline);

        modalInstance.result.then(function (editedItem) {
            for (var i = 0; i < $scope.headlines.length; i++) {
                if ($scope.headlines[i].id == editedItem.id) {
                    $scope.headlines[i] = editedItem;
                    break;
                }
            }
        });
    };

    $scope.deleteHeadline = function (headline) {
        var modalInstance = Headline.deleteModal(headline);

        modalInstance.result.then(function (deletedItem) {
            for (var i = 0; i < $scope.headlines.length; i++) {
                if ($scope.headlines[i].id == deletedItem.id) {
                    $scope.headlines.splice(i, 1);
                    break;
                }
            }
        });
    };

    $scope.toogleActive = function (headline) {
        Headline.toogleActive(headline.id).success(function (response) {
            for (var i = 0; i < $scope.headlines.length; i++) {
                if ($scope.headlines[i].id == response.headline.id) {
                    $scope.headlines[i] = response.headline;
                    break;
                }
            }
        });
    };

    $scope.reloadHeadline();
});