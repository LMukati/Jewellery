<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-02-11 16:55:32 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'find_in_set('vishal',cr_point) = 1 or find_in_set('vishal',dr_point) = 1 )
 L...' at line 9 - Invalid query: SELECT find_in_set(1, revert_off) as revert_off, `id`, `user_id`, `user_type`, `request_type`, `request_id`, `created_at`, `is_revert`, `cr_point`, `dr_point`, `customer_name`, `shop_name`, `shop_id`, customer_phone
		from (
			select group_concat(tbl_locadel_credit.revert_off) as revert_off, `tbl_locadel_credit`.`id`, `user_id`, `user_type`, `request_type`, `request_id`, `created_at`, `is_revert`, group_concat(credit_points) as cr_point, group_concat(debit_points) as dr_point, GROUP_CONCAT(concat(tbl_customer.firstname, " ", tbl_customer.lastname)) as customer_name, group_concat(tbl_marchent.shop_name) as shop_name, group_concat(tbl_marchent.id) as shop_id, group_concat(tbl_customer.phone) as customer_phone
			FROM tbl_locadel_credit
			left join tbl_customer on tbl_customer.customer_id = tbl_locadel_credit.user_id and user_type = 'customer'
			left join tbl_marchent on tbl_marchent.id = tbl_locadel_credit.user_id and user_type = 'marchent'
			group by request_id, request_type
			order by tbl_locadel_credit.id asc) tbl1
WHERE (`customer_name` like '%vishal%'  find_in_set('vishal',cr_point) = 1 or find_in_set('vishal',dr_point) = 1 )
 LIMIT 10
