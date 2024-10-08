<?php

namespace JarirAhmed\CorsBypass;

class Replacer
{
    /**
     * Replace the index.php file with the CORS-enabled version.
     *
     * @return void
     * @throws \Exception
     */
    public function replaceIndexFile()
    {
        // Use the getcwd() function to get the current working directory
        // and append the path to the web/index.php file
        $indexFilePath = getcwd() . '/index.php'; 

        // Check if the index.php file exists
        if (!file_exists($indexFilePath)) {
            throw new \Exception("The target index.php file does not exist at: " . $indexFilePath);
        }

        // Define the new content for the index.php file
        $newContent = <<<EOD
<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Access-Control-Allow-Origin");
header("Access-Control-Allow-Credentials: true");

if (\$_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

\$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application(\$config))->run();
EOD;

        // Attempt to replace the index.php file
        if (file_put_contents($indexFilePath, $newContent) === false) {
            throw new \Exception("Failed to write to index.php: " . $indexFilePath);
        }
    }
}
