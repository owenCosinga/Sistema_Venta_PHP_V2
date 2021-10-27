create database dblicor;


create table categoria(
    id int primary key auto_increment not null
    nombre varchar(100) not null,
    descripcion varchar(200),
    estado tinyint(1) not null default 1
);

create table usuario(
    id int primary key AUTO_INCREMENT not null,
    nombre varchar(100) not null,
    apellido varchar(200) not null,
    tipo_documento varchar(50) not null,
    num_documento varchar(50) not null,
    telefono varchar(50),
    email varchar(200),
    cargo varchar(50),
    login varchar(100),
    clave varchar(100),
    imagen varchar(250),
    estado tinyint(1) not null default 1
);

create table articulo(
    idarticulo int primary key AUTO_INCREMENT not null,
    idcategoria int not null,
    codigo varchar(50),
    nombre varchar(100) not null,
    stock int not null,
    descripcion varchar(250),
    imagen varchar(250),
    estado tinyint(1) not null default 1,
    FOREIGN KEY (idcategoria) REFERENCES categoria(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table permiso(
    id int primary key auto_increment not null,
    nombre varchar(30) not null
);

insert into permiso(nombre) values('Escritorio');
insert into permiso(nombre) values('Almacen');
insert into permiso(nombre) values('Compras');
insert into permiso(nombre) values('Ventas');
insert into permiso(nombre) values('Acceso');
insert into permiso(nombre) values('Consulta Compras');
insert into permiso(nombre) values('Consulta Ventas');


create table persona(
    id int primary key auto_increment not null,
    tipo_persona varchar(20) not null,
    nombre varchar(100) not null,
    tipo_documento varchar(20) not null,
    num_documento varchar(20) not null,
    direccion varchar(70) null,
    telefono varchar(30) null,
    email varchar(100) null
);

create table venta(
    id int primary key auto_increment not null,
    idcliente int not null,
    idusuario int not null,
    tipo_comprobante varchar(20) not null,
    serie_comprobante varchar(7),
    num_comprobante varchar(20) not null,
    fecha_hora datetime not null,
    impuesto decimal(4.2) not null,
    total_venta decimal(11,2) not null,
    estado varchar(20) not null,

    FOREIGN KEY (idcliente) REFERENCES persona(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idusuario) REFERENCES usuario(id) ON UPDATE CASCADE ON DELETE CASCADE

);

create table usuario_permiso(
    id int primary key auto_increment not null,
    idusuario int not null,
    idpermiso int not null,

    FOREIGN KEY (idusuario) REFERENCES usuario(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idpermiso) REFERENCES permiso(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table ingreso(
    id int primary key auto_increment not null,
    idproveedor int not null,
    idusuario int not null,
    tipo_comprobante varchar(20) not null,
    serie_comprobante varchar(7),
    num_comprobante varchar(10) not null,
    fecha_hora datetime not null,
    impuesto decimal(4,2) not null,
    total_compra decimal(11,2) not null,
    estado varchar(20) not null,

    FOREIGN KEY (idproveedor) REFERENCES persona(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idusuario) REFERENCES usuario(id) ON UPDATE CASCADE ON DELETE CASCADE    
);

create table detalle_venta(
    id int primary key auto_increment not null,
    idventa int not null,
    idarticulo int not null,
    cantidad int not null,
    precio_venta decimal(11,2) not null,
    descuento decimal(11,2) not null,

    FOREIGN KEY (idventa) REFERENCES venta(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idarticulo) REFERENCES articulo(id) ON UPDATE CASCADE ON DELETE CASCADE       
);

create table detalle_ingreso(
    id int primary key auto_increment not null,
    idingreso int not null,
    idarticulo int not null,
    cantidad int not null,
    precio_compra decimal(11,2) not null,
    precio_venta decimal(11,2) not null,
    FOREIGN KEY (idingreso) REFERENCES ingreso(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idarticulo) REFERENCES articulo(id) ON UPDATE CASCADE ON DELETE CASCADE   
    
);


