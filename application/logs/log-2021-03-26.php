<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-03-26 05:58:30 --> Unable to connect to the database
ERROR - 2021-03-26 05:58:43 --> Unable to connect to the database
ERROR - 2021-03-26 10:59:56 --> Severity: error --> Exception: Call to undefined method Banner_model::get_banner_count() F:\xampp\htdocs\tensix\application\controllers\Banner.php 31
ERROR - 2021-03-26 11:01:41 --> Severity: error --> Exception: Call to undefined method Banner_model::get_banner_count() F:\xampp\htdocs\tensix\application\controllers\Banner.php 31
ERROR - 2021-03-26 11:05:03 --> Query error: Unknown column 'brand_name' in 'order clause' - Invalid query: SELECT *
FROM `tbl_banner`
ORDER BY `brand_name` ASC
ERROR - 2021-03-26 06:08:56 --> 404 Page Not Found: Banner/add_banner
ERROR - 2021-03-26 12:09:42 --> Severity: error --> Exception: syntax error, unexpected '}', expecting end of file F:\xampp\htdocs\tensix\application\views\admin_views\banner\add_banner_v.php 44
ERROR - 2021-03-26 13:10:54 --> Query error: Unknown column 'Array' in 'field list' - Invalid query: INSERT INTO `tbl_banner` (`m_category_id`, `brand_id`, `category_id`, `create_date`, `deletion_status`) VALUES ('1', '4', Array, '2021-03-26 01:10:54', 1)
ERROR - 2021-03-26 13:11:22 --> Query error: Unknown column 'Array' in 'field list' - Invalid query: INSERT INTO `tbl_banner` (`m_category_id`, `brand_id`, `category_id`, `create_date`, `deletion_status`) VALUES ('1', '4', Array, '2021-03-26 01:11:22', 1)
ERROR - 2021-03-26 14:32:45 --> Query error: Column 'category_id' cannot be null - Invalid query: INSERT INTO `tbl_banner` (`m_category_id`, `brand_id`, `category_id`, `create_date`, `deletion_status`) VALUES ('1', '1', NULL, '2021-03-26 02:32:45', 1)
ERROR - 2021-03-26 14:33:34 --> Query error: Column 'category_id' cannot be null - Invalid query: INSERT INTO `tbl_banner` (`m_category_id`, `brand_id`, `category_id`, `create_date`, `deletion_status`) VALUES ('2', '4', NULL, '2021-03-26 02:33:34', 1)
ERROR - 2021-03-26 15:00:55 --> Query error: Unknown column 'brand_name' in 'order clause' - Invalid query: SELECT *
FROM `tbl_banner`
WHERE `deletion_status` = 1
AND  1 = 1 
ORDER BY `brand_name` ASC
 LIMIT 10
ERROR - 2021-03-26 15:09:15 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) F:\xampp\htdocs\tensix\application\models\admin_models\Banner_model.php 29
ERROR - 2021-03-26 15:10:37 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) F:\xampp\htdocs\tensix\application\models\admin_models\Banner_model.php 29
ERROR - 2021-03-26 15:12:46 --> Query error: Unknown column 'brand.m_category_id' in 'on clause' - Invalid query: SELECT `brand`.*, `main`.`name` as `maincategoryname`
FROM `tbl_brand` `brand`
LEFT JOIN `tbl_main_category` as `main` ON `main`.`id` = `brand`.`m_category_id`
WHERE `deletion_status` = 1
AND  1 = 1 
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-03-26 15:14:06 --> Query error: Unknown column 'brand.m_category_id' in 'field list' - Invalid query: SELECT `brand`.`m_category_id`, `main`.`name` as `maincategoryname`
FROM `tbl_brand` `brand`
LEFT JOIN `tbl_main_category` as `main` ON `main`.`id` = `brand`.`m_category_id`
WHERE `deletion_status` = 1
AND  1 = 1 
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-03-26 15:17:48 --> Query error: Column 'deletion_status' in where clause is ambiguous - Invalid query: SELECT `banner`.*, `main`.`name` as `maincategoryname`
FROM `tbl_banner` `banner`
LEFT JOIN `tbl_main_category` as `main` ON `main`.`id` = `banner`.`m_category_id`
LEFT JOIN `tbl_brand` as `brand` ON `brand`.`id` = `banner`.`brand_id`
WHERE `deletion_status` = 1
AND  1 = 1 
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-03-26 15:22:00 --> Severity: error --> Exception: syntax error, unexpected 's' (T_STRING) F:\xampp\htdocs\tensix\application\models\admin_models\Banner_model.php 56
ERROR - 2021-03-26 15:22:49 --> Severity: error --> Exception: syntax error, unexpected ',' F:\xampp\htdocs\tensix\application\models\admin_models\Banner_model.php 56
ERROR - 2021-03-26 15:24:20 --> Query error: Unknown column 'main.name' in 'field list' - Invalid query: SELECT `banner`.*, `main`.`name` as `maincategoryname`
FROM `tbl_banner` `banner`
LEFT JOIN `tbl_brand` as `brand` ON `brand`.`id` = `banner`.`brand_id`
WHERE `banner`.`deletion_status` = 1
AND  1 = 1 
ORDER BY `banner`.`id` DESC
 LIMIT 10
ERROR - 2021-03-26 15:33:47 --> Severity: error --> Exception: syntax error, unexpected 'else' (T_ELSE) F:\xampp\htdocs\tensix\application\views\admin_views\banner\manage_banner_v.php 121
ERROR - 2021-03-26 11:24:11 --> 404 Page Not Found: Banner_images/1616754246-61hMQOHmEIL._UY625_.jpg
ERROR - 2021-03-26 11:25:03 --> 404 Page Not Found: Banner_images/1616754246-61hMQOHmEIL._UY625_.jpg
ERROR - 2021-03-26 11:25:21 --> 404 Page Not Found: Banner_images/1616754246-61hMQOHmEIL._UY625_.jpg
ERROR - 2021-03-26 16:45:35 --> Severity: error --> Exception: syntax error, unexpected '$query_result' (T_VARIABLE) F:\xampp\htdocs\tensix\application\models\admin_models\Banner_model.php 135
ERROR - 2021-03-26 11:57:04 --> 404 Page Not Found: Banner_images/1616756221-3
ERROR - 2021-03-26 11:58:45 --> 404 Page Not Found: Banner_images/1616756221-3
ERROR - 2021-03-26 11:59:07 --> 404 Page Not Found: Banner_images/1616756345
ERROR - 2021-03-26 11:59:07 --> 404 Page Not Found: Banner_images/1616756221-3
ERROR - 2021-03-26 17:22:02 --> Severity: error --> Exception: Call to a member function get_main_category_info() on null F:\xampp\htdocs\tensix\application\controllers\Categories.php 74
