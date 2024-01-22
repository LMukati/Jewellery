<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-06-16 08:59:43 --> Unable to connect to the database
ERROR - 2021-06-16 13:43:26 --> Query error: The used SELECT statements have a different number of columns - Invalid query: SELECT *
FROM `tbl_agency` UNION SELECT *
FROM `tbl_agent`
ERROR - 2021-06-16 13:43:26 --> Query error: The used SELECT statements have a different number of columns - Invalid query: SELECT *
FROM `tbl_agency` UNION SELECT *
FROM `tbl_agent`
ERROR - 2021-06-16 13:46:39 --> Query error: Table 'agency.suppliers' doesn't exist - Invalid query: SELECT `agency`
FROM `tbl_agency` UNION SELECT `agent_name`
FROM `Suppliers`
ERROR - 2021-06-16 13:46:39 --> Query error: Table 'agency.suppliers' doesn't exist - Invalid query: SELECT `agency`
FROM `tbl_agency` UNION SELECT `agent_name`
FROM `Suppliers`
ERROR - 2021-06-16 13:52:53 --> Severity: error --> Exception: syntax error, unexpected 'ORDERBY' (T_STRING), expecting ',' or ')' F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 145
ERROR - 2021-06-16 13:53:03 --> Severity: error --> Exception: syntax error, unexpected 'ORDER' (T_STRING), expecting ',' or ')' F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 145
ERROR - 2021-06-16 13:53:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL UNION SELECT `agent_name`
FROM `tbl_agent` ORDER BY agency,agent_name' at line 3 - Invalid query: SELECT `agency`
FROM `tbl_agency`
WHERE  IS NULL UNION SELECT `agent_name`
FROM `tbl_agent` ORDER BY agency,agent_name
ERROR - 2021-06-16 13:53:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL UNION SELECT `agent_name`
FROM `tbl_agent` ORDER BY agency,agent_name' at line 3 - Invalid query: SELECT `agency`
FROM `tbl_agency`
WHERE  IS NULL UNION SELECT `agent_name`
FROM `tbl_agent` ORDER BY agency,agent_name
ERROR - 2021-06-16 13:54:27 --> Query error: Unknown column 'agent_name' in 'order clause' - Invalid query: SELECT `agency`
FROM `tbl_agency`
WHERE `deletion_status` =0 UNION SELECT `agent_name`
FROM `tbl_agent`
WHERE `deletion_status` =0 ORDER BY agency,agent_name
ERROR - 2021-06-16 13:54:27 --> Query error: Unknown column 'agent_name' in 'order clause' - Invalid query: SELECT `agency`
FROM `tbl_agency`
WHERE `deletion_status` =0 UNION SELECT `agent_name`
FROM `tbl_agent`
WHERE `deletion_status` =0 ORDER BY agency,agent_name
ERROR - 2021-06-16 14:07:08 --> Query error: Unknown column 'agency' in 'order clause' - Invalid query: SELECT `agency` as `result_name`
FROM `tbl_agency`
WHERE `deletion_status` =0 UNION SELECT `agent_name` as `result_name`
FROM `tbl_agent`
WHERE `deletion_status` =0 ORDER BY agency
ERROR - 2021-06-16 14:07:08 --> Query error: Unknown column 'agency' in 'order clause' - Invalid query: SELECT `agency` as `result_name`
FROM `tbl_agency`
WHERE `deletion_status` =0 UNION SELECT `agent_name` as `result_name`
FROM `tbl_agent`
WHERE `deletion_status` =0 ORDER BY agency
ERROR - 2021-06-16 14:08:18 --> Query error: Table 'tbl_agency' from one of the SELECTs cannot be used in field list - Invalid query: SELECT `agency` as `result_name`
FROM `tbl_agency` as `tbl_agency`
WHERE `tbl_agency`.`deletion_status` =0 UNION SELECT `agent_name` as `result_name`
FROM `tbl_agent` as `tbl_agent`
WHERE `tbl_agent`.`deletion_status` =0 ORDER BY tbl_agency.agency
ERROR - 2021-06-16 14:08:19 --> Query error: Table 'tbl_agency' from one of the SELECTs cannot be used in field list - Invalid query: SELECT `agency` as `result_name`
FROM `tbl_agency` as `tbl_agency`
WHERE `tbl_agency`.`deletion_status` =0 UNION SELECT `agent_name` as `result_name`
FROM `tbl_agent` as `tbl_agent`
WHERE `tbl_agent`.`deletion_status` =0 ORDER BY tbl_agency.agency
ERROR - 2021-06-16 14:09:14 --> Query error: Table 'tbl_agency' from one of the SELECTs cannot be used in field list - Invalid query: SELECT `agency`
FROM `tbl_agency` as `tbl_agency`
WHERE `tbl_agency`.`deletion_status` =0 UNION SELECT `agent_name`
FROM `tbl_agent` as `tbl_agent`
WHERE `tbl_agent`.`deletion_status` =0 ORDER BY tbl_agency.agency
ERROR - 2021-06-16 14:09:15 --> Query error: Table 'tbl_agency' from one of the SELECTs cannot be used in field list - Invalid query: SELECT `agency`
FROM `tbl_agency` as `tbl_agency`
WHERE `tbl_agency`.`deletion_status` =0 UNION SELECT `agent_name`
FROM `tbl_agent` as `tbl_agent`
WHERE `tbl_agent`.`deletion_status` =0 ORDER BY tbl_agency.agency
ERROR - 2021-06-16 14:10:12 --> Query error: Table 'tbl_agency' from one of the SELECTs cannot be used in field list - Invalid query: SELECT `tbl_agency`.`agency`
FROM `tbl_agency` as `tbl_agency`
WHERE `tbl_agency`.`deletion_status` =0 UNION SELECT `tbl_agent`.`agent_name`
FROM `tbl_agent` as `tbl_agent`
WHERE `tbl_agent`.`deletion_status` =0 ORDER BY tbl_agency.agency
ERROR - 2021-06-16 14:27:22 --> Severity: error --> Exception: syntax error, unexpected '_' (T_STRING), expecting ',' or ')' F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 139
ERROR - 2021-06-16 14:28:18 --> Severity: error --> Exception: syntax error, unexpected '_' (T_STRING), expecting ',' or ')' F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 139
ERROR - 2021-06-16 14:31:28 --> Severity: error --> Exception: syntax error, unexpected 'agency' (T_STRING), expecting ',' or ')' F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 139
ERROR - 2021-06-16 14:31:54 --> Severity: error --> Exception: syntax error, unexpected 'agent' (T_STRING), expecting ',' or ')' F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 145
ERROR - 2021-06-16 14:32:13 --> Query error: Unknown column 'agent' in 'field list' - Invalid query: SELECT `agency`, concat(id, "_", agency) as agency_id
FROM `tbl_agency`
WHERE `agency` LIKE '%n%' ESCAPE '!'
AND `deletion_status` =0 UNION SELECT `agent_name`, concat(id, "_", agent) as agency_id
FROM `tbl_agent`
WHERE `agent_name` LIKE '%n%' ESCAPE '!'
AND `deletion_status` =0 ORDER BY agency
ERROR - 2021-06-16 14:32:13 --> Query error: Unknown column 'agent' in 'field list' - Invalid query: SELECT `agency`, concat(id, "_", agency) as agency_id
FROM `tbl_agency`
WHERE `agency` LIKE '%new%' ESCAPE '!'
AND `deletion_status` =0 UNION SELECT `agent_name`, concat(id, "_", agent) as agency_id
FROM `tbl_agent`
WHERE `agent_name` LIKE '%new%' ESCAPE '!'
AND `deletion_status` =0 ORDER BY agency
ERROR - 2021-06-16 17:28:42 --> Severity: error --> Exception: Call to a member function result_array() on null F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 149
ERROR - 2021-06-16 17:28:42 --> Severity: error --> Exception: Call to a member function result_array() on null F:\xampp\htdocs\agency\application\models\front_models\Home_model.php 149
