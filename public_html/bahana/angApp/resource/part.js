app.factory('PartResource', function ($resource) {
    return $resource(base_url + "secured/api/part/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/part/get-dropdown-all",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/part/toogle/:id",
            method: 'POST'
        }
    })
});