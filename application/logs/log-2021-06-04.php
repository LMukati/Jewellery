<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-06-04 12:44:30 --> Query error: Table 'agency.tbl_customer' doesn't exist - Invalid query: SELECT `customer`.*, `tbl1`.`balance`
FROM `tbl_customer` as `customer`
LEFT JOIN (select sum(credit_points-debit_points) as balance ,user_id from tbl_locadel_credit as loca_credit
		where user_type = 'customer' group by user_id) as tbl1 ON `tbl1`.`user_id` = `customer`.`customer_id`
ORDER BY `customer`.`firstname`, `customer`.`lastname`
ERROR - 2021-06-04 11:17:50 --> 404 Page Not Found: Town/index
ERROR - 2021-06-04 17:17:05 --> Severity: error --> Exception: Unable to locate the model you have specified: Town_model F:\xampp\htdocs\agency\system\core\Loader.php 344
ERROR - 2021-06-04 17:19:40 --> Severity: error --> Exception: F:\xampp\htdocs\agency\application\models/admin_models/Town_model.php exists, but doesn't declare class Town_model F:\xampp\htdocs\agency\system\core\Loader.php 336
ERROR - 2021-06-04 17:19:58 --> Severity: error --> Exception: Call to a member function get_categories_info() on null F:\xampp\htdocs\agency\application\controllers\Town.php 27
ERROR - 2021-06-04 17:44:22 --> Severity: error --> Exception: Call to a member function get_towns_info() on null F:\xampp\htdocs\agency\application\controllers\Town.php 27
ERROR - 2021-06-04 17:45:49 --> Severity: error --> Exception: Call to a member function get_towns_info() on null F:\xampp\htdocs\agency\application\controllers\Town.php 27
