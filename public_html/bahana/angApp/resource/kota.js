app.factory('KotaResource', function ($resource) {
    return $resource(base_url + "secured/api/kota/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/kota/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/kota/toogle/:id",
            method: 'POST'
        }
    })
});