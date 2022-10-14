@extends('layouts.main')

@section('page-title', 'Crear Formularios')
@section('ngApp', 'campos_formularios')
@section('ngController', 'campos_formularios')

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
                                    <th scope="col">Formulario</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Campo</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="campos_formulario in campos_formularios track by $index">
                                    <th scope="row">@{{ campos_formulario.id }}</th>
                                    <td>@{{ campos_formulario.categoria.nombre }}</td>
                                    <td>@{{ campos_formulario.tipo_campo.nombre }}</td>
                                    <td>@{{ campos_formulario.nombre }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(campos_formulario)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(campos_formulario)"><i class="fas fa-trash"></i></button>
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


<!-- Modal Crear campos_formulario -->
<div class="modal fade" id="agregarCamposFormulariosModal" tabindex="-1" aria-labelledby="agregarCamposFormulariosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarCamposFormulariosModalLabel">Crear campos_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group">
                        <label for="formulario">Formulario:</label>
                        <select class="form-control" id="formulario" name="formulario" ng-model="createForm.formulario" required>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="formulario in formularios" value="@{{ formulario.id }}">
                                @{{ formulario.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" ng-model="createForm.nombre" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="etiqueta">Etiqueta (label):</label>
                        <input type="text" name="etiqueta" id="etiqueta" class="form-control" placeholder="Etiqueta" ng-model="createForm.etiqueta" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="tipo_campo">Tipos de Campo:</label>
                        <select class="form-control" id="tipo_campo" name="tipo_campo" ng-model="createForm.tipo_campo" required>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="tipo_campo in tipos_campo" value="@{{ tipo_campo.id }}">
                                @{{ tipo_campo.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="requerido" name="requerido" ng-model="createForm.requerido">
                        <input type="hidden" id="input-requerido">
                        <label class="custom-control-label" for="requerido">
                            Requerido
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar campos_formulario -->
<div class="modal fade" id="editarCamposFormulariosModal" tabindex="-1" aria-labelledby="editarCamposFormulariosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarCamposFormulariosModalLabel">Editar Campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-categoria_id">Formulario:</label>
                        <select class="form-control" id="edit-categoria_id" name="edit-categoria_id" ng-model="editForm.formulario" required>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="formulario in formularios" value="@{{ formulario.id }}">
                                @{{ formulario.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="edit-tipo_campo_id">Tipos de Campo:</label>
                        <select class="form-control" id="edit-tipo_campo_id" name="edit-tipo_campo_id" ng-model="editForm.tipo_campo_id" required>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="tipo_campo in tipos_campo" value="@{{ tipo_campo.id }}">
                                @{{ tipo_campo.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar campos_formulario-->
<div class="modal fade" id="eliminarCamposFormulariosModal" tabindex="-1" aria-labelledby="eliminarCamposFormulariosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarCamposFormulariosModalLabel">Crear campos_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar el campo <span class="font-weight-bold" id="nombre-campos_formulario"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(campos_formulario)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/campos_formularios.js') }}"></script>

@endsection