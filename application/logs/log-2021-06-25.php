<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-06-25 12:49:22 --> Severity: error --> Exception: syntax error, unexpected 'foreach' (T_FOREACH) F:\xampp\htdocs\agency\application\views\frontend_views\agentdetail.php 36
ERROR - 2021-06-25 12:49:35 --> Severity: error --> Exception: syntax error, unexpected 'for' (T_FOR) F:\xampp\htdocs\agency\application\views\frontend_views\agentdetail.php 36
ERROR - 2021-06-25 11:56:50 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:50 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:51 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:51 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:51 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:51 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:51 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:52 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:53 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:53 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:53 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:56 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:56 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:56 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:57 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:57 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:57 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:58 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:58 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:58 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:59 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:56:59 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:00 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:00 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:00 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:01 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:01 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:01 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 11:57:02 --> 404 Page Not Found: Home/assets
ERROR - 2021-06-25 16:50:10 --> Query error: Unknown column 'agent.phone' in 'field list' - Invalid query: SELECT `agency`.`agency` as `agency_name`, `review`.`quick_rate` as `rate`, `town`.`id` as `town_id`, `town`.`town_name`, `agent`.`id` as `agent_id`, `agent`.`agent_name` as `agent_name`, `agent`.`cell` as `cell`, `agent`.`phone` as `phone`, `agent`.`agent_photo`, `agent`.`create_date` as `create_date`, `agent`.`agent_email`, `sub`.`suburb_name`
FROM `tbl_agent` as `agent`
LEFT JOIN `tbl_agency` as `agency` ON `agency`.`id` = `agent`.`agency_id`
LEFT JOIN `town` as `town` ON `town`.`id` = `agent`.`town_id`
LEFT JOIN `suburb` as `sub` ON `sub`.`id` = `agent`.`suburb_id`
LEFT JOIN `tbl_review` as `review` ON `review`.`agent_id` = `agent`.`id`
WHERE `agent`.`id` = '3'
AND `agent`.`deletion_status` =0
ERROR - 2021-06-25 12:56:39 --> 404 Page Not Found: Agencydashboard/edit_agent
ERROR - 2021-06-25 18:17:10 --> Severity: error --> Exception: Too few arguments to function Agency_agent_model::get_suburbs_info(), 0 passed in F:\xampp\htdocs\agency\application\controllers\Agencydashboard.php on line 143 and exactly 1 expected F:\xampp\htdocs\agency\application\models\front_models\Agency_agent_model.php 78
ERROR - 2021-06-25 18:17:39 --> Severity: error --> Exception: Too few arguments to function Agency_agent_model::get_suburbs_info(), 0 passed in F:\xampp\htdocs\agency\application\controllers\Agencydashboard.php on line 143 and exactly 1 expected F:\xampp\htdocs\agency\application\models\front_models\Agency_agent_model.php 78
