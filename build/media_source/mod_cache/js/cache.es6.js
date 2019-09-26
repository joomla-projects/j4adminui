/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((Joomla, document) => {
  'use strict';
  if (!Joomla) {
    throw new Error('Joomla API not properly initialised');
  }
  const selectors = {
    clearBtn: '#jclear-cache-btn',
    cacheAnimationBtn: '.mod-extension-cache .j-cache-animation',
  };
  const theClearBtn = document.querySelector(selectors.clearBtn);
  const theCacheAnimationBtn = document.querySelector(selectors.cacheAnimationBtn);
  theClearBtn.addEventListener('click', (event) => {
    event.preventDefault();
    //$(this).data('id')
    const cacheurl = Joomla.getOptions('cacheurl');
    const cashsize = theClearBtn.getAttribute('data-size');
    const data = '';
    Joomla.request({
        url: cacheurl,
        method: 'POST',
        data,
        perform: true,
        onSuccess(res) {
          const response = typeof res === 'string' && res.length > 0 ? JSON.parse(res) : false;
          const data = response.data;
            if (data.status) {
              let currentCashSize = Math.round(cashsize);
              const clearedCashSize = 0;
              const interval = setInterval(function () {
                theCacheAnimationBtn.textContent = currentCashSize;
                if (currentCashSize <= clearedCashSize) {
                  clearInterval(interval);
                  // show success messages which getting from helper
                  Joomla.renderMessages({ message: [data.messsage] });
                }
                --currentCashSize;
              }, 1);
            }
        },
        onError(xhr) {
            Joomla.renderMessages({ error: [xhr.response] });
        },
    });
  });
})(window.Joomla, document);
