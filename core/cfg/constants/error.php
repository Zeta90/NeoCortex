<?php

/*
API
*/
// HEADERS
const ERR_NEOCORTEX_REQUIRED_HTTP_HEADER_AUTHTOKEN_NOT_FOUND = array(
    'static_trace' => 'core/HTTPHeadersController',
    'http' => '403',
    'type' => "core/HTTPheaders",
    'crash' => false,
    'description' => 'header: HTTP_AUTHTOKEN not found',
    'message' => 'Required HTTP_AUTHTOKEN header not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_REQUIRED_HTTP_HEADER_AGENT_NOT_FOUND = array(
    'static_trace' => 'core/HTTPHeadersController',
    'http' => '403',
    'type' => "core/HTTPheaders",
    'crash' => false,
    'description' => 'header: Agent HTTP header not found',
    'message' => 'Required Agent HTTP header not found',
    'version' => '1.0.0',
);

// APP
const ERR_NEOCORTEX_APP_NOT_FOUND = array(
    'static_trace' => 'core/HTTPHeadersController',
    'http' => '403',
    'type' => "core/Apps",
    'crash' => false,
    'description' => 'app: not found - Failed HTTP_TOKENHOST value',
    'message' => 'App not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_APP_PORT_FORBIDDEN = array(
    'static_trace' => 'core/HTTPHeadersController',
    'http' => '403',
    'type' => "core/Apps",
    'crash' => false,
    'description' => 'app: port forbidden',
    'message' => 'Requested port forbidden',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_APP_AUTH_SAUTH_TOKEN_FAILED = array(
    'static_trace' => 'core/HTTPHeadersController',
    'http' => '403',
    'type' => "core/Apps",
    'crash' => false,
    'description' => 'app: SessionToken failed',
    'message' => 'App not found. HTTP_AUTHTOKEN failed',
    'version' => '1.0.0',
);

// ROUTER
const ERR_NEOCORTEX_ROUTE_NOT_LISTED = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'route: not listed',
    'message' => 'Route not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_GET_FUNCTION_NOT_LISTED = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'route: get function not listed',
    'message' => 'Wrong GET params',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_SIGNUP_DISABLED = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'signup: disabled',
    'message' => 'Signup is currently unavailable. Try again later',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_LOGIN_DISABLED = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'login: disabled',
    'message' => 'Login is currently unavailable. Try again later',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_HTTP_METHOD_FORBIDDEN = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'route: forbidden HTTP method',
    'message' => 'Route failed. Requested method not allowed',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_HTTP_HEADERS_REQUIRED_NOT_FOUND = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'route: required route HTTP headers not found',
    'message' => 'Route failed. Failed HTTP headers params',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_HTTP_POST_PARAMS_REQUIRED_NOT_FOUND = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'route: required route POST params not found',
    'message' => 'Route failed. Failed POST params',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_ROUTE_HTTP_GET_PARAMS_FAILED = array(
    'static_trace' => 'core/RouterController',
    'http' => '403',
    'type' => "core/Router",
    'crash' => false,
    'description' => 'route: no GET section found',
    'message' => 'Route failed. Failed GET params',
    'version' => '1.0.0',
);

// SANITIZER
// -    Application
const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'signupST1: Email len failed',
    'message' => 'Signup failed. Email not valid (length)',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_EMAIL_NOT_VALID = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'signupST1: Email not valid',
    'message' => 'Signup failed. Email not valid',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_EMAIL_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'signupST1: Email not found',
    'message' => 'Signup failed. Email not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PASSWORD_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'signupST1: Password len failed',
    'message' => 'Signup failed. Password not valid (length)',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PASSWORD_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'signupST1: Password not found',
    'message' => 'Signup failed. Password not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PUBLIC_NAME_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'signupST1: Public name len failed',
    'message' => 'Signup failed. Public name not valid (length)',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PUBLIC_NAME_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST1: Public name not found',
    'message' => 'Signup failed. Public name not found',
    'version' => '1.0.0',
);

// -    Account
const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_EMAIL_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: Email len failed',
    'message' => 'Signup failed. Email does not match',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_EMAIL_NOT_VALID = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: Email not valid',
    'message' => 'Signup failed. Email does not match',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_EMAIL_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: Email not found',
    'message' => 'Signup failed. Email does not match',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_FNAME_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: FName len failed',
    'message' => 'Signup failed. FName not valid (length)',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_FNAME_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: FName not found',
    'message' => 'Signup failed. FName not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_LNAME_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: LName len failed',
    'message' => 'Signup failed. LName not valid (length)',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_LNAME_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: LName not found',
    'message' => 'Signup failed. LName not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_DOB_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: DOB len failed',
    'message' => 'Signup failed. DOB not valid (length)',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_DOB_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeSignupModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "signup",
    'description' => 'signupST2: DOB not found',
    'message' => 'Signup failed. DOB not found',
    'version' => '1.0.0',
);

// -    Login
const ERR_NEOCORTEX_SANITIZE_LOGIN_EMAIL_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeLoginModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "Login",
    'description' => 'FLogin: Email len failed',
    'message' => 'Login failed. Email not valid',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_LOGIN_EMAIL_NOT_VALID = array(
    'static_trace' => 'core/sanitizeLoginModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "Login",
    'description' => 'FLogin: Email not valid',
    'message' => 'Login failed. Email not valid',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_LOGIN_EMAIL_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeLoginModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "Login",
    'description' => 'FLogin: Email not found',
    'message' => 'Login failed. Email not found',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_LOGIN_PASSWORD_LEN_FAILED = array(
    'static_trace' => 'core/sanitizeLoginModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "Login",
    'description' => 'Login: Password len failed',
    'message' => 'Login failed. Password len failed',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SANITIZE_LOGIN_PASSWORD_NOT_FOUND = array(
    'static_trace' => 'core/sanitizeLoginModel',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'http' => '403', 'type' => "Login",
    'description' => 'FLogin: Token not found',
    'message' => 'Login failed. Token not found',
    'version' => '1.0.0',
);

// TOKENIZATION
const ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_1 = array(
    'static_trace' => 'core/TokenModel',
    'http' => '403',
    'type' => "core/SessionToken",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_2 = array(
    'static_trace' => 'core/TokenModel',
    'http' => '403',
    'type' => "core/SessionToken",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_3 = array(
    'static_trace' => 'core/TokenModel',
    'http' => '403',
    'type' => "core/SessionToken",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_4 = array(
    'static_trace' => 'core/SessionController',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);













// SESSION
const ERR_NEOCORTEX_SESSION_NOT_FOUND = array(
    'static_trace' => 'core/SessionController',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SESSION_LOW_PERMISSION = array(
    'static_trace' => 'core/SessionController',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_SESSION_EXPIRED_SESSION = array(
    'static_trace' => 'core/SessionController',
    'http' => '403',
    'type' => "core/Session",
    'crash' => false,
    'description' => 'Token falsified',
    'message' => 'Token falsified',
    'version' => '1.0.0',
);















// DATABASES
// -    MongoDB
const ERR_NEOCORTEX_MONGODB_UNEXPECTED_CONNECTION_EXCEPTION = array(
    'static_trace' => 'dbMongo.connect',
    'http' => '500', 
    'type' => "MongoDB",
    'crash' => true, 
    'description' => 'MongoDB - Unexpected connection error',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_MONGODB_UNEXPECTED_SINGLE_INSERT = array(
    'static_trace' => 'dbMongo.single_insert',
    'http' => '500', 
    'type' => "MongoDB",
    'crash' => true, 
    'description' => 'MongoDB - Unexpected single writing error',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

// -    MySQL
const ERR_NEOCORTEX_MYSQL_UNEXPECTED_CONNECTION_EXCEPTION = array(
    'static_trace' => 'dbMySQL.connect',
    'http' => '500', 
    'type' => "MySQL",
    'crash' => true, 
    'description' => 'MySQL - Unexpected connection error',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_MYSQL_UNEXPECTED_SP_EXECUTION_EXCEPTION = array(
    'static_trace' => 'dbMySQL.connect',
    'http' => '500', 
    'type' => "MySQL",
    'crash' => true, 
    'description' => 'MySQL - Unexpected connection error',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

// -    Redis
const ERR_NEOCORTEX_REDIS_PING_FAILED = array(
    'static_trace' => 'dbRedis.connect',
    'http' => '500', 
    'type' => "Redis",
    'crash' => true, 
    'description' => 'Redis - Unexpected connection error',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_REDIS_UNEXPECTED_EXCEPTION = array(
    'static_trace' => 'dbRedis.connect',
    'http' => '500', 
    'type' => "Redis",
    'crash' => true, 
    'description' => 'Redis - Unexpected connection error',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_REDIS_SELECTED_DATABASE_FAILED = array(
    'static_trace' => 'dbRedis.select_database',
    'http' => '500', 
    'type' => "Redis",
    'crash' => true, 
    'description' => 'Redis - Failed database selection',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_REDIS_SET_PAIR_FAILED = array(
    'static_trace' => 'dbRedis._set',
    'http' => '500', 
    'type' => "Redis",
    'crash' => true, 
    'description' => 'Redis - Failed setting pair',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_REDIS_GET_VALUE_FAILED = array(
    'static_trace' => 'dbRedis._set',
    'http' => '500', 
    'type' => "Redis",
    'crash' => true, 
    'description' => 'Redis - Failed setting pair',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);

const ERR_NEOCORTEX_REDIS_GET_KEYS_FAILED = array(
    'static_trace' => 'dbRedis._keys',
    'http' => '500', 
    'type' => "Redis",
    'crash' => true, 
    'description' => 'Redis - Failed getting keysr',
    'message' => 'Internal server error',
    'version' => '1.0.0',
);






























/*
DATABASES
*/
// MySQL
// -    Application
const ERR_MYSQL_APPLICATION_SIGNUP_DISABLED = array(
    'static_trace' => 'Databases.MySQL',
    'http' => '403', 
    'type' => "Redis",
    'crash' => false, 
    'description' => 'Signup application: Signup disabled',
    'message' => 'Signuo disabled by config',
    'version' => '1.0.0',
);

const ERR_MYSQL_APPLICATION_REQUESTED_APP_NOT_AVAILABLE = array(
    'static_trace' => 'session.signup_application',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup application: Bad app reference',
    'message' => 'Requested app not allowed',
    'version' => '1.0.0',
);

const ERR_MYSQL_APPLICATION_DUPLICATED_ALREADY_FINISHED = array(
    'static_trace' => 'session.signup_application',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup application: NeoCortexAccount already exists',
    'message' => 'NeoCortexAccount already exists',
    'version' => '1.0.0',
);

const ERR_MYSQL_APPLICATION_DUPLICATED_RECORDS_ERROR = array(
    'static_trace' => 'session.signup_application',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => true,
    'description' => 'Signup application: [ERROR] - DUPLICATED ERROR',
    'message' => 'Internal error',
    'version' => '1.0.0',
);


// Account
const ERR_MYSQL_ACCOUNT_SIGNUP_DISABLED = array(
    'static_trace' => 'session.signup_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup account: Signup disabled',
    'message' => 'Signup disabled by config',
    'version' => '1.0.0',
);

const ERR_MYSQL_ACCOUNT_REQUESTED_APP_NOT_AVAILABLE = array(
    'static_trace' => 'session.signup_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup account: Bad app reference',
    'message' => 'Requested app not allowed',
    'version' => '1.0.0',
);

const ERR_MYSQL_ACCOUNT_SESSIONTOKEN_FAILED = array(
    'static_trace' => 'session.signup_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup account: NeoCortexSessionToken does not match with the requested application',
    'message' => 'NeoCortexSessionToken failed',
    'version' => '1.0.0',
);

const ERR_MYSQL_ACCOUNT_ALREADY_FINISHED = array(
    'static_trace' => 'session.signup_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup account: NeoCortexAccount already exists',
    'message' => 'NeoCortexAccount already exists',
    'version' => '1.0.0',
);

const ERR_MYSQL_ACCOUNT_ALREADY_REGISTERED = array(
    'static_trace' => 'session.signup_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Signup account: NeoCortexAccount already registered',
    'message' => 'NeoCortexAccount already registered',
    'version' => '1.0.0',
);

const ERR_MYSQL_ACCOUNT_DUPLICATED_ERROR = array(
    'static_trace' => 'session.signup_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => true,
    'description' => 'Signup account: [ERROR] - DUPLICATED ERROR',
    'message' => 'Internal error',
    'version' => '1.0.0',
);

// Login
const ERR_MYSQL_LOGIN_SIGNIN_DISABLED= array(
    'static_trace' => 'session.login_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Login account: Signin disabled',
    'message' => 'Signin disabled by config',
    'version' => '1.0.0',
);

const ERR_MYSQL_LOGIN_DUPLICATED_MAIL = array(
    'static_trace' => 'session.login_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => true,
    'description' => 'Login account: [ERROR] EMAIL DUPLICATED',
    'message' => 'Internal error',
    'version' => '1.0.0',
);

const ERR_MYSQL_LOGIN_EMAIL_DOES_NOT_EXIST = array(
    'static_trace' => 'session.login_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Login account: Email does not exist',
    'message' => 'Email does not exist',
    'version' => '1.0.0',
);

const ERR_MYSQL_LOGIN_PASSWORD_DOES_NOT_MATCH = array(
    'static_trace' => 'session.login_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Login account: failed password input',
    'message' => 'Password failed',
    'version' => '1.0.0',
);

const ERR_MYSQL_LOGIN_ACCOUNT_NOT_ACTIVE = array(
    'static_trace' => 'session.login_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Login account: NeoCortexAccount not active',
    'message' => 'NeoCortexAccount not active',
    'version' => '1.0.0',
);

const ERR_MYSQL_LOGIN_REQUESTED_APP_NOT_AVAILABLE = array(
    'static_trace' => 'session.login_account',
    'http' => '403', 'type' => "mysql_sp",
    'crash' => false,
    'description' => 'Login account: Failed requested app',
    'message' => 'App not available',
    'version' => '1.0.0',
);

