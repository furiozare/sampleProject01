app.factory('EmailSubscribe', function EmailSubscribe($http, Modal) {
    return {
        toogleActiveModal: function toogleActiveModal(emailSubscribe) {
            return Modal.createNewModal(
                base_url + 'angApp/modalTemplate/emailSubscribe/toogleActiveModal.html',
                'ToogleActiveEmailSubscribeModalController',
                'sm',
                {
                    emailSubscribe: function () {
                        return emailSubscribe;
                    }
                }
            );
        }
    }
});