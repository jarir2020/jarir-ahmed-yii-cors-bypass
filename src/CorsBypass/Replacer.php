<?php

namespace JarirAhmed\CorsBypass;

class Replacer
{
    /**
     * Automatically detect and replace the Yii web/index.php with the CORS-enabled version.
     *
     * @throws \Exception If the file cannot be copied or written.
     */
    public function replaceIndexFile()
    {
        // Detect the target path automatically based on the current script's directory
        $appRoot = realpath(__DIR__ . '/../../../../'); // Move up to the project root
        $targetPath = $appRoot . '/web/index.php'; // Append the web/index.php path

        if (!file_exists($targetPath)) {
            throw new \Exception("The target index.php file does not exist at: $targetPath");
        }

        if (!is_writable($targetPath)) {
            throw new \Exception("The target index.php file is not writable at: $targetPath");
        }

        $sourcePath = __DIR__ . '/../templates/index.php'; // The CORS-enabled index.php file

        if (!copy($sourcePath, $targetPath)) {
            throw new \Exception("Failed to replace the index.php file.");
        }
        
        echo "index.php file replaced successfully at: $targetPath\n";
    }
}
