<?php

require_once __DIR__.'/../../inc/global.inc.php';
require_once __DIR__.'/google.init.php';
require_once __DIR__.'/functions.inc.php';
$raiz_file = dirname(dirname(dirname(dirname(__FILE__))));
require_once $raiz_file.'/plugin/add_google_login_button/google-api-php-client-2.4.1/vendor/autoload.php';

function googleConnect()
{
    if (isset($_GET['authlogin']) AND !isset($_GET['code'])) {
       header('Location: '.api_get_path(WEB_PATH));
       exit();
    }
    $google_client = new Google_Client();

    $google_client->setClientId($GLOBALS['google_config']['appId']);

    //Set the OAuth 2.0 Client Secret key
    $google_client->setClientSecret($GLOBALS['google_config']['secret']);


    //Set the OAuth 2.0 Redirect URI
    $google_client->setRedirectUri(api_get_path(WEB_PATH).'?authlogin=gconnect');

    //
    $google_client->addScope('email');

    $google_client->addScope('profile');
    if(isset($_GET["code"]))
    {

        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
        if(!isset($token['error']))
        {
            $google_client->setAccessToken($token['access_token']);

            $_SESSION['access_token'] = $token['access_token'];

            $google_service = new Google_Service_Oauth2($google_client);

            $data = $google_service->userinfo->get();
            $language = 'en_US';

            $u = [
                'firstname' => $data['given_name'],
                'lastname' => $data['family_name'],
                'status' => STUDENT,
                'email' => $data['email'],
                'username' => changeToValidChamiloLogin($data['email']),
                'language' => $language,
                'password' => 'google',
                'auth_source' => 'google',
                'extra' => [],
            ];
            $chamiloUinfo = api_get_user_info_from_email($data['email']);

            if ($chamiloUinfo === false) {
                // We have to create the user
              /*  $chamilo_uid = external_add_user($u);
        
                if ($chamilo_uid === false) {
                    Display::addFlash(
                        Display::return_message(get_lang('UserNotRegistered'), 'error')
                    );
        
                    header('Location: '.api_get_path(WEB_PATH));
                    exit;
                }
        
                $_user['user_id'] = $chamilo_uid;
                $_SESSION['_user'] = $_user;*/
                Display::addFlash(
                   Display::return_message('El usuario no existe en nuestro sistema', 'error')
                );
        
                header('Location: '.api_get_path(WEB_PATH));
                exit();
        
            }
            // User already exists, update info and login
            $chamilo_uid = $chamiloUinfo['user_id'];
            $u['user_id'] = $chamilo_uid;
            //external_update_user($u);
            $_user['user_id'] = $chamilo_uid;
            $_SESSION['_user'] = $chamiloUinfo;


            header('Location: '.api_get_path(WEB_PATH));
            exit();

        }

    }


}

/**
 * Get facebook login url for the platform.
 *
 * @return string
 */
function googleGetLoginUrl()
{


    //Make object of Google API Client for call Google API
    $google_client = new Google_Client();

    $google_client->setClientId($GLOBALS['google_config']['appId']);

    //Set the OAuth 2.0 Client Secret key
    $google_client->setClientSecret( $GLOBALS['google_config']['secret']);

    $google_client->setRedirectUri(api_get_path(WEB_PATH).'?authlogin=gconnect');

    $google_client->addScope('email');

    $google_client->addScope('profile');

    $loginUrl = $google_client->createAuthUrl();

    return $loginUrl;
}

/**
 * Return a valid Chamilo login
 * Chamilo login only use characters lettres, des chiffres et les signes _ . -.
 *
 * @param $in_txt
 *
 * @return mixed
 */
/*function changeToValidChamiloLogin($in_txt)
{
    return preg_replace("/[^a-zA-Z1-9_\-.]/", "_", $in_txt);
}
*/
/**
 * Get user language.
 *
 * @param string $language
 *
 * @return bool
 */
/*function facebookPluginGetLanguage($language = 'en_US')
{
    $language = substr($language, 0, 2);
    $sqlResult = Database::query(
        "SELECT english_name FROM ".
        Database::get_main_table(TABLE_MAIN_LANGUAGE).
        " WHERE available = 1 AND isocode = '$language'"
    );
    if (Database::num_rows($sqlResult)) {
        $result = Database::fetch_array($sqlResult);

        return $result['english_name'];
    }

    return false;
}*/
