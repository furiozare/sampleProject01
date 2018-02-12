app.factory('AksesorisResource', function ($resource) {
    return $resource(base_url + "secured/api/aksesoris/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryKendaraan: {
            url: base_url + "secured/api/aksesoris/kendaraan/:id",
            isArray: true,
            method: 'GET'
        },
        create: {
            url: base_url + "secured/api/aksesoris/:id",
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/aksesoris/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/aksesoris/toogle/:id",
            method: 'POST'
        }
    })
});