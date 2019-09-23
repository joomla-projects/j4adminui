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
    //console.log(event);


    const cacheurl = Joomla.getOptions('cacheurl');
    //const data = serialiseForm(theForm);
    const data = '';

    Joomla.request({
        url: cacheurl,
        method: 'POST',
        data,
        perform: true,
        onSuccess(res) {
            //const response = typeof res === 'array' && res.length > 0 ? JSON.parse(res) : false;
            console.log(res);

            // if (response) {
            // //window.location.href = `${editurl}${response.data}`;
            // }
        },
        onError(xhr) {
            Joomla.renderMessages({ error: [xhr.response] });
        },

        // document.querySelector(selectors.descriptionField).value = '';
        // document.querySelector(selectors.titleField).value = '';
    });

});

})(window.Joomla, document);
