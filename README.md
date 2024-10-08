# Yii CORS Bypass

This package replaces the default `web/index.php` file of a Yii2 application with a version that includes CORS headers. It allows you to work seamlessly with React or Vue.js frontends.

## Installation

Run the following command to install the package via Composer:

```bash
composer require jarir-ahmed/yii-cors-bypass

## Useage
use JarirAhmed\CorsBypass\Replacer;
public function actionReplaceIndex()
  {
    // Create an instance of the Replacer class
    $replacer = new Replacer();

    try {
        // Replace the index.php file
        $replacer->replaceIndexFile();

        return $this->asJson(['message' => 'index.php replaced successfully']);
    } catch (\Exception $e) {
        return $this->asJson(['error' => 'Failed to replace index.php: ' . $e->getMessage()]);
    }
}
