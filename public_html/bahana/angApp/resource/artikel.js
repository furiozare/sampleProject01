app.factory('ArtikelResource', function ($resource) {
    return $resource(base_url + "secured/api/artikel/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        create: {
            url: base_url + "secured/api/artikel",
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/artikel/get-dropdown-all",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/artikel/toogle/:id",
            method: 'POST'
        },
        blast: {
            url: base_url + "secured/api/artikel/blast/:id",
            method: 'POST'
        },
        unBlast: {
            url: base_url + "secured/api/artikel/un-blast/:id",
            method: 'POST'
        }
    })
});