app.factory('Setting', function Setting($http, Modal) {
    return {
        getFrontSettingInformasiKontak: function getFrontSettingInformasiKontak() {
            return $http({
                url: base_url + "setting/kontak/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getSettingInformasiKontak: function getSettingInformasiKontak() {
            return $http({
                url: base_url + "secured/setting/kontak/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getSettingInformasiKontak2: function getSettingInformasiKontak2() {
            return $http({
                url: base_url + "secured/setting/kontak2/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getSettingTentang: function getSettingTentang() {
            return $http({
                url: base_url + "secured/setting/tentang/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getSettingService: function getSettingService() {
            return $http({
                url: base_url + "secured/setting/service/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getSettingDealer: function getSettingDealer() {
            return $http({
                url: base_url + "secured/setting/dealer/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateSettingInformasiKontak: function updateSettingInformasiKontak(data) {
            return $http({
                url: base_url + "secured/setting/kontak",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateSettingInformasiKontak2: function updateSettingInformasiKontak2(data) {
            return $http({
                url: base_url + "secured/setting/kontak2",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateSettingTentang: function updateSettingTentang(data) {
            return $http({
                url: base_url + "secured/setting/tentang",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateSettingService: function updateSettingService(data) {
            return $http({
                url: base_url + "secured/setting/service",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateSettingDealer: function updateSettingDealer(data) {
            return $http({
                url: base_url + "secured/setting/dealer",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        }
    }
});