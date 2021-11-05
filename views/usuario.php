<?php require 'header.php'; ?>
<!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            
            <!-- Main content -->
            <section class="content">
                <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h1 class="box-title">Usuario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- centro -->
                        <div class="panel-body table-responsive" id="listadoregistros">
                            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>N° Documento</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                            </thead>
                            <tbody></tbody>
                            <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>N° Documento</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                            </tfoot>
                            </table>
                        </div>

                        <div class="panel-body" id="formularioregistros">
                            <form name="formulario" id="formulario" method="POST">
                            
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Nombre(*)</label>
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="90" placeholder="Nombre" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Apellido(*)</label>
                                <input type="text" class="form-control" name="apellido" id="apellido" maxlength="100" placeholder="Apellido" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo Documento(*)</label>
                                <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CEDULA</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Numero Documento(*)</label>
                                <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="50" placeholder="N° Documento" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Telefono</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="50" placeholder="Telefono">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" id="email" maxlength="100" placeholder="Email">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Cargo</label>
                                <input type="text" class="form-control" name="cargo" id="cargo" maxlength="50" placeholder="Cargo">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Login</label>
                                <input type="text" class="form-control" name="login" id="login" maxlength="90" placeholder="Login" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Clave</label>
                                <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Clave" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Permisos:</label>
                            <ul style="list-style:none;" id="permisos">
                                
                            </ul>
                            </div>
                            
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Imagen</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
                                <img src="" width="150px" height="120px" id="imagenmuestra">
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i>Cancelar</button>
                            </div>

                        </form>
                    </div>
                    <!--Fin centro -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

    <?php require 'footer.php'; ?>
    <script type="text/javascript" src="scripts/usuario.js"></script>
