<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-06-21 11:18:07 --> Query error: Column 'town_id' in where clause is ambiguous - Invalid query: SELECT `agent`.*, `sub`.`suburb_name`
FROM `tbl_agent` as `agent`
LEFT JOIN `suburb` as `sub` ON `sub`.`id` = `agent`.`suburb_id`
WHERE `town_id` = '4'
AND `suburb_id` = '2'
AND `agent`.`id` = '1'
AND `agent`.`deletion_status` =0
ORDER BY `agent`.`id` ASC
ERROR - 2021-06-21 14:27:42 --> 404 Page Not Found: Home/images
ERROR - 2021-06-21 14:43:01 --> 404 Page Not Found: Home/images
ERROR - 2021-06-21 14:48:30 --> 404 Page Not Found: Home/images
