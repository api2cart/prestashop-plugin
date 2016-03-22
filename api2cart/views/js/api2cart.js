/**
 * License
 *
 * @author    MagneticOne
 *
 * @copyright MagneticOne
 *
 * @license   MagneticOne
 */

// load jQuery if not loaded yet
if(!window.jQuery){
  document.write('<script src="/modules/api2cart/views/js/jquery-2.0.3.min.js"></script>');
}

jQuery(window).load(function() {

  var messages = $('#messages');

  var installationsText = $('#connector-installed-txt');
  var contentBlockManage = $('#content-block-manage');

  var showButton = $("#showButton");
  var bridgeStoreKey = $('#bridgeStoreKey');
  var storeKey = $('#storeKey');
  var storeBlock = $('.store-key');
  var classMessage = $('.message');
  var progress = $('.progress');

  var timeDelay = 500;

  var api2cartConnectionInstall = $("#api2cartConnectionInstall");
  var api2cartConnectionUninstall = $("#api2cartConnectionUninstall");

  var updateBridgeStoreKey = $('#updateBridgeStoreKey');

  if (showButton.val() == 'install') {
    installationsText.show();
    contentBlockManage.hide();
    storeBlock.fadeOut();
    updateBridgeStoreKey.hide();
    api2cartConnectionUninstall.hide();
    api2cartConnectionInstall.show();
  } else {
    installationsText.hide();
    contentBlockManage.show();
    storeBlock.fadeIn();
    updateBridgeStoreKey.show();
    api2cartConnectionInstall.hide();
    api2cartConnectionUninstall.show();
  }

  function message(message,status) {
    if (status == 'success') {
      classMessage.html('<span>' + message + '</span>');
      classMessage.fadeIn("slow");
      classMessage.fadeOut(5000);

      var messageClear = setTimeout(function(){
        classMessage.html('');
      }, 3000);
      clearTimeout(messageClear);
    }
  }

  $('.btn-setup').click(function() {
    var self = $(this);
    $(this).attr("disabled", true);
    progress.slideDown("fast");
    var install = 'install';
    if (showButton.val() == 'uninstall') {
      install = 'remove';
    } else {
      updateStoreKey();
    }

    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: {
        ajax: true,
        method: install + 'Bridge',
        storeKey: storeKey.html(),
        action: 'APIRequest'
      },
      success: function(json){
        var live_str = $('<div>',{html:json});
        var found = live_str.find('#jsonResultAjax').text();
        json = JSON.parse(found);

        self.attr("disabled", false);
        progress.slideUp("fast");

        if (json.result.install) {
          installationsText.fadeOut(timeDelay);
          contentBlockManage.delay(timeDelay).fadeIn(timeDelay);
          storeBlock.fadeIn("slow");
          updateBridgeStoreKey.fadeIn("slow");
          showButton.val('uninstall');
          api2cartConnectionInstall.hide();
          api2cartConnectionUninstall.show();
          message('Connector Installed Successfully','success');
        } else {
          contentBlockManage.fadeOut(timeDelay);
          installationsText.delay(timeDelay).fadeIn(timeDelay);
          storeBlock.fadeOut("slow");
          updateBridgeStoreKey.fadeOut("slow");
          showButton.val('install');
          api2cartConnectionUninstall.hide();
          api2cartConnectionInstall.show();
          message('Connector Uninstalled Successfully','success');
        }
      }
    })
  });

  updateBridgeStoreKey.click(function(){
    updateStoreKey();
    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: {
        ajax: true,
        method: 'updateToken',
        storeKey: storeKey.html(),
        action: 'APIRequest'
      },
      success: function(json){
        var live_str = $('<div>',{html:json});
        var found = live_str.find('#jsonResultAjax').text();
        json = JSON.parse(found);

        if (json.result.storeKeyUpdate) {
          message('Connector Updated Successfully', 'success');
        } else {
          message('Connector has not been Updated', 'success');
        }
      }
    });
  });

  function updateStoreKey(){
    storeKey.html(hex_md5('api2cart_'+$.now()));
  }

});