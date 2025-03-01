-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: clothing_store
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chitiethoadon`
--

DROP TABLE IF EXISTS `chitiethoadon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitiethoadon` (
  `chitiethoadon_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `soluong` int NOT NULL,
  `size` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mahoadon` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`chitiethoadon_id`),
  KEY `mahoadon` (`mahoadon`),
  KEY `masp` (`masp`),
  CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`mahoadon`) REFERENCES `hoadon` (`mahoadon`),
  CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitiethoadon`
--

LOCK TABLES `chitiethoadon` WRITE;
/*!40000 ALTER TABLE `chitiethoadon` DISABLE KEYS */;
/*!40000 ALTER TABLE `chitiethoadon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chitiethoatdong`
--

DROP TABLE IF EXISTS `chitiethoatdong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitiethoatdong` (
  `chitiethoatdong_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `thaydoi` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `thoigian` int NOT NULL,
  `ngay` date NOT NULL,
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `magiamgia_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `nhatki_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`chitiethoatdong_id`),
  KEY `masp` (`masp`),
  KEY `magiamgia_id` (`magiamgia_id`),
  KEY `nhatki_id` (`nhatki_id`),
  CONSTRAINT `chitiethoatdong_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`),
  CONSTRAINT `chitiethoatdong_ibfk_2` FOREIGN KEY (`magiamgia_id`) REFERENCES `magiamgia` (`magiamgia_id`),
  CONSTRAINT `chitiethoatdong_ibfk_3` FOREIGN KEY (`nhatki_id`) REFERENCES `nhatki` (`nhatki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitiethoatdong`
--

LOCK TABLES `chitiethoatdong` WRITE;
/*!40000 ALTER TABLE `chitiethoatdong` DISABLE KEYS */;
/*!40000 ALTER TABLE `chitiethoatdong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `danhsachyeuthich`
--

DROP TABLE IF EXISTS `danhsachyeuthich`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `danhsachyeuthich` (
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `matk` int NOT NULL,
  PRIMARY KEY (`masp`,`matk`),
  UNIQUE KEY `masp` (`masp`,`matk`),
  KEY `matk` (`matk`),
  CONSTRAINT `danhsachyeuthich_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`),
  CONSTRAINT `danhsachyeuthich_ibfk_2` FOREIGN KEY (`matk`) REFERENCES `taikhoan` (`matk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `danhsachyeuthich`
--

LOCK TABLES `danhsachyeuthich` WRITE;
/*!40000 ALTER TABLE `danhsachyeuthich` DISABLE KEYS */;
/*!40000 ALTER TABLE `danhsachyeuthich` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hanhdong`
--

DROP TABLE IF EXISTS `hanhdong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hanhdong` (
  `hanhdong_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tenhanhdong` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`hanhdong_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hanhdong`
--

LOCK TABLES `hanhdong` WRITE;
/*!40000 ALTER TABLE `hanhdong` DISABLE KEYS */;
/*!40000 ALTER TABLE `hanhdong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hinhanh`
--

DROP TABLE IF EXISTS `hinhanh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hinhanh` (
  `mahinhanh` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tenmau` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mau_id` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`mahinhanh`),
  KEY `masp` (`masp`),
  KEY `mau_id` (`mau_id`),
  CONSTRAINT `hinhanh_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`),
  CONSTRAINT `hinhanh_ibfk_2` FOREIGN KEY (`mau_id`) REFERENCES `mau` (`mau_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hinhanh`
--

LOCK TABLES `hinhanh` WRITE;
/*!40000 ALTER TABLE `hinhanh` DISABLE KEYS */;
/*!40000 ALTER TABLE `hinhanh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hoadon`
--

DROP TABLE IF EXISTS `hoadon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoadon` (
  `mahoadon` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ngay` date NOT NULL,
  `diemtichluydasudung` int NOT NULL,
  `tongtien` int NOT NULL,
  `mahk` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `magiamgia_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`mahoadon`),
  KEY `mahk` (`mahk`),
  KEY `magiamgia_id` (`magiamgia_id`),
  CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`mahk`) REFERENCES `khachhang` (`mahk`),
  CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`magiamgia_id`) REFERENCES `magiamgia` (`magiamgia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoadon`
--

LOCK TABLES `hoadon` WRITE;
/*!40000 ALTER TABLE `hoadon` DISABLE KEYS */;
/*!40000 ALTER TABLE `hoadon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khachhang` (
  `mahk` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `hoten` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `sdt` int NOT NULL,
  `email` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `diachi` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`mahk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khachhang`
--

LOCK TABLES `khachhang` WRITE;
/*!40000 ALTER TABLE `khachhang` DISABLE KEYS */;
/*!40000 ALTER TABLE `khachhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kichco`
--

DROP TABLE IF EXISTS `kichco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kichco` (
  `kichco_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tenkichco` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `soluong` int NOT NULL,
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mau_id` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`kichco_id`),
  KEY `masp` (`masp`),
  KEY `mau_id` (`mau_id`),
  CONSTRAINT `kichco_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`),
  CONSTRAINT `kichco_ibfk_2` FOREIGN KEY (`mau_id`) REFERENCES `mau` (`mau_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kichco`
--

LOCK TABLES `kichco` WRITE;
/*!40000 ALTER TABLE `kichco` DISABLE KEYS */;
/*!40000 ALTER TABLE `kichco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loaisanpham`
--

DROP TABLE IF EXISTS `loaisanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loaisanpham` (
  `maloai` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tenloai` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`maloai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loaisanpham`
--

LOCK TABLES `loaisanpham` WRITE;
/*!40000 ALTER TABLE `loaisanpham` DISABLE KEYS */;
/*!40000 ALTER TABLE `loaisanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `magiamgia`
--

DROP TABLE IF EXISTS `magiamgia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `magiamgia` (
  `magiamgia_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tenma` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `soluong` int NOT NULL,
  `codegiamgia` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tiengiam` int NOT NULL,
  PRIMARY KEY (`magiamgia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magiamgia`
--

LOCK TABLES `magiamgia` WRITE;
/*!40000 ALTER TABLE `magiamgia` DISABLE KEYS */;
/*!40000 ALTER TABLE `magiamgia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mau`
--

DROP TABLE IF EXISTS `mau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mau` (
  `mau_id` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tenmau` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`mau_id`),
  KEY `masp` (`masp`),
  CONSTRAINT `mau_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mau`
--

LOCK TABLES `mau` WRITE;
/*!40000 ALTER TABLE `mau` DISABLE KEYS */;
/*!40000 ALTER TABLE `mau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhatki`
--

DROP TABLE IF EXISTS `nhatki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nhatki` (
  `nhatki_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ngay` date NOT NULL,
  `thoigian` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `hanhdong_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`nhatki_id`),
  KEY `hanhdong_id` (`hanhdong_id`),
  CONSTRAINT `nhatki_ibfk_1` FOREIGN KEY (`hanhdong_id`) REFERENCES `hanhdong` (`hanhdong_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhatki`
--

LOCK TABLES `nhatki` WRITE;
/*!40000 ALTER TABLE `nhatki` DISABLE KEYS */;
/*!40000 ALTER TABLE `nhatki` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sanpham` (
  `masp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tensp` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `gia` int NOT NULL,
  `mota` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `chitietsanpham` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `giamgia` int NOT NULL,
  `maloai` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `matinhtrang` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`masp`),
  KEY `maloai` (`maloai`),
  KEY `matinhtrang` (`matinhtrang`),
  CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maloai`) REFERENCES `loaisanpham` (`maloai`),
  CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`matinhtrang`) REFERENCES `tinhtrang` (`matinhtrang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanpham`
--

LOCK TABLES `sanpham` WRITE;
/*!40000 ALTER TABLE `sanpham` DISABLE KEYS */;
/*!40000 ALTER TABLE `sanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taikhoan` (
  `matk` int NOT NULL,
  `tentaikhoan` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `matkhau` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `diemtichluy` int NOT NULL,
  `mahk` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`matk`),
  UNIQUE KEY `tentaikhoan` (`tentaikhoan`),
  KEY `mahk` (`mahk`),
  CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`mahk`) REFERENCES `khachhang` (`mahk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taikhoan`
--

LOCK TABLES `taikhoan` WRITE;
/*!40000 ALTER TABLE `taikhoan` DISABLE KEYS */;
/*!40000 ALTER TABLE `taikhoan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tinhtrang`
--

DROP TABLE IF EXISTS `tinhtrang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tinhtrang` (
  `matinhtrang` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ten` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`matinhtrang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tinhtrang`
--

LOCK TABLES `tinhtrang` WRITE;
/*!40000 ALTER TABLE `tinhtrang` DISABLE KEYS */;
/*!40000 ALTER TABLE `tinhtrang` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-01 11:49:07
