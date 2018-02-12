app.factory('Warna', function Warna($http, Modal) {
    return {
        getFrontWarna: function getFrontWarna() {
            return $http({
                url: base_url + "warna/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getWarna: function getWarna() {
            return $http({
                url: base_url + "secured/warna/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createWarna: function createWarna(data) {
            return $http({
                url: base_url + "secured/warna/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateWarna: function updateWarna(id, data) {
            return $http({
                url: base_url + "secured/warna/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteWarna: function deleteWarna(id) {
            return $http({
                url: base_url + "secured/warna/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/warna/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/warna/formModal.html',
                'CreateWarnaModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(warna) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/warna/formModal.html',
                'UpdateWarnaModalController',
                'md',
                {
                    warna: function () {
                        return warna;
                    }
                }
            );
        },
        deleteModal: function deleteModal(warna) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/warna/deleteModal.html',
                'DeleteWarnaModalController',
                'sm',
                {
                    warna: function () {
                        return warna;
                    }
                }
            );
        }
    }
});