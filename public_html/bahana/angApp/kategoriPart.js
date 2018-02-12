app.factory('KategoriPart', function KategoriPart($http, Modal) {
    return {
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategoriPart/formModal.html',
                'CreateKategoriPartModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(kategoriPart) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategoriPart/formModal.html',
                'UpdateKategoriPartModalController',
                'md',
                {
                    kategoriPart: function () {
                        return kategoriPart;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kategoriPart) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategoriPart/deleteModal.html',
                'DeleteKategoriPartModalController',
                'sm',
                {
                    kategoriPart: function () {
                        return kategoriPart;
                    }
                }
            );
        }
    }
});