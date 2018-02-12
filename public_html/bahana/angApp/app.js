var app = angular.module('app', [
    'ngAnimate',
    "ui.bootstrap",
    "ui.bootstrap.datetimepicker",
    "angularMoment",
    "angular-loading-bar",
    "file-model",
    "cgBusy",
    "ngCkeditor",
    "ngAside",
    "googlechart",
    "afkl.lazyImage",
    "ngResource",
    "angucomplete-alt"
]);

app.constant('uiDatetimePickerConfig', {
    dateFormat: 'yyyy-MM-dd HH:mm:ss',
    html5Types: {
        date: 'yyyy-MM-dd',
        'datetime-local': 'yyyy-MM-ddTHH:mm:ss.sss',
        'month': 'yyyy-MM'
    },
    enableDate: true,
    enableTime: true,
    todayText: 'Today',
    nowText: 'Now',
    clearText: 'Clear',
    closeText: 'Done',
    dateText: 'Date',
    timeText: 'Time',
    closeOnDateSelection: true,
    appendToBody: false,
    showButtonBar: true
});

app.config(function ($httpProvider) {
    $httpProvider.defaults.transformRequest = function (data) {
        if (data === undefined)
            return data;

        var fd = new FormData();
        angular.forEach(data, function (value, key) {
            if (value instanceof FileList) {
                if (value.length == 1) {
                    fd.append(key, value[0]);
                } else {
                    angular.forEach(value, function (file, index) {
                        fd.append(key + '_' + index, file);
                    });
                }
            } else {
                fd.append(key, value);
            }
        });

        return fd;
    };

    $httpProvider.defaults.headers.post['Content-Type'] = undefined;
});

app.config(function ($interpolateProvider) {
    $interpolateProvider
        .startSymbol('[[')
        .endSymbol(']]');
});

app.config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
    //cfpLoadingBarProvider.includeBar = false;
}]);

app.run(function (amMoment) {
    amMoment.changeLocale('id');
});

app.run(function ($rootScope) {
    $rootScope.searchFilter   = {};
    $rootScope.sorting        = "nama";
    $rootScope.sortingReverse = false;
    $rootScope.sortData       = function (value) {
        if ($rootScope.sorting == value) {
            $rootScope.sortingReverse = !$rootScope.sortingReverse;
        } else {
            $rootScope.sorting        = value;
            $rootScope.sortingReverse = false;
        }
    };
    $rootScope.datetime_conf  = 'DD MMM YYYY HH:mm:ss';
    $rootScope.date_conf      = 'DD MMM YYYY';
    if (typeof admin !== 'undefined') {
        $rootScope.admin = admin;
    }
    $rootScope.base_url           = base_url;
    $rootScope.current_url        = current_url;
    $rootScope.default_password   = default_password;
    $rootScope.format_datepicker  = 'yyyy-MM-dd';
    $rootScope.cgConf             = {
        promise: null
    };
    $rootScope.editorOptions      = {
        language: 'en',
        'skin': 'moono',
        extraPlugins: 'imageuploader',
        toolbarLocation: 'top',
        toolbar: 'full',
        toolbar_full: [
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike', 'Underline']
            },
            {name: 'paragraph', items: ['BulletedList', 'NumberedList', 'Blockquote']},
            {name: 'editing', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'tools', items: ['SpellChecker', 'Maximize']},
            {name: 'clipboard', items: ['Undo', 'Redo']},
            {name: 'styles', items: ['Format', 'FontSize', 'TextColor', 'PasteText', 'PasteFromWord', 'RemoveFormat']},
            {name: 'insert', items: ['Image', 'Table', 'SpecialChar', 'MediaEmbed']}, '/'
        ]
    };
    $rootScope.smallEditorOptions = {
        language: 'en',
        'skin': 'moono',
        extraPlugins: 'imageuploader',
        toolbarLocation: 'top',
        toolbar: 'full',
        height: '100px',
        toolbar_full: [
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike', 'Underline']
            },
            {name: 'paragraph', items: ['BulletedList', 'NumberedList', 'Blockquote']},
            {name: 'editing', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'tools', items: ['SpellChecker', 'Maximize']},
            {name: 'clipboard', items: ['Undo', 'Redo']},
            {name: 'styles', items: ['Format', 'FontSize', 'TextColor', 'PasteText', 'PasteFromWord', 'RemoveFormat']},
            {name: 'insert', items: ['Image', 'Table', 'SpecialChar', 'MediaEmbed']}, '/'
        ]
    };
});

app.value('cgBusyDefaults', {
    message: 'Loading Stuff',
    backdrop: true,
    templateUrl: base_url + 'angApp/angular-busy.html',
    delay: 0,
    minDuration: 0
});

app.factory('Modal', function Modal($modal) {
    return {
        createNewModal: function createNewModal(url, controller, size, resolve) {
            return $modal.open({
                templateUrl: url,
                animation: false,
                controller: controller,
                size: size,
                backdrop: 'static',
                keyboard: false,
                resolve: resolve
            });
        }
    };
});

app.directive('inputField', function () {
    return {
        restrict: 'EA',
        templateUrl: base_url + 'angApp/input.html',
        replace: true,
        scope: {
            record: '=',
            field: '@',
            required: '@'
        },
        link: function (scope, element, attr) {
        }
    };
});

app.directive('fileUploadChange', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var onChangeHandler = scope.$eval(attrs.fileUploadChange);
            element.bind('change', onChangeHandler);
        }
    };
});

app.directive('ngThumb', ['$window', function ($window) {
    var helper = {
        support: !!($window.FileReader && $window.CanvasRenderingContext2D),
        isFile: function (item) {
            return angular.isObject(item) && item instanceof $window.File;
        },
        isImage: function (file) {
            var type = '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
            return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
        }
    };

    return {
        restrict: 'A',
        template: '<canvas/>',
        link: function (scope, element, attributes) {
            if (!helper.support) return;

            var params = scope.$eval(attributes.ngThumb);

            if (!helper.isFile(params.file)) return;
            if (!helper.isImage(params.file)) return;

            var canvas = element.find('canvas');
            var reader = new FileReader();

            canvas.attr({width: 10, height: 10});

            reader.onload = onLoadFile;
            reader.readAsDataURL(params.file);

            function onLoadFile(event) {
                var img    = new Image();
                img.onload = onLoadImage;
                img.src    = event.target.result;
            }

            function onLoadImage() {
                var width  = params.width || this.width / this.height * params.height;
                var height = params.height || this.height / this.width * params.width;

                canvas.attr({width: width, height: height});
                canvas.addClass("img-responsive");
                canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
            }
        }
    };
}]);

app.filter('to_trusted', ['$sce', function ($sce) {
    return function (text) {
        return $sce.trustAsHtml(text);
    };
}]);

app.filter('string_to_date', function () {
    return function (input) {
        return moment(input);
    };
});

app.filter('string_to_number_formatted', function () {
    return function (input) {
        input = input.toString().replace(/([\.])/g, ",");
        return input.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    };
});

app.filter('string_to_number_formatted_english', function () {
    return function (input) {
        input = input.toString().replace(/([\.])/g, ".");
        return input.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    };
});

app.filter('youtube_embed_url', function () {
    return function (videoId) {
        return $sce.trustAsResourceUrl('https://www.youtube.com/embed/' + videoId + '?rel=0&autoplay=0&controls=0&showinfo=0&disablekb=1&loop=1&modestbranding=1');
    };
});

app.filter('labelCase', function ($resource) {
    return function (input) {
        input = input.replace(/([A-Z])/g, ' $1');
        return input[0].toUpperCase() + input.slice(1);
    };
});
