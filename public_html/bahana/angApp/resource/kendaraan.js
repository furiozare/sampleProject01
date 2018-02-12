app.factory('KendaraanResource', function ($resource) {
    return $resource(base_url + "secured/api/kendaraan/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/kendaraan/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        queryDropdownFront: {
            url: base_url + "api/kendaraan/get-dropdown-aktif",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/kendaraan/toogle/:id",
            method: 'POST'
        }
    })
});