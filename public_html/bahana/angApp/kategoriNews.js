app.factory('KategoriNews', function KategoriNews($http, Modal) {
    return {
        createModal: function createModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategoriNews/formModal.html',
                'CreateKategoriNewsModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(kategoriNews) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategoriNews/formModal.html',
                'UpdateKategoriNewsModalController',
                'md',
                {
                    kategoriNews: function () {
                        return kategoriNews;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kategoriNews) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategoriNews/deleteModal.html',
                'DeleteKategoriNewsModalController',
                'sm',
                {
                    kategoriNews: function () {
                        return kategoriNews;
                    }
                }
            );
        }
    }
});