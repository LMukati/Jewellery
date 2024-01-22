<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-04-07 18:15:15 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) F:\xampp\htdocs\tensix\application\models\ApiData_model.php 965
ERROR - 2021-04-07 18:16:04 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) F:\xampp\htdocs\tensix\application\models\ApiData_model.php 965
ERROR - 2021-04-07 18:16:24 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT `product`.*, (stock_qty-sum(item_qty)) as new_qty
FROM `dir_product` as `product`
LEFT JOIN `tbl_order_detail` ON `product`.`product_id` = `tbl_order_detail`.`id`
LEFT JOIN `tbl_order_master` ON `tbl_order_master`.`id` = `tbl_order_detail`.`order_id` and `tbl_order_master`.`is_cancel` =0
WHERE `product`.`product_id` != '8'
AND `product`.`product_category` = `Array`
AND `product`.`publication_status` = 1
AND `product`.`deletion_status` =0
GROUP BY `product`.`product_id`
ORDER BY `product`.`product_id` DESC
 LIMIT 4
ERROR - 2021-04-07 18:17:36 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT `product`.*, (stock_qty-sum(item_qty)) as new_qty
FROM `dir_product` as `product`
LEFT JOIN `tbl_order_detail` ON `product`.`product_id` = `tbl_order_detail`.`id`
LEFT JOIN `tbl_order_master` ON `tbl_order_master`.`id` = `tbl_order_detail`.`order_id` and `tbl_order_master`.`is_cancel` =0
WHERE `product`.`product_id` != '8'
AND `product`.`product_category` = `Array`
AND `product`.`publication_status` = 1
AND `product`.`deletion_status` =0
GROUP BY `product`.`product_id`
ORDER BY `product`.`product_id` DESC
 LIMIT 4
