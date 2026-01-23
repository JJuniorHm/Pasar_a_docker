<?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
date_default_timezone_set("America/Lima");
$root = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$constants['base_url'] = $root;
if (!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost');
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}
if (!defined('DB_DATABASE')) {
    define('DB_DATABASE', 'comsitec_db_business');
}
if (!defined('SITE_URL')) {
    define('SITE_URL', $constants['base_url']);
}
if (!defined('HTTP_BOOTSTRAP_PATH')) {
    define('HTTP_BOOTSTRAP_PATH', $constants['base_url'] . 'assets/vendor/');
}
if (!defined('HTTP_CSS_PATH')) {
    define('HTTP_CSS_PATH', $constants['base_url'] . 'assets/css/');
}
if (!defined('HTTP_JS_PATH')) {
    define('HTTP_JS_PATH', $constants['base_url'] . 'assets/js/');
}
// windows path
//define('BASH_PATH', 'C:/xampp/htdocs/login-registration-system-using-php-oops-mysql/');
// ubuntu path
//define('BASH_PATH', '/var/www/login-registration-system-using-php-oops-mysql/');
// MAC path
if (!defined('BASH_PATH')) {
    define('BASH_PATH', 'C:/xampp/htdocs/testreg/');
}
if (!class_exists('DBConnection')) {
    class DBConnection {
        private static $_instance;
        private $_con;

        private function __construct() {
            if (!defined('DB_SERVER') || !defined('DB_USERNAME') || !defined('DB_PASSWORD') || !defined('DB_DATABASE')) {
                die('Error: Las constantes de conexión no están definidas.');
            }

            $this->_con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);      
            if ($this->_con->connect_error) {
                die('Database error -> ' . $this->_con->connect_error);
            }
            $this->_con->set_charset("utf8mb4");
        }

        public static function getInstance() {
            if (!self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getConnection() {
            return $this->_con;
        }
    }
}
?>