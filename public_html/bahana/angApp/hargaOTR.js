app.factory('HargaOTR', function HargaOTR($http, Modal) {
    return {
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/hargaOTR/formModal.html',
                'CreateHargaOTRModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(hargaOTR) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/hargaOTR/formModal.html',
                'UpdateHargaOTRModalController',
                'md',
                {
                    hargaOTR: function () {
                        return hargaOTR;
                    }
                }
            );
        },
        createFromKendaraanModal: function createFromKendaraanModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/hargaOTR/formModalFromKendaraan.html',
                'CreateHargaOTRFromKendaraanModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        updateFromKendaraanModal: function updateFromKendaraanModal(hargaOTR) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/hargaOTR/formModalFromKendaraan.html',
                'UpdateHargaOTRFromKendaraanModalController',
                'md',
                {
                    hargaOTR: function () {
                        return hargaOTR;
                    }
                }
            );
        },
        deleteModal: function deleteModal(hargaOTR) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/hargaOTR/deleteModal.html',
                'DeleteHargaOTRModalController',
                'sm',
                {
                    hargaOTR: function () {
                        return hargaOTR;
                    }
                }
            );
        }
    }
});