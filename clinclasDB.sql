-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: clinclas
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Especialistas`
--

DROP TABLE IF EXISTS `Especialistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Especialistas` (
  `id_especialista` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `especialidad` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_especialista`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Especialistas`
--

LOCK TABLES `Especialistas` WRITE;
/*!40000 ALTER TABLE `Especialistas` DISABLE KEYS */;
INSERT INTO `Especialistas` VALUES (1,'Dra. Ana Pérez','555-1111','ana.perez@mail.com','Psiquiatra',NULL,NULL),(2,'Dra. Laura Gómez','555-2222','laura.gomez@mail.com','Fonoaudiología',NULL,NULL),(3,'Dr. Carlos Torres','555-3333','carlos.torres@mail.com','Psicología',NULL,NULL),(4,'Dra. Marta Fernández','555-4444','marta.fernandez@mail.com','Terapia Ocupacional',NULL,NULL),(5,'Norma Tapia','+569569066523','asd@342adf.cl','Psicologa','2024-12-05 19:20:08','2024-12-05 19:20:08');
/*!40000 ALTER TABLE `Especialistas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EstadosSesiones`
--

DROP TABLE IF EXISTS `EstadosSesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `EstadosSesiones` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `id_sesion` int NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('pendiente','cancelada','realizada','no avisó') NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `notas` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado`),
  KEY `id_sesion` (`id_sesion`),
  CONSTRAINT `EstadosSesiones_ibfk_1` FOREIGN KEY (`id_sesion`) REFERENCES `Sesiones` (`id_sesion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EstadosSesiones`
--

LOCK TABLES `EstadosSesiones` WRITE;
/*!40000 ALTER TABLE `EstadosSesiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `EstadosSesiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Paciente_Especialista`
--

DROP TABLE IF EXISTS `Paciente_Especialista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Paciente_Especialista` (
  `id_p_e` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `id_especialista` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_p_e`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_especialista` (`id_especialista`),
  CONSTRAINT `Paciente_Especialista_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`) ON DELETE CASCADE,
  CONSTRAINT `Paciente_Especialista_ibfk_2` FOREIGN KEY (`id_especialista`) REFERENCES `Especialistas` (`id_especialista`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Paciente_Especialista`
--

LOCK TABLES `Paciente_Especialista` WRITE;
/*!40000 ALTER TABLE `Paciente_Especialista` DISABLE KEYS */;
/*!40000 ALTER TABLE `Paciente_Especialista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pacientes`
--

DROP TABLE IF EXISTS `Pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pacientes` (
  `id_paciente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `curso` varchar(50) DEFAULT NULL,
  `colegio` varchar(100) DEFAULT NULL,
  `rut` varchar(20) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `info_adicional` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_paciente`),
  UNIQUE KEY `rut` (`rut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pacientes`
--

LOCK TABLES `Pacientes` WRITE;
/*!40000 ALTER TABLE `Pacientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pacientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pagos`
--

DROP TABLE IF EXISTS `Pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pagos` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `mes` date NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagado','atrasado') NOT NULL,
  `fecha_pagado` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `Pagos_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pagos`
--

LOCK TABLES `Pagos` WRITE;
/*!40000 ALTER TABLE `Pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reuniones`
--

DROP TABLE IF EXISTS `Reuniones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reuniones` (
  `id_reunion` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `estado` enum('realizada','cancelada','pendiente') NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reunion`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `Reuniones_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reuniones`
--

LOCK TABLES `Reuniones` WRITE;
/*!40000 ALTER TABLE `Reuniones` DISABLE KEYS */;
/*!40000 ALTER TABLE `Reuniones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sesiones`
--

DROP TABLE IF EXISTS `Sesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Sesiones` (
  `id_sesion` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `dia_semana` enum('lunes','martes','miércoles','jueves','viernes') NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `year` int DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo` enum('individual','grupal') DEFAULT NULL,
  PRIMARY KEY (`id_sesion`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `Sesiones_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sesiones`
--

LOCK TABLES `Sesiones` WRITE;
/*!40000 ALTER TABLE `Sesiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `Sesiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tutores`
--

DROP TABLE IF EXISTS `Tutores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tutores` (
  `id_tutor` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tutor`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `Tutores_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tutores`
--

LOCK TABLES `Tutores` WRITE;
/*!40000 ALTER TABLE `Tutores` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tutores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `rol_id` int NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(255) DEFAULT NULL,
  `rol_desc` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_desc_UNIQUE` (`rol_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'admin','Administrador de la pagina, tiene superpoderes en todo el sitio.',NULL,NULL),(2,'usuario','Usuario comun y corriente, solo puede ver, no editar ni borrar.',NULL,NULL);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_permiso`
--

DROP TABLE IF EXISTS `rol_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol_permiso` (
  `rp_id` int NOT NULL AUTO_INCREMENT,
  `rp_rol_id` int NOT NULL,
  `rp_prm_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rp_id`,`rp_rol_id`,`rp_prm_id`),
  KEY `fk_rol_permiso_rol1_idx` (`rp_rol_id`),
  KEY `fk_rol_permiso_permiso1_idx` (`rp_prm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_permiso`
--

LOCK TABLES `rol_permiso` WRITE;
/*!40000 ALTER TABLE `rol_permiso` DISABLE KEYS */;
INSERT INTO `rol_permiso` VALUES (1,1,1,'2024-10-22 23:54:49','2024-10-22 23:54:49'),(2,1,2,'2024-10-22 23:54:49','2024-10-22 23:54:49'),(3,1,3,'2024-10-22 23:54:49','2024-10-22 23:54:49');
/*!40000 ALTER TABLE `rol_permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_rol`
--

DROP TABLE IF EXISTS `user_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_rol` (
  `ur_id` int NOT NULL AUTO_INCREMENT,
  `ur_users_id` int NOT NULL,
  `ur_rol_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ur_id`,`ur_users_id`,`ur_rol_id`),
  KEY `fk_user_rol_users_idx` (`ur_users_id`),
  KEY `fk_user_rol_rol1_idx` (`ur_rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_rol`
--

LOCK TABLES `user_rol` WRITE;
/*!40000 ALTER TABLE `user_rol` DISABLE KEYS */;
INSERT INTO `user_rol` VALUES (1,1,1,NULL,NULL);
/*!40000 ALTER TABLE `user_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `empresa` varchar(45) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Martin Fica','mfica@adentu.cl',NULL,'Adentu','$2y$10$xHvB22o5lrCSjiySD3nezug6HbmGm6yzzfbU0/vXR3nLlb1ZeylYK',NULL,NULL,NULL),(3,'Matias','mnavarrete@adentu.cl',NULL,'Adentu','$2y$10$/GPby/fxBI1FJL4M/1y0au9jpvWyLSRuRbcfwXzS6bYfpssHCKM0.',NULL,'2024-10-29 17:54:13','2024-10-29 17:54:13'),(4,'Norma Tapia','natapiar@gmail.com',NULL,'Psicopedagoga','$2y$10$FLJfbLSxTI7hrke221dpKOnD58zzhv555f.pBlnJqjQYFy1omFsJC',NULL,'2024-12-04 00:37:07','2024-12-04 00:37:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-11 17:42:30
