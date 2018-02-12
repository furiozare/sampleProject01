app.factory('KategoriNewsResource', function ($resource) {
    return $resource(base_url + "secured/api/kategori-news/:id", {id: '@id'}, {
        update: {method: 'POST'},
        delete: {
            method: 'POST'
        },
        create: {
            url: base_url + "secured/api/kategori-news",
            method: 'POST'
        },
        queryDropdown: {
            url: base_url + "secured/api/kategori-news/get-dropdown-all",
            isArray: true,
            method: 'GET'
        },
        toogleActive: {
            url: base_url + "secured/api/kategori-news/toogle/:id",
            method: 'POST'
        }
    })
});