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
-- Table structure for table `chitietsanpham`
--

DROP TABLE IF EXISTS `chitietsanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitietsanpham` (
  `masp_id` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `chitiet` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `masp_id` (`masp_id`),
  CONSTRAINT `chitietsanpham_ibfk_1` FOREIGN KEY (`masp_id`) REFERENCES `sanpham` (`masp`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitietsanpham`
--

LOCK TABLES `chitietsanpham` WRITE;
/*!40000 ALTER TABLE `chitietsanpham` DISABLE KEYS */;
INSERT INTO `chitietsanpham` VALUES ('100','Chất liệu: Cotton 2 chiều.',1),('100','Regular Fit.',2),('100','Hình in mặt trước áo áp dụng công nghệ in lụa.',3),('102','Colour Shown: Vivid Purple/Black/Hot Punch',4),('102','Style: FQ7262-500',5),('102','Country/Region of Origin: Vietnam',6);
/*!40000 ALTER TABLE `chitietsanpham` ENABLE KEYS */;
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
  `duongdananh` varchar(300) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mau_sanpham_id` int DEFAULT NULL,
  PRIMARY KEY (`mahinhanh`),
  KEY `fk_maucuasanpham` (`mau_sanpham_id`),
  CONSTRAINT `fk_maucuasanpham` FOREIGN KEY (`mau_sanpham_id`) REFERENCES `mausanpham` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hinhanh`
--

LOCK TABLES `hinhanh` WRITE;
/*!40000 ALTER TABLE `hinhanh` DISABLE KEYS */;
INSERT INTO `hinhanh` VALUES ('1','/public/assets/images/anh/giay/nike/Nike Pegasus 41/grey/AIR+ZOOM+PEGASUS+41 (1).png',3),('2','/public/assets/images/anh/giay/nike/Nike Pegasus 41/grey/AIR+ZOOM+PEGASUS+41 (2).png',3),('3','/public/assets/images/anh/giay/nike/Nike Pegasus 41/grey/AIR+ZOOM+PEGASUS+41 (3).png',3),('4','/public/assets/images/anh/giay/nike/Nike Pegasus 41/grey/AIR+ZOOM+PEGASUS+41.png',3),('5','/public/assets/images/anh/ao/hanoilover/image.png',1),('6','/public/assets/images/anh/quan/MetalWildLabelTrouserPants/image.png',2);
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
  CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`mahk`) REFERENCES `khachhang` (`makh`),
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
  `kichco_id` int NOT NULL,
  `tenkichco` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `soluong` int NOT NULL,
  `mau_sanpham_id` int DEFAULT NULL,
  PRIMARY KEY (`kichco_id`),
  KEY `fk_id_maucuasanpham` (`mau_sanpham_id`),
  CONSTRAINT `fk_id_maucuasanpham` FOREIGN KEY (`mau_sanpham_id`) REFERENCES `mausanpham` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kichco`
--

LOCK TABLES `kichco` WRITE;
/*!40000 ALTER TABLE `kichco` DISABLE KEYS */;
INSERT INTO `kichco` VALUES (1,'26',10,1),(2,'28',10,1),(3,'30',10,1),(4,'32',0,1),(5,'34',3,1),(6,'S',2,2),(7,'M',4,2),(8,'L',5,2),(9,'XL',10,2),(10,'XXL',0,2),(11,'40',5,3),(12,'41',23,3),(13,'42',0,3),(14,'43',6,3),(15,'44',3,3),(16,'40',2,4),(17,'41',3,4),(18,'42',4,4),(19,'43',1,4),(20,'44',5,4);
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
  `mamau` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mau_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mau`
--

LOCK TABLES `mau` WRITE;
/*!40000 ALTER TABLE `mau` DISABLE KEYS */;
INSERT INTO `mau` VALUES ('0','#5F9EA0'),('1','#6A5ACD'),('2','#708090');
/*!40000 ALTER TABLE `mau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mausanpham`
--

DROP TABLE IF EXISTS `mausanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mausanpham` (
  `id` int NOT NULL,
  `masp_id` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mau_id` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mau_id` (`mau_id`),
  KEY `maucuasanpham_ibfk_1` (`masp_id`),
  CONSTRAINT `maucuasanpham_ibfk_1` FOREIGN KEY (`masp_id`) REFERENCES `sanpham` (`masp`),
  CONSTRAINT `mausanpham_ibfk_2` FOREIGN KEY (`mau_id`) REFERENCES `mau` (`mau_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mausanpham`
--

LOCK TABLES `mausanpham` WRITE;
/*!40000 ALTER TABLE `mausanpham` DISABLE KEYS */;
INSERT INTO `mausanpham` VALUES (1,'100','0'),(2,'101','0'),(3,'102','1'),(4,'102','2');
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
  `matinhtrang` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`masp`),
  KEY `matinhtrang` (`matinhtrang`),
  KEY `sanpham_ibfk_1` (`maloai_id`),
  CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maloai_id`) REFERENCES `loaisanpham` (`maloai`),
  CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`matinhtrang`) REFERENCES `tinhtrang` (`matinhtrang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanpham`
--

LOCK TABLES `sanpham` WRITE;
/*!40000 ALTER TABLE `sanpham` DISABLE KEYS */;
INSERT INTO `sanpham` VALUES ('100','Áo thun  Hà Nội Lover Green ',400000,NULL,0,'0','1'),('101','Metal Label Wide Trouser Pants - Brown',590000,NULL,0,'1','2'),('102','Nike Pegasus 41',3829000,'Responsive cushioning in the Pegasus provides an energised ride for everyday road running. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole. Plus, improved engineered mesh on the upper decreases weight and increases breathability.',100000,'2','0');
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
INSERT INTO `tinhtrang` VALUES ('0','CÒN HÀNG'),('1','SẮP HẾT HÀNG'),('2','HẾT HÀNG');
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

-- Dump completed on 2025-03-12 18:06:42
