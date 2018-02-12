app.factory('Ukuran', function Ukuran($http, Modal) {
    return {
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/ukuran/formModal.html',
                'CreateUkuranModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(ukuran) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/ukuran/formModal.html',
                'UpdateUkuranModalController',
                'md',
                {
                    ukuran: function () {
                        return ukuran;
                    }
                }
            );
        },
        deleteModal: function deleteModal(ukuran) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/ukuran/deleteModal.html',
                'DeleteUkuranModalController',
                'sm',
                {
                    ukuran: function () {
                        return ukuran;
                    }
                }
            );
        }
    }
});