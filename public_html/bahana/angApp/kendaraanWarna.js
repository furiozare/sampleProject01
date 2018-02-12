app.factory('KendaraanWarna', function KendaraanWarna($http, Modal) {
    return {
        getKendaraanWarnaByKendaraan: function getKendaraanWarnaByKendaraan(kendaraanId) {
            return $http({
                url: base_url + "secured/api/kendaraan-warna/" + kendaraanId,
                method: 'GET',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createKendaraanWarna: function createKendaraanWarna(data) {
            return $http({
                url: base_url + "secured/api/kendaraan-warna",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteKendaraanWarna: function deleteKendaraanWarna(id) {
            return $http({
                url: base_url + "secured/api/kendaraan-warna/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraanWarna/formModal.html',
                'CreateKendaraanWarnaModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kendaraanWarna) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraanWarna/deleteModal.html',
                'DeleteKendaraanWarnaModalController',
                'sm',
                {
                    kendaraanWarna: function () {
                        return kendaraanWarna;
                    }
                }
            );
        }
    }
});