/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
Joomla = window.Joomla || {};

((document) => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    window.jSelectModuleType = () => {
      const elements = document.querySelectorAll('#moduleDashboardAddModal footer .btn.hidden');
      if (elements.length) {
        setTimeout(() => {
          elements.forEach((button) => {
            button.classList.remove('hidden');
          });
        }, 1000);
      }
    };
    let hideButtons = [];
    let isSaving = false;
    document.getElementById('moduleDashboardAddModal').addEventListener('joomla.modal.show', () => {
      const buttons = document.querySelectorAll('#moduleDashboardAddModal footer .btn');
      hideButtons = [];
      if (buttons.length) {
        buttons.forEach((button) => {
          if (button.classList.contains('hidden')) {
            hideButtons.push(button);
          }
          // eslint-disable-next-line consistent-return
          button.addEventListener('click', (event) => {
            let elem = event.currentTarget;
            // There is some bug with events in iframe where currentTarget is "null"
            // => prevent this here by bubble up
            if (!elem) {
              elem = event.target;
            }
            if (elem) {
              const clickTarget = elem.getAttribute('data-target');
              if (clickTarget === null) {
              // eslint-disable-next-line no-console
                console.warn('Save Target Missting!');
                return false;
              }
              // We remember to be in the saving process
              isSaving = clickTarget === '#saveBtn';

              // Reset saving process, if e.g. the validation of the form fails
              setTimeout(() => { isSaving = false; }, 1500);

              const iframe = document.querySelector('#moduleDashboardAddModal iframe');
              const content = iframe.contentDocument || iframe.contentWindow.document;

              content.querySelector(clickTarget).click();
            }
          });
        });
      }
    });

    document.getElementById('moduleDashboardAddModal').addEventListener('joomla.modal.close', () => {
      hideButtons.forEach((button) => {
        button.classList.add('hidden');
      });
    });
    document.getElementById('moduleDashboardAddModal').addEventListener('joomla.modal.closed', () => {
      if (isSaving) {
        setTimeout(() => { window.parent.location.reload(); }, 1000);
      }
    });
  });
})(document);
