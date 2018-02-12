app.factory('WarnaResource', function ($resource) {
    return $resource(base_url + "secured/api/warna/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/warna/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/warna/toogle/:id",
            method: 'POST'
        }
    })
});