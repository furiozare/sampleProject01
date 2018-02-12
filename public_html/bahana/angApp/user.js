app.factory('User', function User($http, Modal) {
    return {
        changePasswordUser: function changePasswordUser(data) {
            return $http({
                url: base_url + "secured/user/change-password",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        getUser: function getUser() {
            return $http({
                url: base_url + "secured/user/get",
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        resetUser: function resetUser(id) {
            return $http({
                url: base_url + "secured/user/reset/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createUser: function createUser(data) {
            return $http({
                url: base_url + "secured/user/",
                method: 'POST',
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        toogleActive: function toogleActive(id) {
            return $http({
                url: base_url + "secured/user/toogle/" + id,
                method: 'POST',
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity
            });
        },
        createModal: function createModal(roles) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/user/formModal.html',
                'CreateUserModalController',
                'md',
                {
                    roles: function () {
                        return roles;
                    }
                }
            );
        },
        updateModal: function updateModal(user) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/user/formModal.html',
                'UpdateUserModalController',
                'md',
                {
                    user: function () {
                        return user;
                    }
                }
            );
        },
        changePasswordModal: function changePasswordModal() {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/user/changePasswordModal.html',
                'ChangePasswordModalController',
                'md',
                {}
            );
        },
        resetModal: function resetModal(user) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/user/resetModal.html',
                'ResetUserModalController',
                'sm',
                {
                    user: function () {
                        return user;
                    }
                }
            );
        }
    }
});