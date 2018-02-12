app.factory('Kontak', function Kontak($http, Modal) {
    return {
        getAllKontakSecured: function getAllKontakSecured() {
            return $http({
                url: base_url + "secured/kontak/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        saveKontak: function saveKontak(data) {
            return $http({
                url: base_url + "kontak/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        }
    }
});