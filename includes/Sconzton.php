<?php
// ==============================
// SESIÓN
// ==============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set("America/Lima");

// ==============================
// BASE URL
// ==============================
$root = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$constants['base_url'] = $root;

// ==============================
// DB CONSTANTS
// ==============================
defined('DB_SERVER')   || define('DB_SERVER', 'localhost');
defined('DB_USERNAME') || define('DB_USERNAME', 'root');
defined('DB_PASSWORD') || define('DB_PASSWORD', '');
defined('DB_DATABASE') || define('DB_DATABASE', 'comsitec_db_business');

// ==============================
// PATHS
// ==============================
defined('SITE_URL') || define('SITE_URL', $constants['base_url']);
defined('HTTP_BOOTSTRAP_PATH') || define('HTTP_BOOTSTRAP_PATH', SITE_URL . 'assets/vendor/');
defined('HTTP_CSS_PATH')       || define('HTTP_CSS_PATH', SITE_URL . 'assets/css/');
defined('HTTP_JS_PATH')        || define('HTTP_JS_PATH', SITE_URL . 'assets/js/');
defined('BASH_PATH')           || define('BASH_PATH', 'C:/xampp/htdocs/Comsitec/');

// ==============================
// DB CONNECTION (SINGLETON)
// ==============================
if (!class_exists('DBConnection')) {
    class DBConnection {
        private static $_instance = null;
        private $_con;

        private function __construct() {
            $this->_con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            if ($this->_con->connect_error) {
                die('Database error -> ' . $this->_con->connect_error);
            }
            $this->_con->set_charset("utf8mb4");
        }

        public static function getInstance() {
            if (self::$_instance === null) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getConnection() {
            return $this->_con;
        }
    }
}

// ==============================
// PROTECCIÓN GLOBAL
// ==============================

// Página actual
$currentPage = basename($_SERVER['PHP_SELF']);

// Detectar AJAX
$isAjax = (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

// Detectar API
$isApi = (
    strpos($_SERVER['REQUEST_URI'], '/api/') !== false ||
    strpos($_SERVER['REQUEST_URI'], '/ApiRest/') !== false
);

// Páginas públicas (solo login)
$publicPages = [
    'lgn.php'
];

// NO LOGUEADO → BLOQUEAR (solo web, NO API)
if (
    !$isApi &&
    !$isAjax &&
    !isset($_SESSION['ucoduser']) &&
    !in_array($currentPage, $publicPages)
) {
    header('Location: ' . SITE_URL . 'index.php');
    exit;
}
