<?php

// Show the google login button
$_template['show_message'] = false;

if (isset($_GET['authlogin'])) {
   $action = $_GET['authlogin'];
   if ($action == 'authlogin') {
       googleConnect();
   }    
}

//if (api_is_anonymous() && api_get_setting('google_login_activate') == 'true') {
if (api_is_anonymous()) {

    require_once api_get_path(SYS_CODE_PATH)."auth/external_login/google.inc.php";
    $_template['show_message'] = true;
    // the default title
    $button_url = api_get_path(WEB_PLUGIN_PATH)."add_google_login_button/img/google.png";
    $href_link = googleGetLoginUrl();
    if (!empty($plugin_info['settings']['add_google_login_button_google_button_url'])) {
        $button_url = api_htmlentities($plugin_info['settings']['add_google_login_button_google_button_url']);
    }
    
    //$button_url = '#hola';
    $_template['google_button_url'] = $button_url;
    $_template['google_href_link'] = $href_link;
}
