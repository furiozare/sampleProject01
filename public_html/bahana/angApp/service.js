app.factory('Service', function Service($http, Modal) {
    return {
        getAllBookingServiceSecured: function getAllBookingServiceSecured() {
            return $http({
                url: base_url + "secured/service/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        saveBookingService: function saveBookingService(data) {
            return $http({
                url: base_url + "service/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        }
    }
});