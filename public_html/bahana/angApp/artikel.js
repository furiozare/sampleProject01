app.factory('Artikel', function Artikel($http, Modal) {
    return {
        createModal: function createModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/artikel/formModal.html',
                'CreateArtikelModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(artikel) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/artikel/formModal.html',
                'UpdateArtikelModalController',
                'md',
                {
                    artikel: function () {
                        return artikel;
                    }
                }
            );
        },
        deleteModal: function deleteModal(artikel) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/artikel/deleteModal.html',
                'DeleteArtikelModalController',
                'sm',
                {
                    artikel: function () {
                        return artikel;
                    }
                }
            );
        },
        blastModal: function blastModal(artikel) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/artikel/blastModal.html',
                'BlastArtikelModalController',
                'sm',
                {
                    artikel: function () {
                        return artikel;
                    }
                }
            );
        }
    }
});