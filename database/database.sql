-- --------------------------------------------------------
-- Servidor:                     31.220.48.42
-- Versão do servidor:           5.7.36-0ubuntu0.18.04.1 - (Ubuntu)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- USE jn2test;
-- Copiando estrutura para tabela jn2-test.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `license_plate` varchar(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela jn2-test.clients: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`client_id`, `name`, `phone`, `cpf`, `license_plate`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'Clark Kent da Silva', '31900000001', '51531304010', 'AAA-0002', 2, '2021-11-02 10:54:36', '2021-11-02 12:20:56'),
	(5, 'Bruce Wayne', '31900000000', '51531304010', 'AAA-0002', 1, '2021-11-02 12:16:47', NULL),
	(6, 'Barry Allen', '31900000003', '05889373048', 'AAA-0003', 1, '2021-11-02 12:19:46', NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Copiando estrutura para tabela jn2-test.users_api
CREATE TABLE IF NOT EXISTS `users_api` (
  `user_api_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_api_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela jn2-test.users_api: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users_api` DISABLE KEYS */;
INSERT INTO `users_api` (`user_api_id`, `name`, `email`, `api_key`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'JN2', 'teste@teste.com', 'c3066987c638f5b4ad6d1cf4d940641b61bd7e46', 1, '2021-11-02 11:42:42', NULL);
/*!40000 ALTER TABLE `users_api` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
