app.factory('PartPhoto', function PartPhoto($http, Modal) {
    return {
        createModal: function createModal(part) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/partPhoto/formModal.html',
                'CreatePartPhotoModalController',
                'md',
                {
                    part: function () {
                        return part;
                    }
                }
            );
        },
        deleteModal: function deleteModal(partPhoto) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/partPhoto/deleteModal.html',
                'DeletePartPhotoModalController',
                'sm',
                {
                    partPhoto: function () {
                        return partPhoto;
                    }
                }
            );
        }
    }
});