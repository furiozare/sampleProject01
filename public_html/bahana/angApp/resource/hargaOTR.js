app.factory('HargaOTRResource', function ($resource) {
    return $resource(base_url + "secured/api/harga-otr/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryKendaraan: {
            url: base_url + "secured/api/harga-otr/kendaraan/:id",
            isArray: true,
            method: 'GET'
        }
    })
});