Add GOOGLE login button plugin
===

This plugin adds a button to allow users to log into Chamilo through their Google and Google Apps account.

To display this button on your portal, you have to:
 
* For Google authentication configure follow the next steps:

*You need a Google account to create an OAuth 2 CLIENT_ID and SECRET. The will enable users of Greenlight to authenticate with their own Google account (not yours).

*Login to your Google account, and click the following link

*https://console.developers.google.com/

*If you want to see the documentation behind OAuth2 at Google, click the link https://developers.google.com/identity/protocols/OAuth2.

*First, create a Project click the “CREATE” link.

*In the menu on the left, click “Credentials”.

*Next, click the “OAuth consent screen” tab below the “Credentials” page title.

*From here take the following steps:

*Select User type External and create it

*Choose any application name e.g “CHAMILLOAUTH”

*Set “Authorized domains” to your hostname eg “hostname” where hostname is your hostname

*Set “Application Homepage link” to your hostname e.g “http://hostname/” where hostname is your hostname

 Set “Application Privacy Policy link” to your hostname e.g “http://hostname/” where hostname is your hostname

*Click “Save”

*Next, go to credentials

*Click “Create credentials”

*Select “OAuth client ID”

*Select “Web application”

*Choose any name e.g “CHAMILLOAUTH”

* Under “Authorized redirect URIs” enter “https://hostname/?authlogin=gconnect” where hostname is your domain name e.g "example.com"

*Click “Create”

*A window should open with your OAuth credentials. In this window, copy client ID and client secret to the app/config/auth.conf.php file so it resembles the following (your credentials will be different).

GOOGLE_OAUTH2_ID=appId

GOOGLE_OAUTH2_SECRET=secret


* If facebook login is not configured uncomment facebook array because plugin depent of this route if facebook login is configured follow to next step.
```
//uncomment this in app/config/auth.conf.php

$facebook_config = array(
    'appId' => 'APPID',
    'secret' => 'secret app',
    'return_url' => api_get_path(WEB_PATH).'?action=fbconnect',
);

```

* Add the next code after facebook uncomment array, change the AppID and the Secret provided by Google inside the app/config/auth.conf.php file
```
$google_config = array(
    'appId' => '6ojopjpoihuguygicom',
    'secret' => 'nhioejnfionewofifsefef',
    'return_url' => api_get_path(WEB_PATH).'?authlogin=gconnect',
);
```

* If facebook login is not configured set the following line in your app/config/configuration.php if facebook login is configured follow to next step.
```
$_configuration['facebook'] = 1;
```

* Copy folder add_google_login_button in folder plugin 

* IMPORTANT Copy files of directory plugin external_login  to  /main/auth/external_login 

Replace facebook.inc.php (Firts backup of this file) and copy microsoft.inc.php, microsoft.init.php

This plugin has been developed to be added to the login_top or login_bottom region in Chamilo, but you can put it in whichever region you want.

Plugin was created based in facebook plugin