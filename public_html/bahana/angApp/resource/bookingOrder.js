app.factory('BookingOrderResource', function ($resource) {
    return $resource(base_url + "secured/api/booking-order/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryBookingOrder: {
            method: 'POST',
            url: base_url + "secured/api/booking-order/get-booking-order"
        }
    })
});