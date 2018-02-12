app.factory('Aksesoris', function Aksesoris($http, Modal) {
    return {
        createModal: function createModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesoris/formModal.html',
                'CreateAksesorisModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        updateModal: function updateModal(aksesoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesoris/formModal.html',
                'UpdateAksesorisModalController',
                'md',
                {
                    aksesoris: function () {
                        return aksesoris;
                    }
                }
            );
        },
        detailModal: function detailModal(aksesoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesoris/detailModal.html',
                'DetailAksesorisModalController',
                'md',
                {
                    aksesoris: function () {
                        return aksesoris;
                    }
                }
            );
        },
        fotoModal: function fotoModal(aksesoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesoris/fotoModal.html',
                'FotoAksesorisModalController',
                'md',
                {
                    aksesoris: function () {
                        return aksesoris;
                    }
                }
            );
        },
        deleteModal: function deleteModal(aksesoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesoris/deleteModal.html',
                'DeleteAksesorisModalController',
                'sm',
                {
                    aksesoris: function () {
                        return aksesoris;
                    }
                }
            );
        }
    }
});