<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  $route['default_controller'] = 'home';
  $route['404_override'] = '';
  $route['translate_uri_dashes'] = FALSE;
  
  $route['admin'] = "admin_login/index";  
  $route['dashboard'] = "dashboard/index";
  $route['logout'] = "logout/index";
  
 
  //Categories
  $route['categories'] = "categories/index";
  $route['categories/add_category'] = "categories/add_category";
  $route['categories/edit_category/(:any)'] = "categories/edit_category/$1";
  
  //Products
  
  $route['products'] = "products/index";
  $route['products/add_product'] = "products/add_product";
  $route['products/edit_product/(:any)'] = "products/edit_product/$1";
  
  
  
  
?>