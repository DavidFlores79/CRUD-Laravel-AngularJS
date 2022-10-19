var app = angular.module('campos_formularios', []);


app.controller('campos_formularios', function ($scope, $http) {
    $scope.campos_formulario = {};
    $scope.campos_formularios = [];
    $scope.formularios = [];
    $scope.tipos_campo = [];
    $scope.createForm = {};
    $scope.editForm = {};
    
    $http({
        url: 'campos_formularios',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            //console.log(response);
            $scope.campos_formularios = response.data.campos_formularios;
            $scope.formularios = response.data.formularios;
            $scope.tipos_campo = response.data.tipos_campo;
            //console.log($scope.campos_formularios);
        },
        function errorCallback(response) {
            //console.log(response);
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
        console.log('campos_formulario: ', campos_formulario);
        $scope.editForm = campos_formulario;
        console.log('editForm: ', $scope.editForm);
        $scope.pedirCamposTabla($scope.editForm.tipo_formulario.id);
        
        $http({
            url: 'campos_formularios/edit',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                //console.log(response);
                $('#editarModal').modal('show');
            },
            function errorCallback(response) {
                //console.log(response);
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            }
        );
    }

    $scope.update = function () {
        $scope.editForm.requerido = $('#edit-requerido').prop('checked');
        $scope.editForm.sololectura = $('#edit-sololectura').prop('checked');

        $http({
            url: `campos_formularios`,
            method: 'PUT',
            data: $scope.editForm,
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

    $('#editarModal').on('hidden.bs.modal', function () {
        console.log('haz algo');
    });

    $scope.camposTabla = function () {
        if(!$scope.createForm.formulario) {
            $scope.nombre_campos = {};
            console.log('vacio create');
        } else {
            $scope.pedirCamposTabla($scope.createForm.formulario);
        }
        if(!$scope.editForm.tipo_formulario_id) {
            $scope.nombre_campos = {};
            console.log('vacio edit');
        } else {
            $scope.pedirCamposTabla($scope.editForm.tipo_formulario_id);
        }
    }

    $scope.pedirCamposTabla = function (id) {
        $http({
            url: 'get-campos-tabla',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: {
                'id': id
            }
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.nombre_campos = response.data;
            },
            function errorCallback(response) {
                console.log(response);
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    tiposDeMensaje.error
                );
            }
        );
    }
    


});