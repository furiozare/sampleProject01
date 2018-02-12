app.factory('Kota', function Kota($http, Modal) {
    return {
        getFrontKota: function getFrontKota() {
            return $http({
                url: base_url + "kota/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKotaDropdownAllSecured: function getKotaDropdownAllSecured() {
            return $http({
                url: base_url + "secured/kota/get-dropdown-all",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getKota: function getKota() {
            return $http({
                url: base_url + "secured/kota/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createKota: function createKota(data) {
            return $http({
                url: base_url + "secured/kota/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateKota: function updateKota(id, data) {
            return $http({
                url: base_url + "secured/kota/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteKota: function deleteKota(id) {
            return $http({
                url: base_url + "secured/kota/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/kota/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal(propinsis) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kota/formModal.html',
                'CreateKotaModalController',
                'md',
                {
                    propinsis: function () {
                        return propinsis;
                    }
                }
            );
        },
        updateModal: function updateModal(kota, propinsis) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kota/formModal.html',
                'UpdateKotaModalController',
                'md',
                {
                    kota: function () {
                        return kota;
                    },
                    propinsis: function () {
                        return propinsis;
                    }
                }
            );
        },
        deleteModal: function deleteModal(kota) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/kota/deleteModal.html',
                'DeleteKotaModalController',
                'sm',
                {
                    kota: function () {
                        return kota;
                    }
                }
            );
        }
    }
});