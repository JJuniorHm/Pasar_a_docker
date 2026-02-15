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
$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
$root .= $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

$constants['base_url'] = rtrim($root, '/') . '/';

// ==============================
// DETECTAR ENTORNO
// ==============================
$isCloudRun = getenv('K_SERVICE') !== false;

// ==============================
// DB CONFIGURATION
// ==============================
if ($isCloudRun) {

    // ☁️ Cloud Run + Cloud SQL
    define('DB_SERVER', '/cloudsql/junpe-483700:us-central1:junpe');
    define('DB_USERNAME', getenv('DB_USERNAME'));
    define('DB_PASSWORD', getenv('DB_PASSWORD'));
    define('DB_DATABASE', getenv('DB_DATABASE'));

} else {

    // 💻 Entorno local (XAMPP)
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'comsitec_db_business');
}

// ==============================
// PATHS
// ==============================
define('SITE_URL', $constants['base_url']);
define('HTTP_BOOTSTRAP_PATH', SITE_URL . 'assets/vendor/');
define('HTTP_CSS_PATH', SITE_URL . 'assets/css/');
define('HTTP_JS_PATH', SITE_URL . 'assets/js/');

// Ruta física compatible con Linux / Windows / Docker
define('BASH_PATH', __DIR__ . '/');

// ==============================
// DB CONNECTION (SINGLETON)
// ==============================
if (!class_exists('DBConnection')) {

    class DBConnection {

        private static $_instance = null;
        private $_con;

        private function __construct() {

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $this->_con = new mysqli(
                    DB_SERVER,
                    DB_USERNAME,
                    DB_PASSWORD,
                    DB_DATABASE
                );

                $this->_con->set_charset("utf8mb4");

            } catch (mysqli_sql_exception $e) {

                // Log en Cloud Logging
                error_log("DB ERROR: " . $e->getMessage());

                // No mostrar detalles sensibles
                die("Error conectando a la base de datos.");
            }
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

// Páginas públicas
$publicPages = [
    'lgn.php'
];

// Bloqueo si no está logueado (solo web)
if (
    !$isApi &&
    !$isAjax &&
    !isset($_SESSION['ucoduser']) &&
    !in_array($currentPage, $publicPages)
) {
    header('Location: ' . SITE_URL . 'index.php');
    exit;
}
