<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-07 07:37:47 --> 404 Page Not Found: Admin_login/index
ERROR - 2021-10-07 11:57:13 --> Severity: error --> Exception: Call to undefined method CI_DB_mysqli_driver::innerjoin() G:\xamp\htdocs\jewellery\application\models\billing_model.php 32
ERROR - 2021-10-07 12:13:09 --> Query error: Table 'shreepra_jewellery.select tbl_payment' doesn't exist - Invalid query: SELECT `bill`.*, `trans`.*, `stock`.*, `payment`.`id` as `payment_id`, `payment`.`fine_receive` as `recive_fine`, `payment`.`jewellery_rate_diposit` as `d_jewellery_rate`, `payment`.`diposit_lbr_amount` as `d_lbr`
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN `SELECT tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP BY `trans`.`bill_id`
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:13:25 --> Query error: Table 'shreepra_jewellery.select from tbl_payment' doesn't exist - Invalid query: SELECT `bill`.*, `trans`.*, `stock`.*, `payment`.`id` as `payment_id`, `payment`.`fine_receive` as `recive_fine`, `payment`.`jewellery_rate_diposit` as `d_jewellery_rate`, `payment`.`diposit_lbr_amount` as `d_lbr`
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN `SELECT from tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP BY `trans`.`bill_id`
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:13:45 --> Query error: Table 'shreepra_jewellery.select * from tbl_payment' doesn't exist - Invalid query: SELECT `bill`.*, `trans`.*, `stock`.*, `payment`.`id` as `payment_id`, `payment`.`fine_receive` as `recive_fine`, `payment`.`jewellery_rate_diposit` as `d_jewellery_rate`, `payment`.`diposit_lbr_amount` as `d_lbr`
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN `SELECT * from tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP BY `trans`.`bill_id`
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:16:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP ...' at line 5 - Invalid query: SELECT `bill`.*, `trans`.*, `stock`.*, `payment`.`id` as `payment_id`, `payment`.`fine_receive` as `recive_fine`, `payment`.`jewellery_rate_diposit` as `d_jewellery_rate`, `payment`.`diposit_lbr_amount` as `d_lbr`
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN (SELECT * FROM tbl_payment as payment ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP BY `trans`.`bill_id`
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:18:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP ...' at line 5 - Invalid query: SELECT `bill`.*, `trans`.*, `stock`.*, `payment`.`id` as `payment_id`, `payment`.`fine_receive` as `recive_fine`, `payment`.`jewellery_rate_diposit` as `d_jewellery_rate`, `payment`.`diposit_lbr_amount` as `d_lbr`
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN (SELECT * FROM tbl_payment as payment) ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP BY `trans`.`bill_id`
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:32:13 --> Query error: Unknown table 'shreepra_jewellery.stock' - Invalid query: SELECT `bill`.*, `trans`.*, `stock`.*, `payment`.`id` as `payment_id`, `payment`.`fine_receive` as `recive_fine`, `payment`.`jewellery_rate_diposit` as `d_jewellery_rate`, `payment`.`diposit_lbr_amount` as `d_lbr`
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
INNER JOIN `tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
GROUP BY `trans`.`bill_id`
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:38:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`stock`.*
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `...' at line 1 - Invalid query: SELECT `bill`.*, `payment`.*.`stock`.*
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN `tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-07 12:40:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`stock`.*, `trans`.*
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `...' at line 1 - Invalid query: SELECT `bill`.*, `payment`.*.`stock`.*, `trans`.*
FROM `tbl_billing` as `bill`
JOIN `tbl_trans_bill` as `trans` ON `bill`.`id` = `trans`.`bill_id`
JOIN `tbl_stock` as `stock` ON `trans`.`stock_id` = `stock`.`id`
INNER JOIN `tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `bill`.`deletion_status` =0
ORDER BY `bill`.`id` DESC
