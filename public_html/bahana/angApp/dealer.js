app.factory('Dealer', function Dealer($http, Modal) {
    return {
        getFrontDealer: function getFrontDealer() {
            return $http({
                url: base_url + "dealer/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getDealerDropdownAktif: function getDealerDropdownAktif() {
            return $http({
                url: base_url + "dealer/get-dropdown-aktif",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getDealerDropdownAllSecured: function getDealerDropdownAllSecured() {
            return $http({
                url: base_url + "secured/dealer/get-dropdown-all",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getDealer: function getDealer() {
            return $http({
                url: base_url + "secured/dealer/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createDealer: function createDealer(data) {
            return $http({
                url: base_url + "secured/dealer/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateDealer: function updateDealer(id, data) {
            return $http({
                url: base_url + "secured/dealer/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteDealer: function deleteDealer(id) {
            return $http({
                url: base_url + "secured/dealer/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/dealer/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal(kotas) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/dealer/formModal.html',
                'CreateDealerModalController',
                'md',
                {
                    kotas: function () {
                        return kotas;
                    }
                }
            );
        },
        updateModal: function updateModal(dealer, kotas) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/dealer/formModal.html',
                'UpdateDealerModalController',
                'md',
                {
                    dealer: function () {
                        return dealer;
                    },
                    kotas: function () {
                        return kotas;
                    }
                }
            );
        },
        deleteModal: function deleteModal(dealer) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/dealer/deleteModal.html',
                'DeleteDealerModalController',
                'sm',
                {
                    dealer: function () {
                        return dealer;
                    }
                }
            );
        }
    }
});