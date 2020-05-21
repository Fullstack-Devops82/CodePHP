<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
 */
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
 */
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
 */
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// database resp_code
defined('DB_SUCCESS') or define('DB_SUCCESS', "00");
defined('DB_NO_RESULT') or define('DB_NO_RESULT', "01");
defined('DB_SQL_ERR') or define('DB_SQL_ERR', "02");

// user level
defined('USER_TYPE_ADMIN') or define('USER_TYPE_ADMIN', 0); // manager
defined('USER_TYPE_USER') or define('USER_TYPE_USER', 1); // user

// user status
defined('USER_STATUS_REQUEST') or define('USER_STATUS_REQUEST', 0); // REQUEST
defined('USER_STATUS_ACTIVED') or define('USER_STATUS_ACTIVED', 1); // ACTIVED
defined('USER_STATUS_BLOCKED') or define('USER_STATUS_BLOCKED', 2); // BLOCKED

defined('USER_STATUS_STR_REQUEST') or define('USER_STATUS_STR_REQUEST', "proposed"); // REQUEST
defined('USER_STATUS_STR_ACTIVED') or define('USER_STATUS_STR_ACTIVED', "allowed"); // ACTIVED
defined('USER_STATUS_STR_BLOCKED') or define('USER_STATUS_STR_BLOCKED', "blocked"); // BLOCKED

// launcher user status
defined('BOX_STATUS_PENDING') or define('BOX_STATUS_PENDING', 0); // ACTIVED
defined('BOX_STATUS_ACTIVED') or define('BOX_STATUS_ACTIVED', 1); // ACTIVED
defined('BOX_STATUS_BLOCKED') or define('BOX_STATUS_BLOCKED', 2); // BLOCKED

defined('BOX_STATUS_STR_PENDING') or define('BOX_STATUS_STR_PENDING', "pending"); // PENDING
defined('BOX_STATUS_STR_ACTIVED') or define('BOX_STATUS_STR_ACTIVED', "activated"); // ACTIVATED
defined('BOX_STATUS_STR_BLOCKED') or define('BOX_STATUS_STR_BLOCKED', "blocked"); // BLOCKED

// notification status
defined('NOTI_STATUS_DRAFT') or define('NOTI_STATUS_DRAFT', 0); // DRAFT
defined('NOTI_STATUS_ACTIVED') or define('NOTI_STATUS_ACTIVED', 1); // ACTIVED

defined('NOTI_STATUS_STR_DRAFT') or define('NOTI_STATUS_STR_DRAFT', "draft"); // DRAFT
defined('NOTI_STATUS_STR_ACTIVED') or define('NOTI_STATUS_STR_ACTIVED', "active"); // ACTIVED

// default background
defined('BG_DEFAULT') or define('BG_DEFAULT', '1.jpg'); //

// default_flag
defined('FLAG_DEFAULT') or define('FLAG_DEFAULT', 1); //
defined('FLAG_NO_DEFAULT') or define('FLAG_NO_DEFAULT', 0); //

// response code
defined('RSP_SUCCESS') or define('RSP_SUCCESS', "00"); // success
defined('RSP_FAIL') or define('RSP_FAIL', "01"); // no box_id
defined('RSP_USER_BLOCK') or define('RSP_USER_BLOCK', "02"); // user block

// thumb text length
defined('THUMB_LEN_TITLE') or define('THUMB_LEN_TITLE', 20); // title
defined('THUMB_LEN_CONTENT') or define('THUMB_LEN_CONTENT', 40); // content
