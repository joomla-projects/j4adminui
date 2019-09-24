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
  };
  const theClearnBtn = document.querySelector(selectors.clearBtn);
  theClearnBtn.addEventListener('click', (event) => {
    event.preventDefault();
    const cacheurl = Joomla.getOptions('cacheurl');
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
              // show success messages which get from helper
              Joomla.renderMessages({ message: [data.messsage]});
            }
        },
        onError(xhr) {
            Joomla.renderMessages({ error: [xhr.response] });
        },
    });
  });
})(window.Joomla, document);
