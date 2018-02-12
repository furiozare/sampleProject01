app.factory('AksesorisDetail', function AksesorisDetail($http, Modal) {
    return {
        createModal: function createModal(aksesoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesorisDetail/formModal.html',
                'CreateAksesorisDetailModalController',
                'md',
                {
                    aksesoris: function () {
                        return aksesoris;
                    }
                }
            );
        },
        updateModal: function updateModal(aksesorisDetail) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesorisDetail/formModal.html',
                'UpdateAksesorisDetailModalController',
                'md',
                {
                    aksesorisDetail: function () {
                        return aksesorisDetail;
                    }
                }
            );
        },
        deleteModal: function deleteModal(aksesorisDetail) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesorisDetail/deleteModal.html',
                'DeleteAksesorisDetailModalController',
                'sm',
                {
                    aksesorisDetail: function () {
                        return aksesorisDetail;
                    }
                }
            );
        }
    }
});