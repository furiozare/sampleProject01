app.factory('AksesorisDetailResource', function ($resource) {
    return $resource(base_url + "secured/api/aksesoris-detail/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryAksesoris: {
            url: base_url + "secured/api/aksesoris-detail/aksesoris/:id",
            isArray: true,
            method: 'GET'
        },
        create: {
            url: base_url + "secured/api/aksesoris-detail/:id",
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/aksesoris-detail/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/aksesoris-detail/toogle/:id",
            method: 'POST'
        }
    })
});