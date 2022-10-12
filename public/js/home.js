var app = angular.module('home', []);


app.controller('home', function ($scope, $http) {
    $scope.usuario = {};
    $scope.usuarios = [];
    $scope.createForm = {};
    
    $http({
        url: 'usuarios',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            $scope.usuarios = response.data.users;
            console.log($scope.usuarios);
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
            url: 'usuarios/create',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#createForm').trigger('reset');
                $('#agregarUsuarioModal').modal('show');
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
            url: 'usuarios',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: $scope.createForm
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.usuarios = [...$scope.usuarios, response.data.user];
                $('#createForm').trigger('reset');
                $('#agregarUsuarioModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                //$('#agregarUsuarioModal').modal('hide');
                
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

    $scope.edit = function (usuario) {
        $('#edit-name').val(usuario.name);
        $('#edit-email').val(usuario.email);
        $('#edit-id').val(usuario.id);
        
        $http({
            url: 'usuarios/edit',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#editarUsuarioModal').modal('show');
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
        let usuario_editado = {
            id: $('#edit-id').val(),
            name: $('#edit-name').val(),
            email: $('#edit-email').val()
        };

        $http({
            url: `usuarios`,
            method: 'PUT',
            data: usuario_editado,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log('response: ', response);
                $scope.usuario = response.data.user;
                $scope.usuarios = $scope.usuarios.map(usuario => (usuario.id == response.data.user.id) ? usuario = response.data.user : usuario);
                $('#editarUsuarioModal').modal('hide');
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

    $scope.confirmarEliminar = function (usuario) {
        $scope.usuario = usuario;
        $('#nombre-usuario').html(usuario.name);
        $('#eliminarUsuarioModal').modal('show');
    }

    $scope.delete = function () {
        console.log('usuario: ', $scope.usuario);

        $http({
            url: `usuarios/${$scope.usuario.id}`,
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.usuarios = $scope.usuarios.filter(usuario => usuario.id !== $scope.usuario.id);
                $('#eliminarUsuarioModal').modal('hide');
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