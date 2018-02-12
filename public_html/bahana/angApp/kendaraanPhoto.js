app.factory('KendaraanPhoto', function KendaraanPhoto($http, Modal) {
    return {
        getKendaraanPhotoByKendaraan: function getKendaraanPhotoByKendaraan(kendaraanId) {
            return $http({
                url: base_url + "secured/api/kendaraan-photo/" + kendaraanId,
                method: 'GET',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createKendaraanPhoto: function createKendaraanPhoto(data) {
            return $http({
                url: base_url + "secured/api/kendaraan-photo",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteKendaraanPhoto: function deleteKendaraanPhoto(id) {
            return $http({
                url: base_url + "secured/api/kendaraan-photo/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraanPhoto/formModal.html',
                'CreateKendaraanPhotoModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kendaraanPhoto) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraanPhoto/deleteModal.html',
                'DeleteKendaraanPhotoModalController',
                'sm',
                {
                    kendaraanPhoto: function () {
                        return kendaraanPhoto;
                    }
                }
            );
        }
    }
});