app.factory('DealerResource', function ($resource) {
    return $resource(base_url + "secured/api/dealer/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/dealer/get-dropdown",
            isArray: true
        }
    })
});