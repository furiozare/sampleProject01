app.factory('Propinsi', function Propinsi($http, Modal) {
    return {
        getFrontPropinsi: function getFrontPropinsi() {
            return $http({
                url: base_url + "propinsi/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getPropinsiDropdownAllSecured: function getPropinsiDropdownAllSecured() {
            return $http({
                url: base_url + "secured/propinsi/get-dropdown-all",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getPropinsi: function getPropinsi() {
            return $http({
                url: base_url + "secured/propinsi/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createPropinsi: function createPropinsi(data) {
            return $http({
                url: base_url + "secured/propinsi/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updatePropinsi: function updatePropinsi(id, data) {
            return $http({
                url: base_url + "secured/propinsi/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deletePropinsi: function deletePropinsi(id) {
            return $http({
                url: base_url + "secured/propinsi/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/propinsi/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/propinsi/formModal.html',
                'CreatePropinsiModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(propinsi) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/propinsi/formModal.html',
                'UpdatePropinsiModalController',
                'md',
                {
                    propinsi: function () {
                        return propinsi;
                    }
                }
            );
        },
        deleteModal: function deleteModal(propinsi) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/propinsi/deleteModal.html',
                'DeletePropinsiModalController',
                'sm',
                {
                    propinsi: function () {
                        return propinsi;
                    }
                }
            );
        }
    }
});