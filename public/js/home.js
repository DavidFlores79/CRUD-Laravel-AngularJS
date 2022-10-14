var app = angular.module('home', []);


app.controller('home', function ($scope, $http) {
    $scope.formulario_crear = [];
    $scope.formulario_editar = [];
    $scope.usuario = {};
    $scope.usuarios = [];
    $scope.createForm = {};
    $scope.name = '';
    
    $http({
        url: 'get-usuarios',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log('index', response);
            $scope.usuarios = response.data.users;
            console.log($scope.usuarios);
        },
        function errorCallback(response) {
            console.log(response);
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

    $scope.create = function () {

        $http({
            url: 'usuarios/create',
            method: 'POST',
            data: {
                formulario_crear: 'usuarios_crear'
            },
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.formulario_crear = response.data.formulario_crear;
                $('#agregarModal').modal('show');
                $('#createForm').trigger('reset');
            },
            function errorCallback(response) {
                console.log(response);
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

    $scope.store = function () {
        // console.log('name:', $scope.createForm);
        // return;
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
                $scope.createForm = {};
                $('#createForm').trigger('reset');
                $('#agregarModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                //$('#agregarModal').modal('hide');
                
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
        $scope.editForm = {};
        if(usuario.name) $scope.editForm['name'] = usuario.name;
        if(usuario.email) $scope.editForm['email'] = usuario.email;
        if(usuario.id) $scope.editForm['id'] = usuario.id;
        if(usuario.direccion) $scope.editForm['direccion'] = usuario.direccion;
        if(usuario.edad) $scope.editForm['edad'] = usuario.edad;

        $http({
            url: 'usuarios/edit',
            method: 'POST',
            data: {
                formulario_editar: 'usuarios_editar'
            },
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.formulario_editar = response.data.formulario_editar;
                $('#editarModal').modal('show');
            },
            function errorCallback(response) {
                console.log(response);
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

    $scope.update = function () {

        $http({
            url: `usuarios`,
            method: 'PUT',
            data: $scope.editForm,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log('response: ', response);
                $scope.usuario = response.data.user;
                $scope.usuarios = $scope.usuarios.map(usuario => (usuario.id == response.data.user.id) ? usuario = response.data.user : usuario);
                $('#editarModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
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

    $('#editarModal').on('hidden.bs.modal', function () {
        console.log('haz algo');
    });
    


});