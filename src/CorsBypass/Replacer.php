<?php

namespace JarirAhmed\CorsBypass;

class Replacer
{
    /**
     * Replace the index.php file in the Yii application.
     *
     * @param string $indexFilePath Path to the index.php file.
     * @return void
     * @throws \Exception If the index.php file does not exist or if the replacement fails.
     */
    public function replaceIndexFile($indexFilePath)
    {
        // Check if the original index.php file exists
        if (!file_exists($indexFilePath)) {
            throw new \Exception("The target index.php file does not exist at: $indexFilePath");
        }

        // Define the new index.php content
        $newIndexContent = <<<PHP
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

// Load the application configuration
\$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application(\$config))->run();
PHP;

        // Write the new content to index.php
        if (file_put_contents($indexFilePath, $newIndexContent) === false) {
            throw new \Exception("Failed to write the new index.php file at: $indexFilePath");
        }
    }
}
