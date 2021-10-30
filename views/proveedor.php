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
                            <h1 class="box-title">Proveedor <button class="btn btn-success" id="btnAgregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>N° Documento</th>
                                <th>Telefono</th>
                                <th>Email</th>
                            </tfoot>
                            </table>
                        </div>

                        <div class="panel-body" style="height: 400px;" id="formularioregistros">
                            <form name="formulario" id="formulario" method="POST">
                            
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre</label>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="tipo_persona" id="tipo_persona" value="Proveedor">
                                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="99" placeholder="Nombre del Proveedor" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Tipo Documento</label>
                                    <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                                        <option value="DNI">DNI</option>
                                        <option value="RUC">RUC</option>
                                        <option value="CEDULA">CEDULA</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Numero Documento</label>
                                    <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="19" placeholder="N° Documento" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Direccion</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" maxlength="69" placeholder=Direccion">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" maxlength="29" placeholder=Telefono">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email" maxlength="99" placeholder=Email">
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

    <script type="text/javascript" src="scripts/proveedor.js"></script>
