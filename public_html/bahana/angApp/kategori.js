app.factory('Kategori', function Kategori($http, Modal) {
    return {
        getFrontKategori: function getFrontKategori() {
            return $http({
                url: base_url + "kategori/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKategoriDropdownAllSecured: function getKategoriDropdownAllSecured() {
            return $http({
                url: base_url + "secured/kategori/get-dropdown-all",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKategori: function getKategori() {
            return $http({
                url: base_url + "secured/kategori/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createKategori: function createKategori(data) {
            return $http({
                url: base_url + "secured/kategori/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateKategori: function updateKategori(id, data) {
            return $http({
                url: base_url + "secured/kategori/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteKategori: function deleteKategori(id) {
            return $http({
                url: base_url + "secured/kategori/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/kategori/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategori/formModal.html',
                'CreateKategoriModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(kategori) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategori/formModal.html',
                'UpdateKategoriModalController',
                'md',
                {
                    kategori: function () {
                        return kategori;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kategori) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kategori/deleteModal.html',
                'DeleteKategoriModalController',
                'sm',
                {
                    kategori: function () {
                        return kategori;
                    }
                }
            );
        }
    }
});