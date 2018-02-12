app.factory('AksesorisPhotoResource', function ($resource) {
    return $resource(base_url + "secured/api/aksesoris-photo/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryAksesoris: {
            url: base_url + "secured/api/aksesoris-photo/aksesoris/:id",
            isArray: true,
            method: 'GET'
        },
        create: {
            url: base_url + "secured/api/aksesoris-photo/:id",
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/aksesoris-photo/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/aksesoris-photo/toogle/:id",
            method: 'POST'
        }
    })
});