/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document, Joomla) => {
  'use strict';

  /**
   * Every quickicon with an ajax request url loads data and set them into the counter element
   * Also the data name is set as singular or plural.
   * A SR-only text ist added
   * The class pulse gets 'warning', 'success' or 'error', depending on the retrieved data.
   */
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.joomla-collapse-card-body').forEach((card) => {
      card.addEventListener('click', (event) => {
        event.preventDefault();
        const targetBody = document.getElementById(card.getAttribute('data-target'));
        if (targetBody) {
          if (targetBody.classList.contains('collapse-in')) {
            targetBody.classList.remove('collapse-in');
          } else {
            targetBody.classList.add('collapse-in');
          }
        }
      });
    });
    function numberFormatter(num, digits) {
      // eslint-disable-next-line no-restricted-globals
      if (isNaN(num)) {
        return num;
      }
      const si = [
        { value: 1, symbol: '' },
        { value: 1E3, symbol: 'k' },
        { value: 1E6, symbol: 'M' },
        { value: 1E9, symbol: 'G' },
        { value: 1E12, symbol: 'T' },
        { value: 1E15, symbol: 'P' },
        { value: 1E18, symbol: 'E' },
      ];
      const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
      let i;
      for (i = si.length - 1; i > 0; i -= 1) {
        if (num >= si[i].value) {
          break;
        }
      }
      return (num / si[i].value).toFixed(digits).replace(rx, '$1') + si[i].symbol;
    }
    document.querySelectorAll('.j-quickicon').forEach((quickicon) => {
      const pulse = quickicon.querySelector('.pulse');
      quickicon.classList.add('j-skeleton');
      const counterAnimate = quickicon.querySelector('.j-counter-animation');
      if (quickicon.dataset.url) {
        Joomla.request({
          url: quickicon.dataset.url,
          method: 'GET',
          onSuccess: ((resp) => {
            const response = JSON.parse(resp);
            quickicon.removeAttribute('data-loading');
            quickicon.classList.remove('j-skeleton');

            if (typeof response.data !== 'undefined') {
              if (pulse) {
                const className = response.data > 0 ? 'warning' : 'success';
                pulse.classList.add(className);
              }
              if (response.data > 0) {
                quickicon.setAttribute('data-status', 'warning');
              } else {
                quickicon.setAttribute('data-status', 'success');
              }
              // Set amount of number into counter span
              // counterAnimate.textContent = numberFormatter(response.data.amount, 1);
              counterAnimate.textContent = `\u200E${numberFormatter(response.data.amount, 1)}`;

              // Insert screenreader text
              const sronly = quickicon.querySelector('.quickicon-sr-desc');

              if (response.data.sronly && sronly) {
                sronly.textContent = response.data.sronly;
              }
            } else {
              quickicon.setAttribute('data-status', 'danger');
            }
          }),
          onError: (() => {
            quickicon.setAttribute('data-status', 'danger');
          }),
        });
      }
    });
  });
})(document, Joomla);
