app.factory('HargaOTRFrontResource', function ($resource) {
    return $resource(base_url + "secured/api/harga-otr/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryKendaraan: {
            url: base_url + "api/harga-otr/kendaraan/:id",
            isArray: true,
            method: 'GET'
        },
        queryKendaraanSlug: {
            url: base_url + "api/harga-otr/kendaraan-slug/:kategoriSlug/:kendaraanSlug",
            params: {kategoriSlug: '@kategoriSlug', kendaraanSlug: '@kendaraanSlug'},
            isArray: true,
            method: 'GET'
        }
    })
});