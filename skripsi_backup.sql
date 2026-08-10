-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: skripsi
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `data_pengobatan`
--

DROP TABLE IF EXISTS `data_pengobatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_pengobatan` (
  `id_pengobatan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pasien` bigint unsigned NOT NULL,
  `id_petugas` bigint unsigned NOT NULL,
  `kategori_viral_load` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status_viral_load` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_viral_load` int DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengobatan`),
  KEY `data_pengobatan_id_pasien_foreign` (`id_pasien`),
  KEY `data_pengobatan_id_petugas_foreign` (`id_petugas`),
  CONSTRAINT `data_pengobatan_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `data_pengobatan_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pengobatan`
--

LOCK TABLES `data_pengobatan` WRITE;
/*!40000 ALTER TABLE `data_pengobatan` DISABLE KEYS */;
INSERT INTO `data_pengobatan` VALUES (1,2,1,'Viraload 6 Bulan Awal','2025-11-06','TND',0,'Pemeriksaan VL Viraload 6 Bulan Awal','2026-07-06 00:52:34','2026-07-06 00:52:34'),(2,2,1,'Viraload Tahunan Rutin','2026-05-06','TND',0,'Pemeriksaan VL Viraload Tahunan Rutin','2026-07-06 00:52:34','2026-07-06 00:52:34'),(3,10,1,'Viraload 6 Bulan Awal','2025-11-06','TND',0,'Pemeriksaan VL Viraload 6 Bulan Awal','2026-07-06 00:52:35','2026-07-06 00:52:35'),(4,20,1,'Viraload 6 Bulan Awal','2026-03-06','Terdeteksi',828,'Pemeriksaan VL Viraload 6 Bulan Awal','2026-07-06 00:52:38','2026-07-06 00:52:38');
/*!40000 ALTER TABLE `data_pengobatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kartu_kendali`
--

DROP TABLE IF EXISTS `kartu_kendali`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kartu_kendali` (
  `id_kartu_kendali` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pasien` bigint unsigned NOT NULL,
  `id_petugas` bigint unsigned NOT NULL,
  `rejimen_arv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_arv_tersisa` int DEFAULT NULL,
  `tanggal_kunjungan` date DEFAULT NULL,
  `rencana_tanggal_kunjungan_selanjutnya` date DEFAULT NULL,
  `obat_yang_diberikan` text COLLATE utf8mb4_unicode_ci,
  `jumlah_inh_yang_tersisa` int DEFAULT NULL,
  `jumlah_inh_yang_diberikan_untuk_bulan_berikutnya` int DEFAULT NULL,
  `efek_samping_dan_lab_profilaksis` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kartu_kendali`),
  KEY `kartu_kendali_id_pasien_foreign` (`id_pasien`),
  KEY `kartu_kendali_id_petugas_foreign` (`id_petugas`),
  CONSTRAINT `kartu_kendali_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `kartu_kendali_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kartu_kendali`
--

LOCK TABLES `kartu_kendali` WRITE;
/*!40000 ALTER TABLE `kartu_kendali` DISABLE KEYS */;
INSERT INTO `kartu_kendali` VALUES (1,2,1,'TDF/3TC/EFV',2,'2025-11-23','2025-12-23','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":2},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":8}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:33','2026-07-06 00:52:33'),(2,2,1,'TDF/3TC/EFV',2,'2025-12-23','2026-01-22','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":7}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:33','2026-07-06 00:52:33'),(3,2,1,'TDF/3TC/EFV',5,'2026-01-22','2026-02-21','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":1}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:33','2026-07-06 00:52:33'),(4,2,1,'TDF/3TC/EFV',3,'2026-02-21','2026-03-23','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":1}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:33','2026-07-06 00:52:33'),(5,2,1,'TDF/3TC/EFV',3,'2026-03-23','2026-04-22','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":4},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":3}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:33','2026-07-06 00:52:33'),(6,2,1,'TDF/3TC/EFV',2,'2026-04-22','2026-05-22','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":6}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(7,2,1,'TDF/3TC/EFV',2,'2026-05-22','2026-06-21','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":3}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(8,2,1,'TDF/3TC/EFV',1,'2026-06-21','2026-07-21','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":3},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":6}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(9,4,1,'TDF/3TC/EFV',4,'2025-12-05','2026-01-04','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":8}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(10,4,1,'TDF/3TC/EFV',0,'2026-01-04','2026-02-03','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":5}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(11,4,1,'TDF/3TC/EFV',0,'2026-02-03','2026-03-05','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":3}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(12,4,1,'TDF/3TC/EFV',3,'2026-03-05','2026-04-04','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":5}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(13,4,1,'TDF/3TC/EFV',5,'2026-04-04','2026-05-04','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":8},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":5}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(14,4,1,'TDF/3TC/EFV',2,'2026-05-04','2026-06-03','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":2},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":2}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(15,4,1,'TDF/3TC/EFV',0,'2026-06-03','2026-07-03','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":8},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":4}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(16,4,1,'TDF/3TC/EFV',5,'2026-07-03','2026-08-02','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":3}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:34','2026-07-06 00:52:34'),(17,6,1,'TDF/3TC/EFV',5,'2026-03-07','2026-04-06','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":10},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":5}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(18,6,1,'TDF/3TC/EFV',2,'2026-04-06','2026-05-06','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":8},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":10}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(19,6,1,'TDF/3TC/EFV',4,'2026-05-06','2026-06-05','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":4}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(20,6,1,'TDF/3TC/EFV',0,'2026-06-05','2026-07-05','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":6}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(21,6,1,'TDF/3TC/EFV',5,'2026-07-05','2026-08-04','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":8},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":7}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(22,8,1,'TDF/3TC/EFV',0,'2026-03-06','2026-04-05','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":3},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":10}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(23,8,1,'TDF/3TC/EFV',2,'2026-04-05','2026-05-05','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":5}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(24,8,1,'TDF/3TC/EFV',4,'2026-05-05','2026-06-04','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":9}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(25,8,1,'TDF/3TC/EFV',2,'2026-06-04','2026-07-04','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":1}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(26,8,1,'TDF/3TC/EFV',5,'2026-07-04','2026-08-03','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":8}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(27,10,1,'TDF/3TC/EFV',0,'2025-12-01','2025-12-31','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":2}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(28,10,1,'TDF/3TC/EFV',5,'2025-12-31','2026-01-30','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":10},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":7}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(29,10,1,'TDF/3TC/EFV',2,'2026-01-30','2026-03-01','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":4}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(30,10,1,'TDF/3TC/EFV',2,'2026-03-01','2026-03-31','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":2},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":8}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(31,10,1,'TDF/3TC/EFV',5,'2026-03-31','2026-04-30','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":9}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(32,10,1,'TDF/3TC/EFV',0,'2026-04-30','2026-05-30','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":4},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":2}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(33,10,1,'TDF/3TC/EFV',3,'2026-05-30','2026-06-29','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":7}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:35','2026-07-06 00:52:35'),(34,12,1,'TDF/3TC/EFV',1,'2025-09-24','2025-10-24','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":2}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(35,12,1,'TDF/3TC/EFV',0,'2025-10-24','2025-11-23','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":3}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(36,12,1,'TDF/3TC/EFV',5,'2025-11-23','2025-12-23','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":1},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":7}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(37,12,1,'TDF/3TC/EFV',5,'2025-12-23','2026-01-22','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":10}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(38,12,1,'TDF/3TC/EFV',1,'2026-01-22','2026-02-21','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":7}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(39,12,1,'TDF/3TC/EFV',4,'2026-02-21','2026-03-23','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":2},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":8}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(40,12,1,'TDF/3TC/EFV',4,'2026-03-23','2026-04-22','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":4}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(41,12,1,'TDF/3TC/EFV',0,'2026-04-22','2026-05-22','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":2},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":6}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(42,12,1,'TDF/3TC/EFV',5,'2026-05-22','2026-06-21','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":6}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(43,14,1,'TDF/3TC/EFV',0,'2025-08-14','2025-09-13','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":2},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":10}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(44,14,1,'TDF/3TC/EFV',0,'2025-09-13','2025-10-13','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":2},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":8}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(45,14,1,'TDF/3TC/EFV',5,'2025-10-13','2025-11-12','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":5},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":1}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(46,14,1,'TDF/3TC/EFV',1,'2025-11-12','2025-12-12','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":1},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":1}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(47,14,1,'TDF/3TC/EFV',2,'2025-12-12','2026-01-11','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":9},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":2}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(48,14,1,'TDF/3TC/EFV',3,'2026-01-11','2026-02-10','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":10},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":10}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(49,14,1,'TDF/3TC/EFV',0,'2026-02-10','2026-03-12','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":10},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":6}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(50,14,1,'TDF/3TC/EFV',3,'2026-03-12','2026-04-11','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":3},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":8}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(51,14,1,'TDF/3TC/EFV',2,'2026-04-11','2026-05-11','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":1},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":9}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(52,14,1,'TDF/3TC/EFV',1,'2026-05-11','2026-06-10','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":3}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:36','2026-07-06 00:52:36'),(53,16,1,'TDF/3TC/EFV',5,'2025-10-19','2025-11-18','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":4}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(54,16,1,'TDF/3TC/EFV',0,'2025-11-18','2025-12-18','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":10}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(55,16,1,'TDF/3TC/EFV',4,'2025-12-18','2026-01-17','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":6},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":9}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(56,16,1,'TDF/3TC/EFV',0,'2026-01-17','2026-02-16','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":8}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(57,16,1,'TDF/3TC/EFV',4,'2026-02-16','2026-03-18','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":9},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":6}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(58,18,1,'TDF/3TC/EFV',3,'2025-07-19','2025-08-18','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":9}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(59,18,1,'TDF/3TC/EFV',4,'2025-08-18','2025-09-17','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":4}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(60,18,1,'TDF/3TC/EFV',5,'2025-09-17','2025-10-17','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":4}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(61,18,1,'TDF/3TC/EFV',5,'2025-10-17','2025-11-16','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":7}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(62,18,1,'TDF/3TC/EFV',4,'2025-11-16','2025-12-16','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":4},{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":4}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(63,18,1,'TDF/3TC/EFV',1,'2025-12-16','2026-01-15','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":10},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":8}]',1,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(64,18,1,'TDF/3TC/EFV',5,'2026-01-15','2026-02-14','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":1}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(65,18,1,'TDF/3TC/EFV',5,'2026-02-14','2026-03-16','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":6}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:37','2026-07-06 00:52:37'),(66,20,1,'TDF/3TC/EFV',3,'2025-09-04','2025-10-04','[{\"nama\":\"Sulfamethoxazole: 800 mg \\/ Trimethoprim: 160 mg\",\"jumlah\":9}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(67,20,1,'TDF/3TC/EFV',1,'2025-10-04','2025-11-03','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":4},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":8}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(68,20,1,'TDF/3TC/EFV',1,'2025-11-03','2025-12-03','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":1}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(69,20,1,'TDF/3TC/EFV',1,'2025-12-03','2026-01-02','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":4},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":4}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(70,20,1,'TDF/3TC/EFV',3,'2026-01-02','2026-02-01','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":3}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(71,20,1,'TDF/3TC/EFV',3,'2026-02-01','2026-03-03','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":6},{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":6}]',2,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(72,20,1,'TDF/3TC/EFV',3,'2026-03-03','2026-04-02','[{\"nama\":\"TDF(300)\\/3TC(300)\\/EFV(600)\",\"jumlah\":2},{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":6}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(73,22,1,'TDF/3TC/EFV',3,'2026-01-22','2026-02-21','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":3}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(74,22,1,'TDF/3TC/EFV',0,'2026-02-21','2026-03-23','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":4},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":3}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(75,22,1,'TDF/3TC/EFV',1,'2026-03-23','2026-04-22','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":3},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":9}]',0,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(76,22,1,'TDF/3TC/EFV',2,'2026-04-22','2026-05-22','[{\"nama\":\"TDF(300)\\/3TC(300)\\/DTG(50)\",\"jumlah\":8},{\"nama\":\"TPT 3HP KDT\",\"jumlah\":3}]',5,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(77,22,1,'TDF/3TC/EFV',1,'2026-05-22','2026-06-21','[{\"nama\":\"OAT KDT Kategori 1\",\"jumlah\":10}]',4,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38'),(78,22,1,'TDF/3TC/EFV',0,'2026-06-21','2026-07-21','[{\"nama\":\"TPT 3HP KDT\",\"jumlah\":5}]',3,30,'-','Kunjungan rutin test seeder','2026-07-06 00:52:38','2026-07-06 00:52:38');
/*!40000 ALTER TABLE `kartu_kendali` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keluarga`
--

DROP TABLE IF EXISTS `keluarga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keluarga` (
  `user_id` bigint unsigned NOT NULL,
  `pasien_id` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_hubungan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `keluarga_pasien_id_unique` (`pasien_id`),
  CONSTRAINT `keluarga_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `keluarga_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keluarga`
--

LOCK TABLES `keluarga` WRITE;
/*!40000 ALTER TABLE `keluarga` DISABLE KEYS */;
INSERT INTO `keluarga` VALUES (3,2,'Dodo Kuswoyo',NULL,'080358945790','Psr. Gatot Subroto No. 962, Kediri 18121, Banten',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:33','2026-07-06 00:52:33'),(5,4,'Zaenab Melinda Hasanah S.E.',NULL,'083775440737','Psr. Basmol Raya No. 514, Tegal 36289, Babel',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:34','2026-07-06 00:52:34'),(7,6,'Betania Tania Puspasari M.Farm',NULL,'084819484106','Ds. Sukabumi No. 655, Tangerang Selatan 56694, NTB',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:35','2026-07-06 00:52:35'),(9,8,'Baktianto Nashiruddin M.Kom.',NULL,'080806555315','Psr. Madrasah No. 696, Tasikmalaya 22078, Kalsel',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:35','2026-07-06 00:52:35'),(11,10,'Tami Keisha Hariyah',NULL,'087856328805','Gg. Otista No. 931, Metro 96003, NTT',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:35','2026-07-06 00:52:35'),(13,12,'Lidya Padmasari',NULL,'083746767927','Kpg. Otto No. 266, Kotamobagu 77100, Aceh',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:36','2026-07-06 00:52:36'),(15,14,'Laras Agustina S.Kom',NULL,'088143233570','Dk. Dago No. 632, Gunungsitoli 10149, Kalsel',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:36','2026-07-06 00:52:36'),(17,16,'Parman Baktianto Firmansyah S.Gz',NULL,'085513925600','Ds. Sutan Syahrir No. 454, Langsa 64625, Riau',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:37','2026-07-06 00:52:37'),(19,18,'Wirda Aryani',NULL,'081470593923','Jr. Achmad No. 566, Batu 29366, Sumsel',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:37','2026-07-06 00:52:37'),(21,20,'Kayla Anggraini',NULL,'080764885416','Kpg. Bakau Griya Utama No. 582, Administrasi Jakarta Selatan 92808, Kalbar',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:38','2026-07-06 00:52:38'),(23,22,'Taufik Jindra Simanjuntak M.Ak',NULL,'083473908813','Ds. Ters. Pasir Koja No. 657, Blitar 99310, DKI',NULL,NULL,'Banyuwangi','Benculuk',NULL,'Jawa Timur','2026-07-06 00:52:38','2026-07-06 00:52:38');
/*!40000 ALTER TABLE `keluarga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_evaluasi`
--

DROP TABLE IF EXISTS `laporan_evaluasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_evaluasi` (
  `id_laporan_evaluasi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pasien` bigint unsigned NOT NULL,
  `id_petugas` bigint unsigned NOT NULL,
  `kunjungan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `standar_klinis` text COLLATE utf8mb4_unicode_ci,
  `hasil_arv_terakhir` text COLLATE utf8mb4_unicode_ci,
  `status_viral_load` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_fungsional` text COLLATE utf8mb4_unicode_ci,
  `jumlah_cd4` int DEFAULT NULL,
  `berat_badan` decimal(8,2) DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_laporan_evaluasi`),
  KEY `laporan_evaluasi_id_pasien_foreign` (`id_pasien`),
  KEY `laporan_evaluasi_id_petugas_foreign` (`id_petugas`),
  CONSTRAINT `laporan_evaluasi_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `laporan_evaluasi_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_evaluasi`
--

LOCK TABLES `laporan_evaluasi` WRITE;
/*!40000 ALTER TABLE `laporan_evaluasi` DISABLE KEYS */;
INSERT INTO `laporan_evaluasi` VALUES (1,2,1,'Kunjungan Pertama','2025-04-22','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',373,65.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:34','2026-07-06 00:52:34'),(2,2,1,'Memenuhi Syarat Medis ART','2025-04-29','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',258,47.00,'Persiapan ART.','2026-07-06 00:52:34','2026-07-06 00:52:34'),(3,2,1,'Saat Mulai ART','2025-05-06','Kondisi stabil awal.','-','Belum Dilakukan','K',291,78.00,'Mulai Pengobatan','2026-07-06 00:52:34','2026-07-06 00:52:34'),(4,2,1,'Setelah 6 Bulan ART','2025-11-06','Evaluasi rutin.','Toleransi baik.','Sudah Dilakukan Viraload 6 Bulan Awal','K',560,59.00,'Evaluasi rutin Setelah 6 Bulan ART','2026-07-06 00:52:34','2026-07-06 00:52:34'),(5,2,1,'Setelah 1 Tahun ART','2026-05-06','Evaluasi rutin.','Toleransi baik.','Sudah Dilakukan Viraload Tahunan Rutin','K',447,70.00,'Evaluasi rutin Setelah 1 Tahun ART','2026-07-06 00:52:34','2026-07-06 00:52:34'),(6,4,1,'Kunjungan Pertama','2025-12-23','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',651,60.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:34','2026-07-06 00:52:34'),(7,4,1,'Memenuhi Syarat Medis ART','2025-12-30','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',562,61.00,'Persiapan ART.','2026-07-06 00:52:34','2026-07-06 00:52:34'),(8,4,1,'Saat Mulai ART','2026-01-06','Kondisi stabil awal.','-','Belum Dilakukan','K',430,60.00,'Mulai Pengobatan','2026-07-06 00:52:34','2026-07-06 00:52:34'),(9,6,1,'Kunjungan Pertama','2026-02-20','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',330,65.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:35','2026-07-06 00:52:35'),(10,6,1,'Memenuhi Syarat Medis ART','2026-02-27','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',633,54.00,'Persiapan ART.','2026-07-06 00:52:35','2026-07-06 00:52:35'),(11,6,1,'Saat Mulai ART','2026-03-06','Kondisi stabil awal.','-','Belum Dilakukan','K',207,65.00,'Mulai Pengobatan','2026-07-06 00:52:35','2026-07-06 00:52:35'),(12,8,1,'Kunjungan Pertama','2026-04-22','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',427,76.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:35','2026-07-06 00:52:35'),(13,8,1,'Memenuhi Syarat Medis ART','2026-04-29','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',539,78.00,'Persiapan ART.','2026-07-06 00:52:35','2026-07-06 00:52:35'),(14,8,1,'Saat Mulai ART','2026-05-06','Kondisi stabil awal.','-','Belum Dilakukan','K',581,57.00,'Mulai Pengobatan','2026-07-06 00:52:35','2026-07-06 00:52:35'),(15,10,1,'Kunjungan Pertama','2025-04-22','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',523,67.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:35','2026-07-06 00:52:35'),(16,10,1,'Memenuhi Syarat Medis ART','2025-04-29','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',244,58.00,'Persiapan ART.','2026-07-06 00:52:35','2026-07-06 00:52:35'),(17,10,1,'Saat Mulai ART','2025-05-06','Kondisi stabil awal.','-','Belum Dilakukan','K',681,63.00,'Mulai Pengobatan','2026-07-06 00:52:35','2026-07-06 00:52:35'),(18,10,1,'Setelah 6 Bulan ART','2025-11-06','Evaluasi rutin.','Toleransi baik.','Sudah Dilakukan Viraload 6 Bulan Awal','K',690,76.00,'Evaluasi rutin Setelah 6 Bulan ART','2026-07-06 00:52:35','2026-07-06 00:52:35'),(19,12,1,'Kunjungan Pertama','2026-01-23','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',553,63.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:36','2026-07-06 00:52:36'),(20,12,1,'Memenuhi Syarat Medis ART','2026-01-30','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',625,52.00,'Persiapan ART.','2026-07-06 00:52:36','2026-07-06 00:52:36'),(21,12,1,'Saat Mulai ART','2026-02-06','Kondisi stabil awal.','-','Belum Dilakukan','K',652,69.00,'Mulai Pengobatan','2026-07-06 00:52:36','2026-07-06 00:52:36'),(22,14,1,'Kunjungan Pertama','2026-03-23','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',525,47.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:36','2026-07-06 00:52:36'),(23,14,1,'Memenuhi Syarat Medis ART','2026-03-30','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',384,67.00,'Persiapan ART.','2026-07-06 00:52:36','2026-07-06 00:52:36'),(24,14,1,'Saat Mulai ART','2026-04-06','Kondisi stabil awal.','-','Belum Dilakukan','K',380,68.00,'Mulai Pengobatan','2026-07-06 00:52:36','2026-07-06 00:52:36'),(25,16,1,'Kunjungan Pertama','2026-02-20','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',272,58.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:37','2026-07-06 00:52:37'),(26,16,1,'Memenuhi Syarat Medis ART','2026-02-27','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',335,66.00,'Persiapan ART.','2026-07-06 00:52:37','2026-07-06 00:52:37'),(27,16,1,'Saat Mulai ART','2026-03-06','Kondisi stabil awal.','-','Belum Dilakukan','K',646,50.00,'Mulai Pengobatan','2026-07-06 00:52:37','2026-07-06 00:52:37'),(28,18,1,'Kunjungan Pertama','2025-11-22','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',481,70.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:37','2026-07-06 00:52:37'),(29,18,1,'Memenuhi Syarat Medis ART','2025-11-29','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',652,67.00,'Persiapan ART.','2026-07-06 00:52:37','2026-07-06 00:52:37'),(30,18,1,'Saat Mulai ART','2025-12-06','Kondisi stabil awal.','-','Belum Dilakukan','K',709,55.00,'Mulai Pengobatan','2026-07-06 00:52:37','2026-07-06 00:52:37'),(31,20,1,'Kunjungan Pertama','2025-08-23','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',368,65.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:38','2026-07-06 00:52:38'),(32,20,1,'Memenuhi Syarat Medis ART','2025-08-30','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',342,65.00,'Persiapan ART.','2026-07-06 00:52:38','2026-07-06 00:52:38'),(33,20,1,'Saat Mulai ART','2025-09-06','Kondisi stabil awal.','-','Belum Dilakukan','K',709,45.00,'Mulai Pengobatan','2026-07-06 00:52:38','2026-07-06 00:52:38'),(34,20,1,'Setelah 6 Bulan ART','2026-03-06','Evaluasi rutin.','Toleransi baik.','Sudah Dilakukan Viraload 6 Bulan Awal','K',301,74.00,'Evaluasi rutin Setelah 6 Bulan ART','2026-07-06 00:52:38','2026-07-06 00:52:38'),(35,22,1,'Kunjungan Pertama','2026-03-23','Pasien datang dengan keluhan.','-','Belum Dilakukan','A',767,73.00,'Tes HIV awal dilakukan.','2026-07-06 00:52:38','2026-07-06 00:52:38'),(36,22,1,'Memenuhi Syarat Medis ART','2026-03-30','Hasil tes positif, konseling dilakukan.','-','Belum Dilakukan','A',784,66.00,'Persiapan ART.','2026-07-06 00:52:38','2026-07-06 00:52:38'),(37,22,1,'Saat Mulai ART','2026-04-06','Kondisi stabil awal.','-','Belum Dilakukan','K',203,71.00,'Mulai Pengobatan','2026-07-06 00:52:38','2026-07-06 00:52:38');
/*!40000 ALTER TABLE `laporan_evaluasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'2026_05_04_000001_create_petugas_table',1),(3,'2026_05_04_000002_create_pasien_table',1),(4,'2026_05_04_000003_create_keluarga_table',1),(5,'2026_05_04_000004_create_remaining_tables',1),(6,'2026_05_04_104319_add_hasil_vl_to_data_pengobatan_table',1),(7,'2026_05_04_131500_add_unique_to_pasien_id_in_keluarga_table',1),(8,'2026_05_05_151737_create_push_subscriptions_table',1),(9,'2026_05_09_000001_add_phone_number_to_users_table',1),(10,'2026_05_09_000002_add_obat_yang_diberikan_to_kartu_kendali_table',1),(11,'2026_05_09_000003_revise_kartu_kendali_fields',1),(12,'2026_05_09_000004_revise_laporan_evaluasi_fields',1),(13,'2026_05_09_000005_add_compliance_tracking_to_pasien',1),(14,'2026_05_09_000006_add_status_kunjungan_to_pasien',1),(15,'2026_05_09_100656_add_kelurahan_to_tables',1),(16,'2026_05_09_101951_drop_unused_tables',1),(17,'2026_05_13_060923_add_foto_profil_to_users_table',1),(18,'2026_05_13_100507_add_status_viral_load_to_laporan_evaluasi_table',1),(19,'2026_05_13_101124_add_kategori_to_data_pengobatan_table',1),(20,'2026_05_13_104406_add_berat_badan_to_laporan_evaluasi_table',1),(21,'2026_06_19_155007_add_tanggal_lahir_jenis_kelamin_to_petugas_table',1),(22,'2026_07_06_071447_add_status_hubungan_to_keluarga_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifikasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifikasi_user_id_foreign` (`user_id`),
  CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--

LOCK TABLES `notifikasi` WRITE;
/*!40000 ALTER TABLE `notifikasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pasien`
--

DROP TABLE IF EXISTS `pasien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasien` (
  `user_id` bigint unsigned NOT NULL,
  `petugas_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_perkawinan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_registrasi_nasional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pasien` enum('Hidup','Meninggal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hidup',
  `status_kunjungan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `tanggal_kunjungan_terakhir` date DEFAULT NULL,
  `rencana_kunjungan_berikutnya` date DEFAULT NULL,
  `tanggal_awal_pengobatan` date DEFAULT NULL,
  `lokasi_diagnosa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_pasien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `pasien_nomor_rm_unique` (`nomor_rm`),
  UNIQUE KEY `pasien_nik_unique` (`nik`),
  KEY `pasien_petugas_id_foreign` (`petugas_id`),
  CONSTRAINT `pasien_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `pasien_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pasien`
--

LOCK TABLES `pasien` WRITE;
/*!40000 ALTER TABLE `pasien` DISABLE KEYS */;
INSERT INTO `pasien` VALUES (2,1,'Bakianto Warsita Waskita S.Sos','4428368','5567089691662901','Cimahi','1984-06-24','Perempuan','Islam','Kawin','Psr. Gatot Subroto No. 962, Kediri 18121, Banten','10','11','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','084344031739','P3510060201-0001','Hidup','Active','2026-06-21','2026-07-21','2025-05-06','Puskesmas Benculuk','Baru','2025-05-05 17:00:00','2026-07-06 00:52:33'),(4,1,'Gamanto Habibi','7166599','6134579514549054','Denpasar','1978-01-08','Perempuan','Islam','Kawin','Psr. Basmol Raya No. 514, Tegal 36289, Babel','11','10','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','083416682472','P3510060201-0002','Hidup','Active','2026-07-03','2026-08-02','2026-01-06','Puskesmas Benculuk','Baru','2026-01-05 17:00:00','2026-07-06 00:52:34'),(6,1,'Patricia Hastuti','2734786','8088180701429632','Serang','1984-03-26','Perempuan','Islam','Kawin','Ds. Sukabumi No. 655, Tangerang Selatan 56694, NTB','7','3','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','084123533376','P3510060201-0003','Hidup','Active','2026-07-05','2026-08-04','2026-03-06','Puskesmas Benculuk','Baru','2026-03-05 17:00:00','2026-07-06 00:52:35'),(8,1,'Ophelia Oliva Hasanah M.Ak','2896723','2840541831454877','Administrasi Jakarta Pusat','1977-06-26','Laki-laki','Islam','Kawin','Psr. Madrasah No. 696, Tasikmalaya 22078, Kalsel','10','14','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','083578194048','P3510060201-0004','Hidup','Active','2026-07-04','2026-08-03','2026-05-06','Puskesmas Benculuk','Baru','2026-05-05 17:00:00','2026-07-06 00:52:35'),(10,1,'Titi Halima Laksmiwati S.Sos','2621824','8000955133138329','Administrasi Jakarta Timur','1999-03-06','Laki-laki','Islam','Kawin','Gg. Otista No. 931, Metro 96003, NTT','6','8','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','084984726098','P3510060201-0005','Hidup','Active','2026-05-30','2026-06-29','2025-05-06','Puskesmas Benculuk','Pindahan','2025-05-05 17:00:00','2026-07-06 00:52:35'),(12,1,'Dalima Nuraini','8795532','7723290754877189','Lubuklinggau','1998-11-27','Laki-laki','Islam','Kawin','Kpg. Otto No. 266, Kotamobagu 77100, Aceh','15','7','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','086086469122','P3510060201-0006','Hidup','Active','2026-05-22','2026-06-21','2026-02-06','Puskesmas Benculuk','Pindah Pengobatan','2026-02-05 17:00:00','2026-07-06 00:52:36'),(14,1,'Irma Widiastuti','3297345','6801666118911308','Administrasi Jakarta Utara','1985-02-09','Laki-laki','Islam','Kawin','Dk. Dago No. 632, Gunungsitoli 10149, Kalsel','9','6','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','084730803158','P3510060201-0007','Hidup','Active','2026-05-11','2026-06-10','2026-04-06','Puskesmas Benculuk','Lama','2026-04-05 17:00:00','2026-07-06 00:52:36'),(16,1,'Muni Lulut Sitorus S.E.I','9434763','6483724639082750','Payakumbuh','1995-10-25','Perempuan','Islam','Kawin','Ds. Sutan Syahrir No. 454, Langsa 64625, Riau','7','4','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','088958053262','P3510060201-0008','Meninggal','Active','2026-02-16','2026-03-18','2026-03-06','Puskesmas Benculuk','Pindahan','2026-03-05 17:00:00','2026-07-06 00:52:37'),(18,1,'Michelle Kania Winarsih S.I.Kom','8817747','8102282012650460','Pasuruan','1973-06-28','Perempuan','Islam','Kawin','Jr. Achmad No. 566, Batu 29366, Sumsel','14','11','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','085201578457','P3510060201-0009','Hidup','Active','2026-02-14','2026-03-16','2025-12-06','Puskesmas Benculuk','Pindah Pengobatan','2025-12-05 17:00:00','2026-07-06 00:52:37'),(20,1,'Kariman Kairav Hutapea','6197567','3823909583203945','Samarinda','1996-02-10','Laki-laki','Islam','Kawin','Kpg. Bakau Griya Utama No. 582, Administrasi Jakarta Selatan 92808, Kalbar','9','14','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','084437868840','P3510060201-0010','Meninggal','Active','2026-03-03','2026-04-02','2025-09-06','Puskesmas Benculuk','Pindah Pengobatan','2025-09-05 17:00:00','2026-07-06 00:52:38'),(22,1,'Tedi Megantara','9407838','6129502089004569','Pagar Alam','1996-08-02','Laki-laki','Islam','Kawin','Ds. Ters. Pasir Koja No. 657, Blitar 99310, DKI','15','7','Banyuwangi','Benculuk',NULL,NULL,'Jawa Timur','088731235075','P3510060201-0011','Hidup','Active','2026-06-21','2026-07-21','2026-04-06','Puskesmas Benculuk','Pindahan','2026-04-05 17:00:00','2026-07-06 00:52:38');
/*!40000 ALTER TABLE `pasien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `petugas` (
  `user_id` bigint unsigned NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `petugas_nip_unique` (`nip`),
  CONSTRAINT `petugas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES (1,'123456789','ANDRIYONO','1985-05-15','Laki-laki','08123456789','Jl. Gajah Mada, Gang Kelapa Muda No. 7, RT 05 / RW 02, Dusun Kepatihan, Desa Cluring, Kecamatan Cluring, Kabupaten Banyuwangi, Jawa Timur, 68482','2026-07-06 00:52:33','2026-07-06 00:52:33');
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `push_subscriptions`
--

DROP TABLE IF EXISTS `push_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `push_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subscribable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribable_id` bigint unsigned NOT NULL,
  `endpoint` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_encoding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  KEY `push_subscriptions_subscribable_morph_idx` (`subscribable_type`,`subscribable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `push_subscriptions`
--

LOCK TABLES `push_subscriptions` WRITE;
/*!40000 ALTER TABLE `push_subscriptions` DISABLE KEYS */;
INSERT INTO `push_subscriptions` VALUES (6,'App\\Models\\User',1,'https://fcm.googleapis.com/fcm/send/ftRMQXXnyxc:APA91bEF3JnlWzPHffyy3o4kcHpbx-wJRlzd56cKr0_EsInw7Zp8I3BCmpOwc1Wbya6KqLur_aa6-gIzBCbyhqJ8HvhJdTgOc1-v6CxReDYdVnaoH2CoKwBHsmmIm8KzK7YeoWMo6XrF','BPnb9txRKcGlO+C+Ap7YYA5rcucTz/KYe6ka1llj1A6fT7DnEMdOUihBPaQXanklitOoCtReTFYaaeiiU3ygLVo=','cB8SKFR+YmJiny+mlwNoJw==','aes128gcm','2026-07-28 08:22:26','2026-07-28 08:22:26'),(7,'App\\Models\\User',1,'https://fcm.googleapis.com/fcm/send/df9bwHDDe4o:APA91bGV2s72MPO8q-04zMzd9AJApz-5AAzmxv98WA9-WHSZcDi9enRMDC351SMpH33jQbDy2BKG8rfwGJ2iqxbIs3h7wVXbrPSNsWd4Dhdxb0tCA9vM7ozZry0OTVCC8JseVXcIHsAX','BH2lmCpiA38PKrF6Por8qWwNAi4gYgiwuJVrocOLDlCHtXYzBMc72RSod6jv4CeuIQldQmFFGhTfkMuIohXlLbY=','TBXjii80t6df/TN4ZvGfbg==','aes128gcm','2026-07-28 08:23:40','2026-07-28 08:23:40');
/*!40000 ALTER TABLE `push_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('aTizAYRlZd5DldQrFRDhQHbCigTgzEECjlr9mLCm',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ5MXJtblR3dTVYY3dmN3JBZFAxVmdjOWNESWJpWVJORUJrR0FoaWYyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9rYXJ0dS1rZW5kYWxpXC9yaXdheWF0LWthcnR1LWtlbmRhbGlcLzgiLCJyb3V0ZSI6InBldHVnYXMucml3YXlhdC1rYXJ0dS1rZW5kYWxpIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1785252252),('DoQhmtS1l8AaxbNwQUd46G4AApagqI2iVP4v6194',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJJVG1kTGZoVjFEU0JMMmZHeE5uRlhvdVAxblNtNlhLQlBGbXlHVEI3IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3Bhc2llblwvZGFzaGJvYXJkIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1785126778),('kALEDZtQ3XJxmf0CpKc0TE4zFnTuJ8h88EwSzhjs',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJaV2hGc3dhRGJCeWtvRWxVRVpPV1l2Qzd0dEVqYTZNV29HaUZsN3ZBIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYXNpZW5cL2Rhc2hib2FyZCIsInJvdXRlIjoicGFzaWVuLmRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1785124999),('LwEJMXHNdcbBRmehbtafGB6HbI9HMnUYLVaK1q7x',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ5TWlQVzduZFVkSGJDT3VHRjFEUzBjbjBMcjNHb2t2WXVLWVJzYXEzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1785251986),('MlOTrnV0cCOrbp1wKqHeSgAX47qVT7s3JeETMQxp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJwSlRnamVOMmpNYXVReURWQWN6R2g2Y3JRdG5sWEFITlJ2OGhKUjVmIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZCJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1785316196),('TTouWZiZmKSa0bmSxMfMftopLNZUR3FPti0omZ3k',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJtV0Ftd2VibDEwOXJSc2tVS21nMVZ3UGZsak5IRWR2NXJYcDc2Nm5nIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6InBldHVnYXMuZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1785301194),('vPR2HsJJMvAN2mrtW5AVuWNg47cWdLuG9hRVc8XD',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ5VkdJbU1FZXN1Um5IMlBrRkwyT2h0azQ2Y1M4aEJ4Q2ppQmQ1b3JtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9rYXJ0dS1rZW5kYWxpXC9yaXdheWF0LWthcnR1LWtlbmRhbGlcLzgiLCJyb3V0ZSI6InBldHVnYXMucml3YXlhdC1rYXJ0dS1rZW5kYWxpIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1785252156),('XYfFzcgtY0Xwe8ArfwE5NsexKd7tDSv0Qsl4oCW3',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ5ak83NjNDRktlMFVGR0cwcnZ6azQwMFNnMkxId0pVeVZneXl2UlRYIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYXNpZW5cL2Rhc2hib2FyZCIsInJvdXRlIjoicGFzaWVuLmRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1785126895);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas','pasien','keluarga') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ANDRIYONO','petugas@gmail.com',NULL,NULL,'$2y$12$f.4uHMotrYBl6boMFu5UZuLfw5iPOZYKYwuN5sW22TqTREG8PnJgG','petugas',NULL,NULL,'2026-03-06 00:52:33','2026-03-06 00:52:33'),(2,'Bakianto Warsita Waskita S.Sos','pasien1@test.com',NULL,NULL,'$2y$12$9B8SfBORPkLgAmazPZ8gceXhdtCiP7vSFufgpq02ZCxlkChILoRcC','pasien',NULL,NULL,'2025-05-05 17:00:00','2025-05-05 17:00:00'),(3,'Dodo Kuswoyo','keluarga1@test.com',NULL,NULL,'$2y$12$s6.hUi61NfE2M7lbbFb/Y.K80UM91t6nTq4ISZ8zPXoHhOynXzmXu','keluarga',NULL,NULL,'2026-07-06 00:52:33','2026-07-06 00:52:33'),(4,'Gamanto Habibi','pasien2@test.com',NULL,NULL,'$2y$12$8MJQHpbtivR8KaOjmrFPbePACIsiOIstojToq2Qp1aKGgG7AepsRC','pasien',NULL,NULL,'2026-01-05 17:00:00','2026-01-05 17:00:00'),(5,'Zaenab Melinda Hasanah S.E.','keluarga2@test.com',NULL,NULL,'$2y$12$RYnlEvL7mUCKU.SXIJmPDuXRZGM/mWzmhg3qfiH55BRpPRcCzWQMS','keluarga',NULL,NULL,'2026-07-06 00:52:34','2026-07-06 00:52:34'),(6,'Patricia Hastuti','pasien3@test.com',NULL,NULL,'$2y$12$C63u3MnoL8PzLzPQi5hMie.KDotosUJfz2dHYTzmAV4QuNCaBHk7m','pasien',NULL,NULL,'2026-03-05 17:00:00','2026-03-05 17:00:00'),(7,'Betania Tania Puspasari M.Farm','keluarga3@test.com',NULL,NULL,'$2y$12$aebu4/GD0RcGQAqr8Ym/ReU6YxthwSilcPS3Vdm0YcDfozL1xdxK6','keluarga',NULL,NULL,'2026-07-06 00:52:35','2026-07-06 00:52:35'),(8,'Ophelia Oliva Hasanah M.Ak','pasien4@test.com',NULL,NULL,'$2y$12$ynAuRTZEkFqUoaha.yLik.xxgJoIGRikftfZtiMPdEBfwLtB4w2ae','pasien',NULL,NULL,'2026-05-05 17:00:00','2026-05-05 17:00:00'),(9,'Baktianto Nashiruddin M.Kom.','keluarga4@test.com',NULL,NULL,'$2y$12$lzz9I7wkGkrhOfZQt1dBleHLbNUsymE7zueHDJfx1iMURJHkJTgGm','keluarga',NULL,NULL,'2026-07-06 00:52:35','2026-07-06 00:52:35'),(10,'Titi Halima Laksmiwati S.Sos','pasien5@test.com',NULL,NULL,'$2y$12$R8ovlVt3boV4gpMsXdn73e/KkMzXtH287hxqTsljcIGhBrv2f6APm','pasien',NULL,NULL,'2025-05-05 17:00:00','2025-05-05 17:00:00'),(11,'Tami Keisha Hariyah','keluarga5@test.com',NULL,NULL,'$2y$12$3jNRCNhCl6zZPPPKyJbyUeTfnTY5NCShiJrVUjQ7pky4YKFCQ.Mp.','keluarga',NULL,NULL,'2026-07-06 00:52:35','2026-07-06 00:52:35'),(12,'Dalima Nuraini','pasien6@test.com',NULL,NULL,'$2y$12$KBpz4tg9tJpb03iOzZ424eZQdFli12SR8OI/IACegGmO/Ibek9ai.','pasien',NULL,NULL,'2026-02-05 17:00:00','2026-02-05 17:00:00'),(13,'Lidya Padmasari','keluarga6@test.com',NULL,NULL,'$2y$12$ywIQQRymX09uwHpdwnLMm.11Q/8UukVkDtPWhkd2UVJ0TdL07UIdG','keluarga',NULL,NULL,'2026-07-06 00:52:36','2026-07-06 00:52:36'),(14,'Irma Widiastuti','pasien7@test.com',NULL,NULL,'$2y$12$z03U/QyFQlEx6iu3bjJJ2evH0TYttimfZcdI3gjRHQG2Z9GU3TrAS','pasien',NULL,NULL,'2026-04-05 17:00:00','2026-04-05 17:00:00'),(15,'Laras Agustina S.Kom','keluarga7@test.com',NULL,NULL,'$2y$12$n87wFpnrnXAjTb.J5KcZDekQdb0HhYi5Ug902IL06iCw92IZMubFq','keluarga',NULL,NULL,'2026-07-06 00:52:36','2026-07-06 00:52:36'),(16,'Muni Lulut Sitorus S.E.I','pasien8@test.com',NULL,NULL,'$2y$12$sRc3EabQoiyg6wtTdAtamOKBUbAFQoKujIo0nMCprJHxOYQ7GmD66','pasien',NULL,NULL,'2026-03-05 17:00:00','2026-03-05 17:00:00'),(17,'Parman Baktianto Firmansyah S.Gz','keluarga8@test.com',NULL,NULL,'$2y$12$P9JkUMcyfHz.qola7ur.e.QfKQ06LxeUrhWNz7QP6kNR.9YQzP8ua','keluarga',NULL,NULL,'2026-07-06 00:52:37','2026-07-06 00:52:37'),(18,'Michelle Kania Winarsih S.I.Kom','pasien9@test.com',NULL,NULL,'$2y$12$Ok55LNF14FnDJaivGPSss.TezynfLyrm4ym3lDbRGdeaqvpa1ABrG','pasien',NULL,NULL,'2025-12-05 17:00:00','2025-12-05 17:00:00'),(19,'Wirda Aryani','keluarga9@test.com',NULL,NULL,'$2y$12$.q4/NyKOjmoHvvUw3XaEKuVN0YrsEne1xgW1jhgUP/92Ai6iPqPay','keluarga',NULL,NULL,'2026-07-06 00:52:37','2026-07-06 00:52:37'),(20,'Kariman Kairav Hutapea','pasien10@test.com',NULL,NULL,'$2y$12$N7.budKEZhZBZzYXeXriqueVj7R5tt0Haqoj8jqoEjmSaPqeOAlbi','pasien',NULL,NULL,'2025-09-05 17:00:00','2025-09-05 17:00:00'),(21,'Kayla Anggraini','keluarga10@test.com',NULL,NULL,'$2y$12$9rTfgxmuPfbSyBft5PPJ7ufiy1nYB7RMV/XDFUIrGsBMZWZ0azxvK','keluarga',NULL,NULL,'2026-07-06 00:52:38','2026-07-06 00:52:38'),(22,'Tedi Megantara','pasien11@test.com',NULL,NULL,'$2y$12$sZ59QHqHi4Jo1IjZJtjGKegRz8OElRoEYf9mPPBdGvkqWG1D1dhLu','pasien',NULL,NULL,'2026-04-05 17:00:00','2026-04-05 17:00:00'),(23,'Taufik Jindra Simanjuntak M.Ak','keluarga11@test.com',NULL,NULL,'$2y$12$.0rmi0YRnW/wVv1AGxIPr.PB0/lvr75YPsU.w7QuPg7nM4aaNVNL.','keluarga',NULL,NULL,'2026-07-06 00:52:38','2026-07-06 00:52:38');
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

-- Dump completed on 2026-08-10 20:38:58
