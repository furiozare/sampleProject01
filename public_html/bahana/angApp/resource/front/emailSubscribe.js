app.factory('EmailSubscribeFrontResource', function ($resource) {
    return $resource(base_url + "api/email-subscribe/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        }
        // create: {
        //     url: base_url + "api/email-subscribe",
        //     method: 'POST'
        // }
    })
});