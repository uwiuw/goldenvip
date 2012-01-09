<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "main";
$route['404_override'] = '';

$route['(:any)'] = "main";
# public page
$route['home-page'] = "main/homepage";
$route['about-us'] = "main/about";
$route['about-us/the-gvip-story'] = "main/about";
$route['about-us/vision-and-mission'] = "main/vision_and_mission";
$route['about-us/corporate-overview'] = "main/corporate_overview";
$route['about-us/why-gvip'] = "main/why_gvip";


$route['products'] = "main/business";
$route['products/business'] = "main/business";
$route['products/vip'] = "main/vip";
$route['products/travel'] = "main/travel";
$route['products/participant-hotels'] = "main/participant_hotels";
$route['products/catalogue-of-point-rewards'] = "main/catalogue_of_point_rewards";



$route['news'] = "main/news";
$route['faq'] = "main/faq";
$route['contact-us'] = "main/contact";

# admin gvip area
$route['_admin/login'] = 'panel/main/login';
$route['_admin/check_login'] = 'panel/main/check_login';
$route['_admin/logout'] = 'panel/main/logout';
$route['_admin'] = 'panel/main';
$route['_admin/home_page'] = 'panel/main/home_page';

$route['_admin/distributor'] = 'panel/main/list_distributor'; # admin area for distributor
$route['_admin/del_distributor'] = 'panel/main/del_distributor'; # delete distributor
$route['_admin/member'] = 'panel/main/list_member'; # admin area for member GVIP
$route['_admin/voucher_code'] = 'panel/main/list_voucher'; # admin area for manage voucher code
# generate_vc
$route['_admin/generate_vc'] = 'panel/main/generate_vc';
$route['_admin/generate_vc/generate'] = 'panel/main/take_post_and_generate_vc';

$route['_admin/comision_payment'] = 'panel/commission'; 
$route['_admin/comision_payed'] = 'panel/commission/comision_payed';
$route['_admin/update_data_member'] = 'panel/main/update_data_member';

# mlm extra
$route['_admin/new_distributor'] = 'panel/main/new_distributor';
$route['_admin/member_migration'] = 'panel/main/member_migration';
$route['_admin/member_set_new_grade'] = 'panel/main/member_set_new_grade';
$route['_admin/searching_form'] = 'panel/main/searching_form';

# tour and travel
$route['_admin/tour_travel/member_profit'] = 'panel/tour_travel';
$route['_admin/tour_travel/vip_rate'] = 'panel/tour_travel/vip_rate';
$route['_admin/tour_travel/travel_rate'] = 'panel/tour_travel/travel_rate';
$route['_admin/tour_travel/tour_travel_admin'] = 'panel/tour_travel/tour_travel_admin';
$route['_admin/tour_travel/update_rate'] = 'panel/tour_travel/update_rate';
$route['_admin/tour_travel/selected_profit_member'] = 'panel/tour_travel/select_profit_member';
$route['_admin/tour_travel/paid_booking'] = 'panel/tour_travel/paid_booking';
$route['_admin/tour_travel/destination'] = 'panel/tour_travel/tour_destination';
$route['_admin/tour_travel/add_new_data_travel'] = 'panel/tour_travel/add_new_data_travel';
$route['_admin/tour_travel/update_new_destination'] =

$route['_admin/tour_travel/saving_new_destination'] = 'panel/tour_travel/saving_new_destination';
$route['_admin/tour_travel/update_new_destination'] = 'panel/tour_travel/update_destination';
$route['_admin/tour_travel/browse'] = 'panel/tour_travel/browse_data';
# panel management hotel
$route['_admin/hotel/management'] = 'panel/admin_hotel';
$route['_admin/hotel/member_profit'] = 'panel/admin_hotel/member_profit';
$route['_admin/hotel/golden_vip_rate'] = 'panel/admin_hotel/golden_vip_rate';
$route['_admin/hotel/destination'] = 'panel/admin_hotel/destination';
$route['_admin/hotel/area_in_detail'] = 'panel/admin_hotel';
$route['_admin/hotel/pagination'] = 'panel/admin_hotel';
$route['_admin/hotel/get_detail'] = 'panel/admin_hotel/read_address';
$route['_admin/hotel/read_address'] = 'panel/admin_hotel/read_address';
$route['_admin/hotel/update_data_hotel'] = 'panel/admin_hotel/update_data_hotel';
$route['_admin/hotel/searching_form'] = 'panel/admin_hotel/searching_form';
$route['_admin/hotel/searching_form_member_profit'] = 'panel/admin_hotel/searching_form_member_profit';
$route['_admin/hotel/update_data_golden_rate'] = 'panel/admin_hotel/update_data_golden_rate';
$route['_admin/hotel/add_new_data_hotel'] = 'panel/admin_hotel/add_new_data_hotel';

$route['_admin/hotel/saving_destination'] = 'panel/admin_hotel/saving_destination';

# member area
$route['member'] = 'member/main';
$route['member/home-page'] = 'member/main';
$route['member/list-member-request'] = 'member/main/list_member_request';
$route['member/opportunity'] = 'member/main/opportunity';
$route['member/news'] = 'member/main/news';
$route['member/lock_profile']='member/main/lock_profile';
$route['member/open_profile']='member/main/open_profile';
$route['member/profile'] = 'member/main/profile';
$route['member/profile/update-profile'] = 'member/main/update_profile';
$route['member/report/genealogy'] = 'member/main/report';
$route['member/report/commision'] = 'member/main/commision';
$route['member/report/direct-sponsored'] = 'member/main/direct_sponsored';
$route['member/back-office'] = 'member/main/back_office';
$route['member/thank-you-registering'] = 'member/main/thankyou';
$route['member/logout'] = 'member/main/member_logout';
$route['member/check-login'] = 'member/main/check_login';
$route['member/join-now'] = 'member/main/join_now';
	$route['member/join-now/saving'] = 'member/main/join_now_saving';
	$route['member/join-now/set-active-member'] = 'member/main/set_active_member';
	$route['member/join-now-by-member'] = 'member/main/join_by_member';
# member package business
$route['member/reservation/business'] = 'member/business';
$route['member/reservation/business/use-this-reservation-for']='member/business/set_reservation';
$route['member/reservation/business/save-reservation'] = 'member/business/save_reservation';
$route['member/reservation/business/set-for-other'] = 'member/business/set_for_other';
# member package vip
$route['member/reservation/vip'] = 'member/vip';
$route['member/reservation/vip/holy-land'] = 'member/vip';
$route['member/reservation/vip/non-holy-land'] = 'member/vip/non_holyland';
$route['member/reservation/vip/package-selected'] = 'member/vip/package_selected';
$route['member/reservation/vip/use-this-reservation-for'] = 'member/vip/use_this_reservation_for';
$route['member/reservation/vip/set-for-other'] = 'member/vip/set_for_other';
$route['member/reservation/vip/set-for-myself'] = 'member/vip/set_for_myself';
$route['member/reservation/vip/set-reservation'] = 'member/vip/set_reservation';
# member package travel
$route['member/reservation/travel'] = 'member/travel';
$route['member/reservation/travel/package-selected'] = 'member/travel/package_selected';
$route['member/reservation/travel/use-this-reservation-for'] = 'member/travel/use_this_reservation_for';
$route['member/reservation/travel/set-for-other'] = 'member/travel/set_for_other';
$route['member/reservation/travel/set-for-myself'] = 'member/travel/set_for_myself';
$route['member/reservation/travel/set-reservation'] = 'member/travel/set_reservation';

# redeeem points
$route['member/reservation/redeem_points'] = 'member/main/redeem_points';
# member business saving reservation
$route['member/reservation/list-hotel'] = 'member/business/list_hotel';

# test area
$route['test'] = 'test';
$route['engine'] = 'engine/mlmmanagement';


# hotel and reservation
$route['admin-hotel'] = 'admin_hotel';
$route['admin-hotel/check-login'] = 'admin_hotel/check_login';
$route['admin-hotel/login'] = 'admin_hotel/member_login';
$route['admin-hotel/logout'] = 'admin_hotel/member_logout';
$route['admin-hotel/login/sub-menu-admin/profile'] = 'admin_hotel/profile';
$route['admin-hotel/login/sub-menu-admin/bookings'] = 'admin_hotel/booking';
$route['admin-hotel/login/sub-menu-admin/bookings/periode-print'] = 'admin_hotel/periode_print';
$route['admin-hotel/login/sub-menu-admin/room-management'] = 'admin_hotel/room_management';
$route['admin-hotel/login/sub-menu-admin/rooms-pics-updating'] = 'admin_hotel/rooms_pics_updating';
$route['admin-hotel/login/sub-menu-admin/hotels-pics-updating'] = 'admin_hotel/hotels_pics_updating';

# admin tour reservation
$route['admin-tour'] = "admin_tour";
$route['admin-tour/login']="admin_tour/login";
$route['admin-tour/logout']="admin_tour/logout";
$route['admin-tour/check-login'] = "admin_tour/check_login";
$route['admin-tour/home'] = "admin_tour/get_package";
$route['admin-tour/package-management'] = "admin_tour/get_package";
$route['admin-tour/booking'] = 'admin_tour/get_member_booking';
$route['admin-tour/set-schedule'] = 'admin_tour/set_schedule';
$route['admin-tour/set-schedule/save-schedule'] = 'admin_tour/save_schedule';
$route['admin-tour/last-schedule'] = 'admin_tour/last_schedule';
$route['admin-tour/last-schedule/browse'] = 'admin_tour/get_form';
//$route['admin-tour/account-settings']='admin_tour/account_settings';
//$route['admin-tour/account-settings/update']='admin_tour/account_settings_update';
$route['admin-tour/edit_data'] = 'admin_tour/get_form';
$route['admin-tour/update_data_package'] = 'admin_tour/update_package';
$route['admin-tour/in-active-data']= 'admin_tour/get_form';
$route['admin-tour/package-management/add-package'] = 'admin_tour/add_package';
$route['admin-tour/package-management/add_data_package'] = 'admin_tour/save_data_package';
$route['admin-tour/booking/cancel'] = 'admin_tour/get_form';
/* End of file routes.php */
/* Location: ./application/config/routes.php */