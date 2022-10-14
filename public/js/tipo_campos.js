var app = angular.module('tipo_campos', []);


app.controller('tipo_campos', function ($scope, $http) {
    $scope.tipo_campo = {};
    $scope.tipo_campos = [];
    $scope.createForm = {};
    
    $http({
        url: 'tipo_campos',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            $scope.tipo_campos = response.data.tipo_campos;
            console.log($scope.tipo_campos);
        },
        function errorCallback(response) {
            console.log(response);
            swal(
                configuraciones.titulo,
                response.data.message,
                tiposDeMensaje.error
            );
        }
    );

    $scope.create = function () {

        $http({
            url: 'tipo_campos/create',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#createForm').trigger('reset');
                $('#agregarTipoCampoModal').modal('show');
            },
            function errorCallback(response) {
                console.log(response);
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            }
        );
    }

    $scope.store = function () {

        $http({
            url: 'tipo_campos',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: $scope.createForm
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.tipo_campos = [...$scope.tipo_campos, response.data.tipo_campo];
                $('#createForm').trigger('reset');
                $('#agregarTipoCampoModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                //$('#agregarTipoCampoModal').modal('hide');
                
                if (response.status === 422) {
                    let mensaje = '';
                    for (let i in response.data.errors) {
                        mensaje += response.data.errors[i] + '\n';
                    }
                    swal('Mensaje del Sistema', mensaje, 'error');
                } else {
                    swal(
                        'Mensaje del Sistema',
                        response.data.message,
                        response.data.status
                    );
                }
                
            }
        );
    }

    $scope.edit = function (tipo_campo) {
        console.log('cat: ', tipo_campo);
        $('#edit-nombre').val(tipo_campo.nombre);
        $('#edit-id').val(tipo_campo.id);
        
        $http({
            url: 'tipo_campos/edit',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#editarTipoCampoModal').modal('show');
            },
            function errorCallback(response) {
                console.log(response);
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            }
        );
    }

    $scope.update = function () {
        let tipo_campo_editado = {
            id: $('#edit-id').val(),
            nombre: $('#edit-nombre').val(),
        };

        $http({
            url: `tipo_campos`,
            method: 'PUT',
            data: tipo_campo_editado,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log('response: ', response);
                $scope.tipo_campo = response.data.tipo_campo;
                $scope.tipo_campos = $scope.tipo_campos.map(tipo_campo => (tipo_campo.id == response.data.tipo_campo.id) ? tipo_campo = response.data.tipo_campo : tipo_campo);
                $('#editarTipoCampoModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            }
        );
    }

    $scope.confirmarEliminar = function (tipo_campo) {
        $scope.tipo_campo = tipo_campo;
        $('#nombre-tipo_campo').html(tipo_campo.nombre);
        $('#eliminarTipoCampoModal').modal('show');
    }

    $scope.delete = function () {
        console.log('tipo_campo: ', $scope.tipo_campo);

        $http({
            url: `tipo_campos/${$scope.tipo_campo.id}`,
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.tipo_campos = $scope.tipo_campos.filter(tipo_campo => tipo_campo.id !== $scope.tipo_campo.id);
                $('#eliminarTipoCampoModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            }
        );
        
    }

    $('#editarUsuarioModal').on('hidden.bs.modal', function () {
        console.log('haz algo');
    });
    


});