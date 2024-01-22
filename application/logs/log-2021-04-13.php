<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-04-13 12:00:46 --> Query error: Unknown column 'item_qty' in 'field list' - Invalid query: SELECT `product`.*, `wishlist`.*, (stock_qty-sum(item_qty)) as new_qty
FROM `tbl_wishlist` as `wishlist`
LEFT JOIN `dir_product` as `product` ON `product`.`product_id` = `tbl_wishlist`.`product_id`
WHERE `wishlist`.`deletion_status` =0
AND `product`.`product_category` != ''
AND `product`.`publication_status` = 1
AND `product`.`deletion_status` =0
AND `wishlist`.`user_id` = 1
GROUP BY `wishlist`.`product_id`
ORDER BY `product`.`product_id`
 LIMIT 10
ERROR - 2021-04-13 12:01:23 --> Query error: Unknown column 'tbl_wishlist.product_id' in 'on clause' - Invalid query: SELECT `product`.*, `wishlist`.*
FROM `tbl_wishlist` as `wishlist`
LEFT JOIN `dir_product` as `product` ON `product`.`product_id` = `tbl_wishlist`.`product_id`
WHERE `wishlist`.`deletion_status` =0
AND `product`.`product_category` != ''
AND `product`.`publication_status` = 1
AND `product`.`deletion_status` =0
AND `wishlist`.`user_id` = 1
GROUP BY `wishlist`.`product_id`
ORDER BY `product`.`product_id`
 LIMIT 10
ERROR - 2021-04-13 08:46:17 --> Severity: error --> Exception: syntax error, unexpected '$search' (T_VARIABLE) F:\xampp\htdocs\tensix\application\controllers\ApiData.php 1148
