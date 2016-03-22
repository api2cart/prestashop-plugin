<?php
/**
*  MagneticOne All rights reserved
*
*  @author    API2Cart <manager@magneticone.com>
*  @copyright 2008-2016 MagneticOne.com <contact@magneticone.com>
*  @license   MagneticOne
*  @link      https://www.api2cart.com
*/

class API2CartWorker
{
    public $rootPath = '';
    public $a2cBridgePath = '';
    public $currentFolder = '';
    public $errorMessage = '';
    public $configFilePath = '';
    public $bridgeFilePath = '';
    public $api2cartBridgePath = 'http://api.api2cart.com/v1.0/bridge.download.file';

    public function __construct()
    {
        $this->rootPath = dirname(_PS_MODULE_DIR_) . '/';
        $this->currentFolder = dirname(__FILE__) . '/';
        $this->a2cBridgePath = $this->rootPath . 'bridge2cart/';
        $this->configFilePath = $this->a2cBridgePath . 'config.php';
        $this->bridgeFilePath = $this->a2cBridgePath . 'bridge.php';
    }

    public function getStoreKey()
    {
        if (file_exists($this->configFilePath)) {
            require_once($this->configFilePath);
            return M1_TOKEN;
        }

        return false;
    }

    public function isBridgeExist()
    {
        if (is_dir($this->a2cBridgePath)
          && file_exists($this->bridgeFilePath)
          && file_exists($this->configFilePath)
        ) {
            return true;
        }

        return false;
    }

    public function installBridge()
    {
        if ($this->isBridgeExist()) {
            return true;
        }

        file_put_contents("bridge.zip", Tools::file_get_contents($this->api2cartBridgePath));
        $zip = new ZipArchive;

        $res = $zip->open("bridge.zip");

        if ($res === true) {
            $zip->extractTo($this->currentFolder);
            $zip->close();
        }

        return $this->xcopy($this->currentFolder . 'bridge2cart/', $this->rootPath . 'bridge2cart/');
    }

    public function unInstallBridge()
    {
        if (!$this->isBridgeExist()) {
            return true;
        }

        return $this->deleteDir($this->a2cBridgePath);
    }

    public function updateToken($token)
    {
        $config = @fopen($this->configFilePath, 'w');
        $write = fwrite($config, "<?php define('M1_TOKEN', '" . $token . "');");

        if (($config === false) || ($write === false) || (fclose($config) === false)) {
            return false;
        }

        return true;
    }

    private function deleteDir($dirPath)
    {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        $this->deleteDir($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        if (!unlink($dirPath . DIRECTORY_SEPARATOR . $object)) {
                            return false;
                        }
                    }
                }
            }

            reset($objects);

            if (!rmdir($dirPath)) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    private function xcopy($src, $dst)
    {
        $dir = opendir($src);

        if (!$dir || !mkdir($dst)) {
            return false;
        }

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->xcopy($src . '/' . $file, $dst . '/' . $file);
                } elseif (!copy($src . '/' . $file, $dst . '/' . $file)) {
                    $this->deleteDir($dst);
                    return false;
                }

                chmod($dst . $file, 0755);
                chmod($dst, 0755);
            }
        }

        closedir($dir);

        return true;
    }
}
