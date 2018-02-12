app.controller('HeadlineFrontController', function ($scope, $http, $modal, Headline) {
    $scope.headlines = [];

    $scope.loadingHeadlines = angular.copy($scope.cgConf);

    $scope.reloadHeadline = function () {
        $scope.loadingHeadlines.promise = Headline.getFrontHeadline().success(function (response) {
            $scope.headlines = response;
        });
    };

    $scope.reloadHeadline();
});