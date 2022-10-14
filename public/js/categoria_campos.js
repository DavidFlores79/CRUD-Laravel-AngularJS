var app = angular.module('categoria_campos', []);


app.controller('categoria_campos', function ($scope, $http) {
    $scope.categoria_campo = {};
    $scope.categoria_campos = [];
    $scope.createForm = {};
    
    $http({
        url: 'categoria_campos',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            $scope.categoria_campos = response.data.categoria_campos;
            console.log($scope.categoria_campos);
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
            url: 'categoria_campos/create',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#createForm').trigger('reset');
                $('#agregarCategoriaCampoModal').modal('show');
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
            url: 'categoria_campos',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: $scope.createForm
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.categoria_campos = [...$scope.categoria_campos, response.data.categoria_campo];
                $('#createForm').trigger('reset');
                $('#agregarCategoriaCampoModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                //$('#agregarCategoriaCampoModal').modal('hide');
                
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

    $scope.edit = function (categoria_campo) {
        console.log('cat: ', categoria_campo);
        $('#edit-nombre').val(categoria_campo.nombre);
        $('#edit-id').val(categoria_campo.id);
        
        $http({
            url: 'categoria_campos/edit',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#editarCategoriaCampoModal').modal('show');
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
        let categoria_campo_editado = {
            id: $('#edit-id').val(),
            nombre: $('#edit-nombre').val(),
        };

        $http({
            url: `categoria_campos`,
            method: 'PUT',
            data: categoria_campo_editado,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log('response: ', response);
                $scope.categoria_campo = response.data.categoria_campo;
                $scope.categoria_campos = $scope.categoria_campos.map(categoria_campo => (categoria_campo.id == response.data.categoria_campo.id) ? categoria_campo = response.data.categoria_campo : categoria_campo);
                $('#editarCategoriaCampoModal').modal('hide');
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

    $scope.confirmarEliminar = function (categoria_campo) {
        $scope.categoria_campo = categoria_campo;
        $('#nombre-categoria_campo').html(categoria_campo.nombre);
        $('#eliminarCategoriaCampoModal').modal('show');
    }

    $scope.delete = function () {
        console.log('categoria_campo: ', $scope.categoria_campo);

        $http({
            url: `categoria_campos/${$scope.categoria_campo.id}`,
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.categoria_campos = $scope.categoria_campos.filter(categoria_campo => categoria_campo.id !== $scope.categoria_campo.id);
                $('#eliminarCategoriaCampoModal').modal('hide');
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