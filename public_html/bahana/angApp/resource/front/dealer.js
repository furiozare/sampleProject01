app.factory('DealerFrontResource', function ($resource) {
    return $resource(base_url + "api/dealer/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "api/dealer/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        }
    })
});