-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2026 a las 20:22:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comsitec_db_business`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_clientes`
--

CREATE TABLE `tb_clientes` (
  `ccodcli` varchar(11) NOT NULL COMMENT 'Código del cliente',
  `crazon` varchar(150) NOT NULL COMMENT 'Nombre / Razón social',
  `cnombre1` varchar(80) DEFAULT NULL,
  `cnombre2` varchar(80) DEFAULT NULL,
  `cpaterno` varchar(80) DEFAULT NULL,
  `cmaterno` varchar(80) DEFAULT NULL,
  `cdireccion` varchar(200) DEFAULT NULL,
  `ctelefono1` varchar(20) DEFAULT NULL,
  `ctelefono2` varchar(20) DEFAULT NULL,
  `ccorreo` varchar(120) DEFAULT NULL,
  `cdocumento` varchar(20) DEFAULT NULL,
  `ctipodoc` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `tb_efcecy_task` (
  `ucoduser` varchar(11) NOT NULL COMMENT 'Código de usuario',
  `efcecy` int(11) NOT NULL COMMENT 'Eficiencia',
  `dtergter` date NOT NULL COMMENT 'Fecha de registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de tabla para la tabla `tb_gtor_tras`
--

CREATE TABLE `tb_gtor_tras` (
  `nmroid` int(11) NOT NULL,
  `cadorid` varchar(11) NOT NULL COMMENT 'Creador identificador',
  `rpsbleid` varchar(11) NOT NULL COMMENT 'Responsable identificador',
  `ttlo` varchar(800) NOT NULL COMMENT 'Título de la tarea',
  `dccon` varchar(5000) NOT NULL COMMENT 'Descripción',
  `fchareg` datetime NOT NULL COMMENT 'Fecha de registro',
  `fchalmte` datetime NOT NULL COMMENT 'Fecha límite',
  `etdofchalmte` varchar(50) NOT NULL COMMENT 'Estado de la fecha límite',
  `etdo` varchar(50) NOT NULL COMMENT 'Estado',
  `nvel` varchar(50) NOT NULL COMMENT 'Nivel de urgencia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de tabla para la tabla `tb_idctorefcecytask`
--

CREATE TABLE `tb_idctorefcecytask` (
  `id` int(11) NOT NULL,
  `ucoduser` int(11) NOT NULL,
  `dtergter` datetime NOT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `efcecy` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de tabla para la tabla `tb_lnatepo_tras`
--

CREATE TABLE `tb_lnatepo_tras` (
  `id` int(11) NOT NULL,
  `nmroid` int(11) NOT NULL,
  `ucoduser` varchar(20) NOT NULL,
  `ttlo` varchar(150) NOT NULL,
  `dccon` text NOT NULL,
  `fchareg` datetime NOT NULL DEFAULT current_timestamp(),
  `dttip` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'OK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `tb_pdtos_assor`
--

CREATE TABLE `tb_pdtos_assor` (
  `codigo` varchar(12) DEFAULT NULL,
  `categoria` varchar(150) DEFAULT NULL,
  `subcategoria` varchar(150) DEFAULT NULL,
  `marca` varchar(150) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `fechaingreso` date DEFAULT NULL,
  `preciocosto` decimal(10,2) DEFAULT NULL,
  `diasstock` varchar(10) DEFAULT NULL,
  `ingresos` varchar(10) DEFAULT NULL,
  `salidas` varchar(10) DEFAULT NULL,
  `stock` varchar(10) DEFAULT NULL,
  `precio1` decimal(10,2) DEFAULT NULL,
  `precio2` decimal(10,2) DEFAULT NULL,
  `precio3` decimal(10,2) DEFAULT NULL,
  `precio4` decimal(10,2) DEFAULT NULL,
  `precio5` decimal(10,2) DEFAULT NULL,
  `reposicion` varchar(20) DEFAULT NULL,
  `stocksugerido` varchar(10) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `parte` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_prod`
--

CREATE TABLE `tb_prod` (
  `codigo` varchar(50) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `subcategoria` varchar(100) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `fechareg` date DEFAULT NULL,
  `preciocosto` decimal(10,2) DEFAULT NULL,
  `price_cost_d` decimal(10,2) DEFAULT NULL,
  `diasstock` int(5) DEFAULT NULL,
  `ingresos` varchar(50) DEFAULT NULL,
  `salidas` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 0,
  `precio` decimal(10,2) DEFAULT NULL,
  `precio2` decimal(10,2) DEFAULT NULL,
  `precio3` decimal(10,2) DEFAULT NULL,
  `precio4` decimal(10,2) DEFAULT NULL,
  `precio5` decimal(10,2) DEFAULT NULL,
  `precio6` decimal(10,2) DEFAULT NULL,
  `precio7` decimal(10,2) DEFAULT NULL,
  `reposicion` decimal(10,2) DEFAULT NULL,
  `stocksugerido` int(11) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `parte` varchar(100) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_prod`
--

INSERT INTO `tb_prod` (`codigo`, `categoria`, `subcategoria`, `marca`, `descripcion`, `fechareg`, `preciocosto`, `price_cost_d`, `diasstock`, `ingresos`, `salidas`, `cantidad`, `precio`, `precio2`, `precio3`, `precio4`, `precio5`, `precio6`, `precio7`, `reposicion`, `stocksugerido`, `observaciones`, `parte`, `status`) VALUES
('150010000111', 'Laptops', 'Oficina', 'HP', 'HP 15-fd0008la i5 12va 8GB 512GB SSD', '2025-12-30', 1800.00, NULL, NULL, NULL, NULL, 5, 2300.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('150010000112', 'Laptops', 'Negocios', 'Lenovo', 'Lenovo V15 i5 11va 8GB 512GB SSD', '2025-12-30', 1750.00, NULL, NULL, NULL, NULL, 4, 2250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('200030000111', 'Monitores', 'LED', 'Samsung', 'Monitor Samsung 24” FHD', '2025-12-30', 380.00, NULL, NULL, NULL, NULL, 10, 520.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300020000111', 'Impresoras', 'Tanque', 'Epson', 'Epson L3250 EcoTank Wi-Fi', '2025-12-30', 650.00, NULL, NULL, NULL, NULL, 6, 820.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_pvlges`
--

CREATE TABLE `tb_pvlges` (
  `gup` varchar(20) NOT NULL,
  `tpe` varchar(20) NOT NULL,
  `ucoduser` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tb_pvlges`
--

INSERT INTO `tb_pvlges` (`gup`, `tpe`, `ucoduser`) VALUES
('gestorintegral', 'register', '0311'),
('gestorintegral', 'tasks', '0311'),
('gestorintegral', 'userprivileges', '0311'),
('gestorintegral', 'signaturemail', '0311'),
('gestorintegral', 'warranty', '0311'),
('backofficeweb', 'events', '0311'),
('backofficeweb', 'missingimages', '0311'),
('backofficeweb', 'specifications', '0311'),
('backofficeweb', 'mainslider', '0311'),
('backofficeweb', 'orders', '0311'),
('backofficeweb', 'update_tb_prod', '0311'),
('gestorintegral', 'tasks', '0002');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_users`
--

CREATE TABLE `tb_users` (
  `ucoduser` varchar(11) NOT NULL COMMENT 'Código de usuario',
  `udni` varchar(11) NOT NULL COMMENT 'DNI',
  `urazon` varchar(100) NOT NULL COMMENT 'Razón social',
  `udireccion` varchar(150) NOT NULL COMMENT 'Dirección',
  `utelefono1` varchar(20) NOT NULL COMMENT 'Teléfono 1',
  `utelefono2` varchar(20) NOT NULL COMMENT 'Teléfono 2',
  `upaterno` varchar(30) NOT NULL COMMENT 'Apellido paterno',
  `umaterno` varchar(30) NOT NULL COMMENT 'Apellido materno',
  `unombre1` varchar(30) NOT NULL COMMENT 'Nombre 1',
  `unombre2` varchar(30) NOT NULL COMMENT 'Nombre 2',
  `ucorreo` varchar(100) NOT NULL COMMENT 'Correo electrónico',
  `upassword` varchar(255) NOT NULL COMMENT 'Contraseña',
  `u_datelogin` datetime NOT NULL COMMENT 'Fecha de inicio de sesión',
  `u_datecreate` datetime NOT NULL COMMENT 'Fecha de creación',
  `codverreg` varchar(6) NOT NULL COMMENT 'Código de verificación de registro',
  `sede` varchar(50) NOT NULL COMMENT 'Sede',
  `area` varchar(50) NOT NULL COMMENT 'Área',
  `cargo` varchar(50) NOT NULL COMMENT 'Cargo',
  `u_must_change_pass` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_users`
--

INSERT INTO `tb_users` (`ucoduser`, `udni`, `urazon`, `udireccion`, `utelefono1`, `utelefono2`, `upaterno`, `umaterno`, `unombre1`, `unombre2`, `ucorreo`, `upassword`, `u_datelogin`, `u_datecreate`, `codverreg`, `sede`, `area`, `cargo`, `u_must_change_pass`) VALUES
('0002', '45875429', 'Demo', 'Demo', '989898989', '', 'Demo', 'Demo', 'Demo', 'Demo', '', '$2y$10$jr3gSRlKzPkeXrOuH6kWLOq8df/1B4YV0uD7Ii3w6CUCXVYPu5aF.', '2026-01-05 13:40:31', '2023-03-23 17:56:19', '', '', 'Tienda30', '', 0),
('0311', '71236033', 'Junior Roman Marcelo Herrera', '', '910263402', '', 'Herrera', 'Marcelo', 'Junior', 'Roman', '', '$2y$10$FKDKwiTmoWl//K.gFOia0eZnSsVX9w4YRDbflJEnWKLw73dgD522C', '2026-01-05 13:43:17', '2025-12-17 19:06:39', '000000', 'Tienda30', 'Tienda30', 'USUARIO', 1);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_warranty`
--

CREATE TABLE `tb_warranty` (
  `wnumberid` int(10) NOT NULL COMMENT 'Clave primaria: id de garantía',
  `ccodcli` varchar(11) NOT NULL COMMENT 'Clave primaria de clientes',
  `ucoduser` varchar(11) NOT NULL COMMENT 'Clave primaria de técnicos',
  `guidesource` varchar(5) NOT NULL COMMENT 'Origen',
  `guidenumbersource` int(6) NOT NULL COMMENT 'Origen del número de guía',
  `wendpoint` varchar(5) NOT NULL COMMENT 'Punto de llegada',
  `wguidenumber` int(6) NOT NULL COMMENT 'Número de guía',
  `codigo` varchar(13) DEFAULT NULL COMMENT 'Número de guía de internamiento',
  `categoria` varchar(100) NOT NULL COMMENT 'Categoría - tipo de equipo',
  `subcategoria` varchar(100) NOT NULL COMMENT 'Subcategoría',
  `descripcion` varchar(50) NOT NULL COMMENT 'Modelo',
  `marca` varchar(50) NOT NULL COMMENT 'Marca',
  `serialnumber` varchar(50) DEFAULT NULL COMMENT 'Número de serie',
  `waccessories` varchar(100) DEFAULT NULL COMMENT 'Accesorios',
  `wequipmentstatus` varchar(100) NOT NULL COMMENT 'Estado del equipo',
  `wvoucher` varchar(13) NOT NULL COMMENT 'Comprobante',
  `wprpc` varchar(800) NOT NULL COMMENT 'Problema reportado por el cliente',
  `wdiagnostic` varchar(800) NOT NULL COMMENT 'Diagnóstico del técnico',
  `wsupplierpurchasedate` datetime DEFAULT NULL COMMENT 'Fecha de compra al proveedor',
  `wentrydate` datetime DEFAULT NULL COMMENT 'Fecha de ingreso a garantía',
  `wexitdate` datetime DEFAULT NULL COMMENT 'Fecha de salida',
  `westimateddate` datetime DEFAULT NULL COMMENT 'Fecha estimada de solución',
  `wsupplierentrydate` datetime DEFAULT NULL COMMENT 'Fecha de ingreso al proveedor',
  `wsupplierstate` varchar(50) NOT NULL COMMENT 'Estado del trámite del proveedor',
  `wproductlocation` varchar(50) NOT NULL COMMENT 'Ubicación del producto',
  `wguidetype` varchar(50) NOT NULL COMMENT 'Tipo de garantía: Stock o Cliente',
  `wsupplierresolutiondate` datetime DEFAULT NULL COMMENT 'Fecha de resolución del proveedor',
  `wsupplierresolution` varchar(800) NOT NULL COMMENT 'Resolución del proveedor',
  `wentrycode` varchar(10) NOT NULL COMMENT 'Código de ingreso',
  `wstage` varchar(100) NOT NULL COMMENT 'Etapa',
  `wstate` varchar(100) NOT NULL COMMENT 'Estado del equipo',
  `wpriceproduct` decimal(10,2) NOT NULL COMMENT 'Precio del producto',
  `wequipmentoperation` varchar(100) NOT NULL COMMENT 'Operatividad del equipo',
  `wproblemsdetected` varchar(800) NOT NULL COMMENT 'Problemas detectados',
  `wconcludingremarks` varchar(800) NOT NULL COMMENT 'Observaciones finales'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_warranty`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_warranty_indicator`
--

CREATE TABLE `tb_warranty_indicator` (
  `wguidenumber` int(6) NOT NULL,
  `wentrydate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Estructura de tabla para la tabla `tb_warranty_timeline`
--

CREATE TABLE `tb_warranty_timeline` (
  `ucoduser` varchar(11) NOT NULL COMMENT 'Código personal',
  `wguidenumber` varchar(6) NOT NULL COMMENT 'Número de guía',
  `wguidetipe` varchar(10) NOT NULL COMMENT 'Tipo de guía',
  `wtl_title` varchar(100) NOT NULL COMMENT 'Título',
  `wtl_description` varchar(800) NOT NULL COMMENT 'Descripción',
  `wtl_entrydate` datetime NOT NULL COMMENT 'Fecha de registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  ADD PRIMARY KEY (`ccodcli`);

--
-- Indices de la tabla `tb_gtor_tras`
--
ALTER TABLE `tb_gtor_tras`
  ADD PRIMARY KEY (`nmroid`);

--
-- Indices de la tabla `tb_idctorefcecytask`
--
ALTER TABLE `tb_idctorefcecytask`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ucoduser` (`ucoduser`),
  ADD KEY `dtergter` (`dtergter`);

--
-- Indices de la tabla `tb_lnatepo_tras`
--
ALTER TABLE `tb_lnatepo_tras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_prod`
--
ALTER TABLE `tb_prod`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tb_warranty`
--
ALTER TABLE `tb_warranty`
  ADD PRIMARY KEY (`wnumberid`),
  ADD UNIQUE KEY `wentrycode` (`wentrycode`),
  ADD KEY `ccodcli` (`ccodcli`),
  ADD KEY `ucoduser` (`ucoduser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_gtor_tras`
--
ALTER TABLE `tb_gtor_tras`
  MODIFY `nmroid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `tb_idctorefcecytask`
--
ALTER TABLE `tb_idctorefcecytask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT de la tabla `tb_lnatepo_tras`
--
ALTER TABLE `tb_lnatepo_tras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `tb_warranty`
--
ALTER TABLE `tb_warranty`
  MODIFY `wnumberid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria: id de garantía', AUTO_INCREMENT=1599;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
