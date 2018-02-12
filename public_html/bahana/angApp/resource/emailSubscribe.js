app.factory('EmailSubscribeResource', function ($resource) {
    return $resource(base_url + "secured/api/email-subscribe/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        toogleActive: {
            url: base_url + "secured/api/email-subscribe/toogle-active/:id",
            method: 'POST'
        }
    })
});