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
  `masp` int DEFAULT NULL,
  PRIMARY KEY (`chitiethoadon_id`),
  KEY `mahoadon` (`mahoadon`),
  KEY `chitiethoadon_ibfk_2` (`masp`),
  CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`mahoadon`) REFERENCES `hoadon` (`mahoadon`),
  CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`id`)
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
  `masp` int DEFAULT NULL,
  `id` int DEFAULT NULL,
  `nhatki_id` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`chitiethoatdong_id`),
  KEY `nhatki_id` (`nhatki_id`),
  KEY `chitiethoatdong_ibfk_2` (`id`),
  KEY `chitiethoatdong_ibfk_1` (`masp`),
  CONSTRAINT `chitiethoatdong_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`id`),
  CONSTRAINT `chitiethoatdong_ibfk_2` FOREIGN KEY (`id`) REFERENCES `magiamgia` (`id`),
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
-- Table structure for table `chitietsanpham`
--

DROP TABLE IF EXISTS `chitietsanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitietsanpham` (
  `masp_id` int DEFAULT NULL,
  `chitiet` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `chitietsanpham_ibfk_1` (`masp_id`),
  CONSTRAINT `chitietsanpham_ibfk_1` FOREIGN KEY (`masp_id`) REFERENCES `sanpham` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitietsanpham`
--

LOCK TABLES `chitietsanpham` WRITE;
/*!40000 ALTER TABLE `chitietsanpham` DISABLE KEYS */;
INSERT INTO `chitietsanpham` VALUES (1,'Chất liệu: Cotton 2 chiều.',1),(1,'Regular Fit.',2),(1,'Hình in mặt trước áo áp dụng công nghệ in lụa.',3),(3,'Colour Shown: Vivid Purple/Black/Hot Punch',4),(3,'Style: FQ7262-500',5),(3,'Country/Region of Origin: Vietnam',6),(2,'ư',50),(3,'ư',51),(3,'ư',52);
/*!40000 ALTER TABLE `chitietsanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `danhsachyeuthich`
--

DROP TABLE IF EXISTS `danhsachyeuthich`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `danhsachyeuthich` (
  `masp` int NOT NULL,
  `matk` int NOT NULL,
  PRIMARY KEY (`masp`,`matk`),
  UNIQUE KEY `masp` (`masp`,`matk`),
  KEY `matk` (`matk`),
  CONSTRAINT `danhsachyeuthich_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`id`),
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
  `mahinhanh` int NOT NULL AUTO_INCREMENT,
  `duongdananh` varchar(300) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mau_sanpham_id` int DEFAULT NULL,
  PRIMARY KEY (`mahinhanh`),
  KEY `mausanpham_ibfk_id` (`mau_sanpham_id`),
  CONSTRAINT `mausanpham_ibfk_id` FOREIGN KEY (`mau_sanpham_id`) REFERENCES `mausanpham` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hinhanh`
--

LOCK TABLES `hinhanh` WRITE;
/*!40000 ALTER TABLE `hinhanh` DISABLE KEYS */;
INSERT INTO `hinhanh` VALUES (1,'http://localhost/ClothingStore/public/assets/images/anh/giay/nike/Nike Pegasus 41/grey/AIR+ZOOM+PEGASUS+41 (1).png',3),(2,'http://localhost/ClothingStore/public/assets/images/anh/ao/hanoilover/image.png',1),(3,'http://localhost/ClothingStore/public/assets/images/anh/quan/MetalWildLabelTrouserPants/image.png',2),(4,'http://localhost/ClothingStore/public/assets/images/anh/giay/nike/Nike Pegasus 41/purple/AIR+ZOOM+PEGASUS+41 (1).jpg',4),(8,'abcs',1),(10,'http://localhost/ClothingStore/public/uploads/482074402_1155262886388631_7608195704829811394_n.jpg',3);
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
  `id` int DEFAULT NULL,
  PRIMARY KEY (`mahoadon`),
  KEY `mahk` (`mahk`),
  KEY `hoadon_ibfk_2` (`id`),
  CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`mahk`) REFERENCES `khachhang` (`makh`),
  CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`id`) REFERENCES `magiamgia` (`id`)
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
  `makh` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `hoten` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `sdt` int NOT NULL,
  `email` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `diachi` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`makh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khachhang`
--

LOCK TABLES `khachhang` WRITE;
/*!40000 ALTER TABLE `khachhang` DISABLE KEYS */;
INSERT INTO `khachhang` VALUES ('1','Dương Văn Minh',808800808,'abc@gmail.com','41/1 Đường A Phường 4 Quận7'),('10','Trịnh Thị Mai',111111111,'mai@gmail.com','44/1 Đường J Phường 10 Quận 2'),('11','Phan Văn Khoa',222222222,'khoa@gmail.com','33/8 Đường K Phường 11 Quận 12'),('12','Dương Văn Minh',808800808,'abc@gmail.com','41/1 Đường A Phường 4 Quận 7'),('2','Nguyễn Thị Lan',909090909,'lan@gmail.com','52/2 Đường B Phường 5 Quận 3'),('3','Trần Văn Sơn',707070707,'son@gmail.com','123/9 Đường C Phường 6 Quận 1'),('4','Phạm Thị Hoa',606060606,'hoa@gmail.com','34/8 Đường D Phường 2 Quận 5'),('5','Lê Văn Tâm',505050505,'tam@gmail.com','11/3 Đường E Phường 3 Quận 10'),('6','Bùi Thị Cúc',404040404,'cuc@gmail.com','87/6 Đường F Phường 9 Quận 8'),('7','Đỗ Văn Lực',303030303,'luc@gmail.com','19/7 Đường G Phường 1 Quận 4'),('8','Vũ Thị Hương',202020202,'huong@gmail.com','99/4 Đường H Phường 7 Quận 11'),('9','Hoàng Văn Long',101010101,'long@gmail.com','76/9 Đường I Phường 8 Quận 6');
/*!40000 ALTER TABLE `khachhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kichco`
--

DROP TABLE IF EXISTS `kichco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kichco` (
  `kichco_id` int NOT NULL AUTO_INCREMENT,
  `tenkichco` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `soluong` int NOT NULL,
  `mau_sanpham_id` int DEFAULT NULL,
  PRIMARY KEY (`kichco_id`),
  KEY `fk_id_maucuasanpham` (`mau_sanpham_id`),
  CONSTRAINT `fk_id_maucuasanpham` FOREIGN KEY (`mau_sanpham_id`) REFERENCES `mausanpham` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kichco`
--

LOCK TABLES `kichco` WRITE;
/*!40000 ALTER TABLE `kichco` DISABLE KEYS */;
INSERT INTO `kichco` VALUES (1,'26',10,1),(2,'28',10,1),(3,'30',10,1),(4,'32',0,1),(5,'34',3,1),(6,'S',2,2),(7,'M',4,2),(8,'L',5,2),(9,'XL',10,2),(10,'XXL',0,2),(11,'40',5,3),(12,'41',23,3),(13,'42',0,3),(14,'43',6,3),(15,'44',3,3),(16,'40',2,4),(17,'41',3,4),(18,'42',4,4),(19,'43',1,4),(20,'44',5,4),(26,'40',4,7),(27,'41',20,7),(28,'42',5,7),(29,'43',5,7),(30,'44',50,7),(31,'40',5,8);
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
INSERT INTO `loaisanpham` VALUES ('0','Áo'),('1','Quần'),('2','Giày'),('3','Kính');
/*!40000 ALTER TABLE `loaisanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `magiamgia`
--

DROP TABLE IF EXISTS `magiamgia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `magiamgia` (
 
  `tenma` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `soluong` int NOT NULL,
  `codegiamgia` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
 
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
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
  `mamau` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mau`
--

LOCK TABLES `mau` WRITE;
/*!40000 ALTER TABLE `mau` DISABLE KEYS */;
INSERT INTO `mau` VALUES ('5F9EA0',0),('6A5ACD',1),('708090',2),('471515',4),('4c1010',5),('6d3131',6),('dcab56',7),('1e9970',8),('9c2b2b',9),('602929',10),('632727',11),('a33333',12),('702929',13),('983434',14),('2f1313',15),('5f261c',16),('8d3a3a',17),('691717',18),('6b2929',19),('8a2424',20);
/*!40000 ALTER TABLE `mau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mausanpham`
--

DROP TABLE IF EXISTS `mausanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mausanpham` (
  `masp_id` int DEFAULT NULL,
  `mau_id` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `mausanpham_ibfk_1` (`masp_id`),
  KEY `mausanpham_ibfk_2` (`mau_id`),
  CONSTRAINT `mausanpham_ibfk_1` FOREIGN KEY (`masp_id`) REFERENCES `sanpham` (`id`),
  CONSTRAINT `mausanpham_ibfk_2` FOREIGN KEY (`mau_id`) REFERENCES `mau` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mausanpham`
--

LOCK TABLES `mausanpham` WRITE;
/*!40000 ALTER TABLE `mausanpham` DISABLE KEYS */;
INSERT INTO `mausanpham` VALUES (1,0,1),(2,0,2),(3,1,3),(3,2,4),(3,17,5),(3,18,6),(3,19,7),(3,20,8);
/*!40000 ALTER TABLE `mausanpham` ENABLE KEYS */;
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
  `mota` varchar(5000) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `giamgia` int NOT NULL,
  `maloai_id` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `matinhtrang` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `nsx` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matinhtrang` (`matinhtrang`),
  KEY `sanpham_ibfk_1` (`maloai_id`),
  CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maloai_id`) REFERENCES `loaisanpham` (`maloai`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanpham`
--

LOCK TABLES `sanpham` WRITE;
/*!40000 ALTER TABLE `sanpham` DISABLE KEYS */;
INSERT INTO `sanpham` VALUES ('100','Áo thun  Hà Nội Lover Green ',400000,'Abc, xyz',0,'0',0,1,NULL),('101','Metal Label Wide Trouser Pants - Brown',590000,'null',0,'1',1,2,NULL),('102','Nike Pegasus 41',590000,'null',100000,'2',0,3,'Nike');
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
  `makh` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`matk`),
  UNIQUE KEY `tentaikhoan` (`tentaikhoan`),
  KEY `mahk` (`makh`),
  CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`makh`) REFERENCES `khachhang` (`makh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taikhoan`
--

LOCK TABLES `taikhoan` WRITE;
/*!40000 ALTER TABLE `taikhoan` DISABLE KEYS */;
INSERT INTO `taikhoan` VALUES (1,'duongminh','123456',100,'1'),(2,'nguyenlan','abcdef',200,'2'),(3,'tranvan','qwerty',150,'3'),(4,'phamhoa','password',120,'4'),(5,'levantam','letmein',180,'5');
/*!40000 ALTER TABLE `taikhoan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-17 23:09:50
