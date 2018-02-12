app.factory('Part', function Part($http, Modal) {
    return {
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/part/formModal.html',
                'CreatePartModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(part) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/part/formModal.html',
                'UpdatePartModalController',
                'md',
                {
                    part: function () {
                        return part;
                    }
                }
            );
        },
        detailModal: function detailModal(part) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/part/detailModal.html',
                'DetailPartModalController',
                'md',
                {
                    part: function () {
                        return part;
                    }
                }
            );
        },
        deleteModal: function deleteModal(part) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/part/deleteModal.html',
                'DeletePartModalController',
                'sm',
                {
                    part: function () {
                        return part;
                    }
                }
            );
        }
    }
});