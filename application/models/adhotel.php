<?php

class CI_Adhotel extends CI_Model
{

    public $session;

    function is_hotel_logged_in()
    {
        if ($this->session->userdata['hotel']) {
            return TRUE;
        } else {
            return false;
        }

    }

    function getHotels($uid) {
        $sql = "select * from tx_rwadminhotel_hotel where uid='" . $uid . "'";
        return $this->Mix->read_rows_by_sql($sql);

    }

    function get_admin_hotel_nav($active, $base_url = '') {
        $base_url = empty($base_url) ? base_url() : $base_url;
        $menu = array(
            'profile' => array(
                'title' => 'Profile',
                'url' => 'admin-hotel/login/sub-menu-admin/profile/',
            ),
            'booking' => array(
                'title' => 'Bookings',
                'url' => 'admin-hotel/login/sub-menu-admin/bookings/',
            ),
            'roommanagementpage' => array(
                'title' => 'Room Management',
                'url' => 'admin-hotel/login/sub-menu-admin/room-management/',
            ),
            'roomspicsupdating' => array(
                'title' => 'Room\'s Pics Updating',
                'url' => 'admin-hotel/login/sub-menu-admin/rooms-pics-updating/',
            ),
            'hotelspicsupdating' => array(
                'title' => 'Hotel\'s Pics Updating',
                'url' => 'admin-hotel/login/sub-menu-admin/hotels-pics-updating/',
            ),
        );

        if ($menu[$active]) {
            $menu[$active]['style'] = ' class="active"';
        }

        foreach ($menu as $k => $v) {
            $o .= '<li><a href="' . $base_url . $v['url'] . '" ' . $v['style'] . '>' . $v['title'] . '</a></li>';
        }

        if ($o) {
            $o = <<<HTML
<h2>Menu:</h2>
<ul id="menu-admin">
    $o
</ul>
HTML;
        }

        return $o;

    }

    function get_logo($aseet_url) {
        $o = <<<HTML
<object width="320" height="150" vspace="2">
                <param name="movie" value="$aseet_url/images/logo.swf">
                <param name=quality value=high>
                <param name=wmode value="transparent"><embed src="fileadmin/templates/currTheme/html/images/logo.swf" width="320" height="150" vspace="2" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="transparent"></embed></object>
HTML;

        return $o;

    }

    function get_admin_hotel_destination($uid_location) {
        $sql = "SELECT *
                    FROM tx_rwmembermlm_city
                    WHERE uid_province = $uid_location and deleted = 0 and hidden = 0
                    ORDER BY city
                    ";
        $o = $this->Mix->read_rows_by_sql($sql);
        if ($o["city"]) {
            $o["city"] = trim(str_replace("Kota Administrasi", "", $o["city"]));
        }

        return $o;

    }

    function get_input_button($aksi) {

        if (!empty($aksi)) {
            $aksi = strtolower($aksi);
        }

        switch ($aksi)
        {
            case 'profile_showdefault' :
                $b = <<<HTML
<input type="hidden" name="aksi" value="edit" />
<tr class="even">
    <td colspan="2"><input type="submit" name="submit" value="Edit"/></td>
</tr>
HTML;
                break;
            case 'profile_doedit' :
                $b = <<<HTML
<input type="hidden" name="aksi" value="save" />
<tr class="even">
    <td colspan="2">
        <input type="submit" name="submit" value="Save"/>
        &nbsp;&nbsp;
        <input type="button" value="Back" onclick="history.go(-1)"/>
    </td>
</tr>
HTML;
                break;
            case 'roommanagementpage' :
                $b = <<<HTML
<input type="hidden" name="aksi" value="save" />
<tr class="even">
    <td colspan="2">
        <input type="submit" name="submit" value="Save"/>
        &nbsp;&nbsp;
        <input type="button" value="Back" onclick="history.go(-1)"/>
    </td>
</tr>
HTML;
                break;
            default:

                break;
        }

        return $b;

    }

}