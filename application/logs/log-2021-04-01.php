<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-04-01 11:44:34 --> Severity: error --> Exception: Call to a member function get_brand_info() on null F:\xampp\htdocs\tensix\application\controllers\Advertisement.php 42
ERROR - 2021-04-01 11:50:36 --> Query error: Unknown column 'tbl_advertisement.shop_id' in 'on clause' - Invalid query: SELECT `tbl_advertisement`.*, `tbl_marchent`.`shop_name` as `store_name`
FROM `tbl_advertisement`
LEFT JOIN `tbl_marchent` ON `tbl_marchent`.`id` = `tbl_advertisement`.`shop_id`
WHERE 1 = 1 
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-04-01 13:00:37 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) F:\xampp\htdocs\tensix\application\models\ApiData_model.php 751
ERROR - 2021-04-01 13:19:37 --> Query error: Column 'id' in order clause is ambiguous - Invalid query: SELECT `tbl_advertisement`.*, `tbl_brand`.`id` as `id`, `tbl_brand`.`brand_name` as `brand_name`
FROM `tbl_advertisement`
LEFT JOIN `tbl_brand` ON `tbl_brand`.`id` = `tbl_advertisement`.`brand_id`
WHERE `isActive` = 1
AND date_format(now(),'%Y-%m-%d') between date_format(start_date,'%Y-%m-%d') and date_format(end_date,'%Y-%m-%d')
ORDER BY `id` DESC
