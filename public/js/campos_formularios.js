var app = angular.module('campos_formularios', []);


app.controller('campos_formularios', function ($scope, $http) {
    $scope.campos_formulario = {};
    $scope.campos_formularios = [];
    $scope.formularios = [];
    $scope.tipos_campo = [];
    $scope.createForm = {};
    
    $http({
        url: 'campos_formularios',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            $scope.campos_formularios = response.data.campos_formularios;
            $scope.formularios = response.data.formularios;
            $scope.tipos_campo = response.data.tipos_campo;
            console.log($scope.campos_formularios);
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
            url: 'campos_formularios/create',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);    
                $('#createForm').trigger('reset');
                $('#agregarModal').modal('show');
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
            url: 'campos_formularios',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: $scope.createForm
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.campos_formularios = [...$scope.campos_formularios, response.data.campos_formulario];
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

    $scope.edit = function (campos_formulario) {
        console.log('cat: ', campos_formulario);
        $('#edit-nombre').val(campos_formulario.nombre);
        $('#edit-etiqueta').val(campos_formulario.etiqueta);
        $('#edit-id').val(campos_formulario.id);
        $('#edit-tipo_formulario_id').val(campos_formulario.tipo_formulario.id);
        $('#edit-tipo_campo').val(campos_formulario.tipo_campo.nombre);
        $('#edit-etiqueta').val(campos_formulario.etiqueta);
        $('#edit-requerido').prop('checked', campos_formulario.requerido);
        $('#edit-sololectura').prop('checked', campos_formulario.sololectura);
        
        $http({
            url: 'campos_formularios/edit',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#editarModal').modal('show');
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
        let campos_formulario_editado = {
            id: $('#edit-id').val(),
            nombre: $('#edit-nombre').val(),
            etiqueta: $('#edit-etiqueta').val(),
            tipo_formulario_id: $('#edit-tipo_formulario_id').val(),
            tipo_campo: $('#edit-tipo_campo').val(),
            requerido: $('#edit-requerido').prop('checked'),
            sololectura: $('#edit-sololectura').prop('checked'),
        };

        $http({
            url: `campos_formularios`,
            method: 'PUT',
            data: campos_formulario_editado,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log('response: ', response);
                $scope.campos_formulario = response.data.campos_formulario;
                $scope.campos_formularios = $scope.campos_formularios.map(campos_formulario => (campos_formulario.id == response.data.campos_formulario.id) ? campos_formulario = response.data.campos_formulario : campos_formulario);
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

    $scope.confirmarEliminar = function (campos_formulario) {
        $scope.campos_formulario = campos_formulario;
        $('#nombre-campos_formulario').html(campos_formulario.nombre);
        $('#eliminarModal').modal('show');
    }

    $scope.delete = function () {
        console.log('campos_formulario: ', $scope.campos_formulario);

        $http({
            url: `campos_formularios/${$scope.campos_formulario.id}`,
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.campos_formularios = $scope.campos_formularios.filter(campos_formulario => campos_formulario.id !== $scope.campos_formulario.id);
                $('#eliminarModal').modal('hide');
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