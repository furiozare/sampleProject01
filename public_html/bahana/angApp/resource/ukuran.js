app.factory('UkuranResource', function ($resource) {
    return $resource(base_url + "secured/api/ukuran/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/ukuran/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/ukuran/toogle/:id",
            method: 'POST'
        }
    })
});