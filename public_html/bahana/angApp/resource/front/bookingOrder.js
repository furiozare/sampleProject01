app.factory('BookingOrderFrontResource', function ($resource) {
    return $resource(base_url + "api/booking-order/", {}, {
        create: {
            url: base_url + "api/booking-order/:kategoriSlug/:kendaraanSlug/:kendaraanWarnaId",
            params: {
                kategoriSlug: "@kategoriSlug",
                kendaraanSlug: "@kendaraanSlug",
                kendaraanWarnaId: "@kendaraanWarnaId"
            },
            method: 'POST'
        }
    })
});