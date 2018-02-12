app.factory('Role', function Role($http, Modal) {
    return {
        getRole: function getRole() {
            return $http({
                url: base_url + "secured/role/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        }
    }
});