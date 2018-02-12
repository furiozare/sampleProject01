app.factory('Kendaraan', function Kendaraan($http, Modal) {
    return {
        getFrontKendaraan: function getFrontKendaraan() {
            return $http({
                url: base_url + "kendaraan/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKendaraanDropdownAktif: function getKendaraanDropdownAktif() {
            return $http({
                url: base_url + "kendaraan/get-dropdown-aktif",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKendaraanDropdownAllSecured: function getKendaraanDropdownAllSecured() {
            return $http({
                url: base_url + "secured/kendaraan/get-dropdown-all",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKendaraan: function getKendaraan() {
            return $http({
                url: base_url + "secured/kendaraan/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createKendaraan: function createKendaraan(data) {
            return $http({
                url: base_url + "secured/kendaraan/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateKendaraan: function updateKendaraan(id, data) {
            return $http({
                url: base_url + "secured/kendaraan/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateSpecificationKendaraan: function updateSpecificationKendaraan(id, data) {
            return $http({
                url: base_url + "secured/kendaraan/" + id + "/spec",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteKendaraan: function deleteKendaraan(id) {
            return $http({
                url: base_url + "secured/kendaraan/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/kendaraan/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal(kategoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraan/formModal.html',
                'CreateKendaraanModalController',
                'md',
                {
                    kategoris: function () {
                        return kategoris;
                    }
                }
            );
        },
        updateModal: function updateModal(kendaraan, kategoris) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraan/formModal.html',
                'UpdateKendaraanModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    },
                    kategoris: function () {
                        return kategoris;
                    }
                }
            );
        },
        detailModal: function detailModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraan/detailModal.html',
                'DetailKendaraanModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        hargaOTRModal: function hargaOTRModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraan/hargaModal.html',
                'HargaKendaraanModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        updateSpecificationModal: function updateSpecificationModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraan/specificationFormModal.html',
                'UpdateSpecificationModalController',
                'md',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kendaraan) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kendaraan/deleteModal.html',
                'DeleteKendaraanModalController',
                'sm',
                {
                    kendaraan: function () {
                        return kendaraan;
                    }
                }
            );
        }
    }
});