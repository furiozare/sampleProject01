app.factory('Headline', function Headline($http, Modal) {
    return {
        getFrontHeadline: function getFrontHeadline() {
            return $http({
                url: base_url + "headline/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getHeadline: function getHeadline() {
            return $http({
                url: base_url + "secured/headline/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createHeadline: function createHeadline(data) {
            return $http({
                url: base_url + "secured/headline/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        updateHeadline: function updateHeadline(id, data) {
            return $http({
                url: base_url + "secured/headline/" + id,
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        deleteHeadline: function deleteHeadline(id) {
            return $http({
                url: base_url + "secured/headline/" + id,
                method: 'DELETE',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/headline/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/headline/formModal.html',
                'CreateHeadlineModalController',
                'md',
                {}
            );
        },
        updateModal: function updateModal(headline) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/headline/formModal.html',
                'UpdateHeadlineModalController',
                'md',
                {
                    headline: function () {
                        return headline;
                    }
                }
            );
        },
        deleteModal: function deleteModal(headline) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/headline/deleteModal.html',
                'DeleteHeadlineModalController',
                'sm',
                {
                    headline: function () {
                        return headline;
                    }
                }
            );
        }
    }
});