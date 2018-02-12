app.factory('BookingServiceResource', function ($resource) {
    return $resource(base_url + "secured/api/booking-service/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        queryBookingService: {
            method: 'POST',
            url: base_url + "secured/api/booking-service/get-booking-service"
        }
    })
});