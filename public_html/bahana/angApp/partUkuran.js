app.factory('PartUkuran', function PartUkuran($http, Modal) {
    return {
        createModal: function createModal(part) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/partUkuran/formModal.html',
                'CreatePartUkuranModalController',
                'md',
                {
                    part: function () {
                        return part;
                    }
                }
            );
        },
        updateModal: function updateModal(partUkuran) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/partUkuran/formModal.html',
                'UpdatePartUkuranModalController',
                'md',
                {
                    partUkuran: function () {
                        return partUkuran;
                    }
                }
            );
        },
        deleteModal: function deleteModal(partUkuran) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/partUkuran/deleteModal.html',
                'DeletePartUkuranModalController',
                'sm',
                {
                    partUkuran: function () {
                        return partUkuran;
                    }
                }
            );
        }
    }
});