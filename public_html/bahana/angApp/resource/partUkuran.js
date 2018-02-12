app.factory('PartUkuranResource', function ($resource) {
    return $resource(base_url + "secured/api/part-ukuran/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryPart: {
            url: base_url + "secured/api/part-ukuran/part/:id",
            isArray: true,
            method: 'GET'
        },
        create: {
            url: base_url + "secured/api/part-ukuran/:id",
            method: 'POST'
        }
    })
});