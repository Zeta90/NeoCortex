<?php

// Editing manually this area might cause a crash within the system.
// Please, leave this area away

/*InternalArea*/
const IS_DEBUGGING = true;
/*InternalArea!*/

/*EditableArea*/
const SERVERS = array(
    'mysql' => array(
        'host' => "neocortex.api",
        'port' => "3306",
        'userName' => "diglesias",
        'password' => "underground",
    ),

    'mongodb' => array(
        'host' => "neocortex.api",
        'port' => "27017"
    ),

    'redis' => array(
        'host' => "neocortex.api",
        'port' => "6379",
        "databases" => array(
            "feed_session" => 0,
            "stream_rooms" => 1,
        )
    )
);
/*EditableArea!*/

/*DangerArea*/

// Test 
const API_TEST_ALLOWED = true;

// Feed
const FEED_MONGO_CORE_CRASH = 'coreCrash';
const FEED_MONGO_CORE_REQUEST = 'request';

// Paths
const CORE_ROOT_PATH = '/var/www/apps/api/core/';
const ROUTES_JSON_FILE = 'cfg/routes.json';
const APPS_JSON_FILE = 'cfg/apps.json';

// Api cfg
const API_SIGNUP_ALLOWED = true;
const API_LOGIN_ALLOWED = true;

// Test
// const API_TEST_ALLOWED = true;

// SP statics
const SP_API_SIGNUP_APPLICATION = 'session.signup_application';
const SP_API_SIGNUP_ACCOUNT = 'session.signup_account';
const SP_API_LOGIN_ACCOUNT = 'session.login_account';
/*DangerArea!*/