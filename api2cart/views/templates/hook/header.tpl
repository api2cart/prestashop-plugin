{*-----------------------------------------------------------------------------+
| MagneticOne                                                                  |
| Copyright (c) 2008 MagneticOne.com <contact@magneticone.com>                 |
| All rights reserved                                                          |
+------------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "license.txt"|
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE   |
| AT THE FOLLOWING URL: http://www.magneticone.com/store/license.php           |
|                                                                              |
| THIS  AGREEMENT  EXPRESSES  THE  TERMS  AND CONDITIONS ON WHICH YOU MAY USE  |
| THIS SOFTWARE   PROGRAM   AND  ASSOCIATED  DOCUMENTATION   THAT  MAGNETICONE |
| (hereinafter  referred to as "THE AUTHOR") IS FURNISHING  OR MAKING          |
| AVAILABLE TO YOU WITH  THIS  AGREEMENT  (COLLECTIVELY,  THE  "SOFTWARE").    |
| PLEASE   REVIEW   THE  TERMS  AND   CONDITIONS  OF  THIS  LICENSE AGREEMENT  |
| CAREFULLY   BEFORE   INSTALLING   OR  USING  THE  SOFTWARE.  BY INSTALLING,  |
| COPYING   OR   OTHERWISE   USING   THE   SOFTWARE,  YOU  AND  YOUR  COMPANY  |
| (COLLECTIVELY,  "YOU")  ARE  ACCEPTING  AND AGREEING  TO  THE TERMS OF THIS  |
| LICENSE   AGREEMENT.   IF  YOU    ARE  NOT  WILLING   TO  BE  BOUND BY THIS  |
| AGREEMENT, DO  NOT INSTALL OR USE THE SOFTWARE.  VARIOUS   COPYRIGHTS   AND  |
| OTHER   INTELLECTUAL   PROPERTY   RIGHTS    PROTECT   THE   SOFTWARE.  THIS  |
| AGREEMENT IS A LICENSE AGREEMENT THAT GIVES  YOU  LIMITED  RIGHTS   TO  USE  |
| THE  SOFTWARE   AND  NOT  AN  AGREEMENT  FOR SALE OR FOR  TRANSFER OF TITLE. |
| THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY GRANTED BY THIS AGREEMENT.       |
|                                                                              |
| The Developer of the Code is MagneticOne,                                    |
| Copyright (C) 2006 - ${YEAR} All Rights Reserved.                            |
+-----------------------------------------------------------------------------*/

/**
* @package  api2cart
* @author   MagneticOne
* @license  MagneticOne
* @link     https://www.api2cart.com
*}

<div class="api2cart">
  <div class="message"></div>
  <div class="text-center">
    <a target="_blank" href="https://www.api2cart.com">
      <img src="{$logoUrl|escape:'htmlall':'UTF-8'}" alt="API2Cart - Unified Shopping Cart API Integration Interface">
    </a>
  </div>
  <div class="text-center">
    <p>API2Cart is a unified platform to integrate with 30+ shopping carts including Magento, Shopify, WooCommerce, Bigcommerce, OpenCart, VirtueMart and others. It makes it easy to retrieve, add, delete, update, and synchronize such store data as customers, orders, products, and categories to provide different B2B services. </p>
  </div>

  <div class="container">

    <div class="text-center">
      <p id="connector-installed-txt">The connector will be installed automatically. Just click the button below and have the connection between your <?php echo $cartName; ?> store and the system needed established.</p>
      <div id="content-block-manage">
        <b>Congratulations! The plugin is installed!</b><br><br>

        <ul class="list-create-account">
          <li>To complete the connection process, follow the few steps listed below:</li>
          <li>1) Create an API2Cart account.</li>
          <li>2) Add your store to the store panel by indicating its URL and cart type.</li>
          <li>3) Voila! The connection between your PrestaShop store and API2Cart is established!</li>
        </ul>
        <br>
        <b>Please note.</b> Store data interaction only works if you are integrated with the service.
        It allows to get, synchronize, and manipulate various information on customers, products, categories, and orders from the stores added to the directory.
        For more information, schedule a call with our representative and have the details explained to you.
        <br>
      </div>
    </div>

    <div class="text-center">

      <div class="progress progress-dark progress-small progress-striped active">
        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <div class="store-key">
        <span class="store-key-title">Your store key:</span>
        <span class="store-key-content" id="storeKey">{$storeKey|escape:'htmlall':'UTF-8'}</span>
        <button id="updateBridgeStoreKey" class="btn-update-store-key">Update Store Key</button>
      </div>

      <button id="api2cartConnectionUninstall" class="btn-disconnect btn-setup">Disconnect</button>
      <button id="api2cartConnectionInstall" class="btn-connect btn-setup">Connect</button>

    </div>

    <input type="hidden" id="showButton" value="{$showButton|escape:'htmlall':'UTF-8'}">

    <div class="clearfix"></div>
  </div>
</div>