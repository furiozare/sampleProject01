app.controller('CreateDealerModalController', function ($scope, $http, $modalInstance, Dealer, kotas) {
    $scope.title   = "Membuat Dealer baru";
    $scope.status  = 'create';
    $scope.success = false;
    $scope.errors  = [];
    $scope.dealer  = {};
    $scope.kotas   = kotas;

    $scope.CRUD = angular.copy($scope.cgConf);

    $scope.status = {
        tanggal_mulai: {
            opened: false
        },
        tanggal_akhir: {
            opened: false
        }
    };

    $scope.open = function (name) {
        $scope.status[name].opened = true;
    };

    $scope.data = function () {
        var data     = $('#DealerForm').serializeArray();
        var formData = new FormData();

        formData.append('_method', 'POST');

        for (i = 0; i < data.length; i++) {
            formData.append(data[i].name, data[i].value);
        }

        return formData;
    };

    $scope.save = function () {
        $scope.CRUD.promise = Dealer.createDealer($scope.data())
            .success(function (response) {
                if (response.result == 'success') {
                    $scope.success = true;
                    $modalInstance.close(response.dealer);
                }
                if (typeof response.errors !== 'undefined') {
                    $scope.errors = response.errors;
                }
            });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
