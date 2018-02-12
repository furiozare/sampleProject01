app.factory('KategoriPartResource', function ($resource) {
    return $resource(base_url + "secured/api/kategori-part/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/kategori-part/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/kategori-part/toogle/:id",
            method: 'POST'
        }
    })
});