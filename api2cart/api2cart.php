<?php
/**
*  MagneticOne All rights reserved
*
*  @author    API2Cart <manager@magneticone.com>
*  @copyright 2008-2016 MagneticOne.com <contact@magneticone.com>
*  @license   MagneticOne
*  @link      https://www.api2cart.com
*/

require_once(dirname(__FILE__) . '/../../config/config.inc.php');
require_once(dirname(__FILE__) . '/../../init.php');
require_once(dirname(__FILE__) . '/worker.php');

if (!defined('_PS_VERSION_')) {
    exit;
}

class Api2Cart extends Module
{
    public function __construct()
    {
        $this->name = 'api2cart';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'API2Cart';
        $this->cart_name = 'Prestashop';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.4', 'max' => '1.6');

        $this->module_key = '556178f67c4672bdaa771240818abed3';
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        parent::__construct();

        $this->displayName = $this->l('API2Cart');
        $this->description = $this->l('Plugin for download bridge files');
    }

    public function ajaxProcessAPIRequest()
    {
        $worker = new API2CartWorker();
        $returnData = array(
            'install' => false,
            'storeKeyUpdate' => false,
            'remove' => false,
        );

        switch (Tools::getValue('method')) {
            case 'installBridge':
                $returnData['install'] = $worker->installBridge();
                $returnData['storeKeyUpdate'] = $worker->updateToken(Tools::getValue('storeKey'));
                break;

            case 'removeBridge':
                $returnData['remove'] = $worker->unInstallBridge();
                break;

            case 'updateToken':
                $returnData['storeKeyUpdate'] = $worker->updateToken(Tools::getValue('storeKey'));
        }

        die('<div id="jsonResultAjax">' . Tools::jsonEncode(array('result' => $returnData)) . '</div>');
    }

    public function install()
    {
        return parent::install();
    }

    public function displayOutput()
    {
        return $this->display(__FILE__, 'header.tpl');
    }

    public function getContent()
    {
        if (Tools::getValue('action') == 'APIRequest') {
            $this->ajaxProcessAPIRequest();
        }

        $worker = new API2CartWorker();
        $showButton = 'install';
        $storeKey = '';

        if ($worker->isBridgeExist()) {
            $storeKey = $worker->getStoreKey();
            $showButton = 'uninstall';
        }

        $prestashopVersion = (float)_PS_VERSION_;

        if ($prestashopVersion >= 1.5) {
            $this->smarty->assign(array(
                'logoUrl' => $this->_path . 'views/img/logo.png',
                'showButton' => $showButton,
                'storeKey' => $storeKey,
                'cartName' => $this->cart_name
            ));

            $this->context->controller->addCSS($this->_path . 'views/css/main.css', 'all');
            $this->context->controller->addJS($this->_path . 'views/js/api2cart.js');
            $this->context->controller->addJS($this->_path . 'views/js/md5-min.js');

            $html = '
            <script type="text/javascript">
            var ajaxUrl = "' . $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '";
            </script>
            ';
        } else {
            global $smarty;
            $smarty->assign(array(
                'logoUrl' => $this->_path . 'views/img/logo.png',
                'showButton' => $showButton,
                'storeKey' => $storeKey,
                'cartName' => $this->cart_name
            ));

            $html = '
            <script type="text/javascript">
                var ajaxUrl = "' . $_SERVER['REQUEST_URI'] . '";
            </script>
            <link rel="stylesheet" type="text/css" href="' . $this->_path . 'views/css/main.css">
            <script type="text/javascript" src="' . $this->_path . 'views/js/api2cart.js"></script>
            <script type="text/javascript" src="' . $this->_path . 'views/js/md5-min.js"></script>
            ';
        }

        return $html . $this->displayOutput();
    }
}
