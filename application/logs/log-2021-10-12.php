<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-12 05:11:28 --> 404 Page Not Found: Admin_login/index
ERROR - 2021-10-12 12:31:15 --> Severity: error --> Exception: Function name must be a string G:\xamp\htdocs\jewellery\application\models\billing_model.php 74
ERROR - 2021-10-12 12:31:52 --> Severity: error --> Exception: Function name must be a string G:\xamp\htdocs\jewellery\application\models\billing_model.php 74
ERROR - 2021-10-12 12:31:54 --> Severity: error --> Exception: Function name must be a string G:\xamp\htdocs\jewellery\application\models\billing_model.php 74
ERROR - 2021-10-12 12:47:23 --> Query error: Not unique table/alias: 'payment' - Invalid query: SELECT `bill`.`bill_no`, `payment`.*
FROM `tbl_payment` as `payment`
JOIN `tbl_payment` as `payment` ON `bill`.`id` = `payment`.`bill_id`
WHERE `payment`.`bill_id` = '33'
ORDER BY `bill`.`id` DESC
ERROR - 2021-10-12 09:07:53 --> 404 Page Not Found: Billing/ledger_v
ERROR - 2021-10-12 09:09:17 --> 404 Page Not Found: Billing/ledger_v
ERROR - 2021-10-12 09:12:15 --> 404 Page Not Found: Billing/ledger_v
ERROR - 2021-10-12 13:13:29 --> Severity: error --> Exception: Call to undefined function getledgerlist() G:\xamp\htdocs\jewellery\application\controllers\billing.php 413
ERROR - 2021-10-12 13:22:15 --> 404 Page Not Found: Admin_login/index
ERROR - 2021-10-12 13:29:04 --> 404 Page Not Found: Admin_login/index
ERROR - 2021-10-12 13:32:21 --> Severity: error --> Exception: Call to undefined method Mypdf::user_login_authentication() G:\xamp\htdocs\jewellery\application\controllers\Mypdf.php 8
