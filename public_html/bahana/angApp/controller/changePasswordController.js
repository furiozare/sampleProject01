app.controller('ChangePasswordController', function ($scope, $http, $modal, User) {
    $scope.changePassword = function () {
        var modalInstance = User.changePasswordModal();
    };
});