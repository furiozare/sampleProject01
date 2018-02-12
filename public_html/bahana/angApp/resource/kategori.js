app.factory('KategoriResource', function ($resource) {
    return $resource(base_url + "secured/api/kategori/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/kategori/get-dropdown-all",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/kategori/toogle/:id",
            method: 'POST'
        }
    })
});