app.factory('AksesorisPhoto', function AksesorisPhoto($http, Modal) {
    return {
        createModal: function createModal(aksesoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesorisPhoto/formModal.html',
                'CreateAksesorisPhotoModalController',
                'md',
                {
                    aksesoris: function () {
                        return aksesoris;
                    }
                }
            );
        },
        deleteModal: function deleteModal(aksesorisPhoto) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/aksesorisPhoto/deleteModal.html',
                'DeleteAksesorisPhotoModalController',
                'sm',
                {
                    aksesorisPhoto: function () {
                        return aksesorisPhoto;
                    }
                }
            );
        }
    }
});