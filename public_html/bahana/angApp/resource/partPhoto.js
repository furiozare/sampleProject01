app.factory('PartPhotoResource', function ($resource) {
    return $resource(base_url + "secured/api/part-photo/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryPart: {
            url: base_url + "secured/api/part-photo/part/:id",
            isArray: true,
            method: 'GET'
        },
        create: {
            url: base_url + "secured/api/part-photo/:id",
            method: 'POST'
        }
    })
});