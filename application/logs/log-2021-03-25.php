<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-03-25 08:07:54 --> 404 Page Not Found: Brand/index
ERROR - 2021-03-25 08:10:10 --> 404 Page Not Found: Brand/index
ERROR - 2021-03-25 08:11:37 --> 404 Page Not Found: Brand/index
ERROR - 2021-03-25 08:18:32 --> 404 Page Not Found: Brand/index
ERROR - 2021-03-25 08:27:56 --> 404 Page Not Found: Brand/index
ERROR - 2021-03-25 14:07:51 --> Severity: error --> Exception: Call to a member function get_store_info() on null F:\xampp\htdocs\tensix\application\controllers\Brand.php 30
ERROR - 2021-03-25 14:14:33 --> Severity: error --> Exception: Call to a member function get_store_info() on null F:\xampp\htdocs\tensix\application\controllers\Brand.php 30
ERROR - 2021-03-25 14:14:54 --> Severity: error --> Exception: Call to a member function get_store_info() on null F:\xampp\htdocs\tensix\application\controllers\Brand.php 30
ERROR - 2021-03-25 14:15:08 --> Severity: error --> Exception: Call to a member function get_store_info() on null F:\xampp\htdocs\tensix\application\controllers\Brand.php 30
ERROR - 2021-03-25 14:15:46 --> Query error: Table 'tensix.brand' doesn't exist - Invalid query: SELECT `brand`.*
FROM `brand` as `brand`
WHERE `brand`.`activation_status` = 1
AND  1 = 1 
ORDER BY `brand`.`brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 14:16:42 --> Query error: Table 'tensix.brand' doesn't exist - Invalid query: SELECT `brand`.*
FROM `brand` as `brand`
WHERE 1 = 1 
ORDER BY `brand`.`brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 14:16:55 --> Query error: Table 'tensix.brand' doesn't exist - Invalid query: SELECT *
FROM `brand` as `brand`
WHERE 1 = 1 
ORDER BY `brand`.`brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 14:17:09 --> Query error: Table 'tensix.brand' doesn't exist - Invalid query: SELECT *
FROM `brand`
WHERE 1 = 1 
ORDER BY `brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 10:30:40 --> 404 Page Not Found: Brand/add_brand
ERROR - 2021-03-25 15:44:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(`brand_name`) VALUES ('Denim')' at line 1 - Invalid query: INSERT INTO  (`brand_name`) VALUES ('Denim')
ERROR - 2021-03-25 15:46:35 --> Query error: Table 'tensix.brand' doesn't exist - Invalid query: INSERT INTO `brand` (`brand_name`) VALUES ('Denim')
ERROR - 2021-03-25 15:48:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(`brand_name`) VALUES ('Denim')' at line 1 - Invalid query: INSERT INTO  (`brand_name`) VALUES ('Denim')
ERROR - 2021-03-25 16:02:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '(`brand_name`) VALUES ('Denim')' at line 1 - Invalid query: INSERT INTO  (`brand_name`) VALUES ('Denim')
ERROR - 2021-03-25 17:33:23 --> Severity: error --> Exception: Call to a member function get_store_info_by_id() on null F:\xampp\htdocs\tensix\application\controllers\Brand.php 90
ERROR - 2021-03-25 12:39:05 --> 404 Page Not Found: Brand/edit_store
ERROR - 2021-03-25 17:57:45 --> Query error: Unknown column 'store.shop_name' in 'where clause' - Invalid query: SELECT *
FROM `tbl_brand`
WHERE `deletion_status` = 1
AND  1 = 1  and (`store`.`shop_name` LIKE "%deni%" or `store`.`shop_contact_number` LIKE "%deni%" or `store`.`email_id` LIKE "%deni%")
ORDER BY `brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 17:59:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY `brand_name` ASC
 LIMIT 10' at line 5 - Invalid query: SELECT *
FROM `tbl_brand`
WHERE `deletion_status` = 1
AND  1 = 1  and (`brand_name` LIKE "%deni%"
ORDER BY `brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 18:00:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY `brand_name` ASC
 LIMIT 10' at line 5 - Invalid query: SELECT *
FROM `tbl_brand`
WHERE `deletion_status` = 1
AND  1 = 1  and (`brand_name` LIKE "%deni%"
ORDER BY `brand_name` ASC
 LIMIT 10
ERROR - 2021-03-25 18:01:33 --> Severity: error --> Exception: syntax error, unexpected ')' F:\xampp\htdocs\tensix\application\models\admin_models\Brand_model.php 51
