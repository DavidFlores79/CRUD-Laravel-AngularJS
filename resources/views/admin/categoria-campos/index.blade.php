@extends('layouts.main')

@section('page-title', 'Tipos de Formularios')
@section('ngApp', 'categoria_campos')
@section('ngController', 'categoria_campos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @yield('page-title')
                    <button class="btn btn-sm btn-success float-right" ng-click="create()"><i class="fas fa-plus-square"></i></button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tabla</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="categoria_campo in categoria_campos track by $index">
                                    <td>@{{ categoria_campo.id }}</td>
                                    <td>@{{ categoria_campo.nombre }}</td>
                                    <td>@{{ categoria_campo.tabla }}</td>
                                    <td>@{{ categoria_campo.created_at | date }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(categoria_campo)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(categoria_campo)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Crear categoria_campo -->
<div class="modal fade" id="agregarCategoriaCampoModal" tabindex="-1" aria-labelledby="agregarCategoriaCampoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarCategoriaCampoModalLabel">Crear categoria_campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group">
                        <label for="nombre">Formulario:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del Formulario" ng-model="createForm.nombre" required autofocus>
                    </div>
                    <!-- <div class="form-group">
                        <label for="tabla">Tabla de BD:</label>
                        <input type="text" name="tabla" id="tabla" class="form-control" placeholder="Tabla de la BD" ng-model="createForm.tabla" required autofocus>
                    </div> -->
                    <select class="form-control" id="edit-categoria_id" name="edit-categoria_id" ng-model="createForm.tabla">
                        <option value="">Elige una opcion...</option>
                        <option ng-repeat="tabla in tablas" value="@{{ tabla }}">
                            @{{ tabla }}</option>
                    </select>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar categoria_campo -->
<div class="modal fade" id="editarCategoriaCampoModal" tabindex="-1" aria-labelledby="editarCategoriaCampoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarCategoriaCampoModalLabel">Editar categoria_campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()" class="was-validated">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar categoria_campo-->
<div class="modal fade" id="eliminarCategoriaCampoModal" tabindex="-1" aria-labelledby="eliminarCategoriaCampoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarCategoriaCampoModalLabel">Crear categoria_campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar al categoria_campo <span class="font-weight-bold" id="nombre-categoria_campo"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(categoria_campo)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/categoria_campos.js') }}"></script>

@endsection