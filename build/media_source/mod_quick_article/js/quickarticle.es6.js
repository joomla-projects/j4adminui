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
    form: '#form-quick-article',
    submitBtn: '#mod-quick-article-submit',
    clearBtn: '#mod-quick-article-clear',
    descriptionField: '#mod-quick-article-description',
    titleField: '#mod-quick-article-title',
  };


  function serialiseForm(form) {
    const obj = [];
    const elements = form.querySelectorAll('input, select, textarea');
    for (let i = 0, l = elements.length; i < l; i += 1) {
      const { name, value } = elements[i];
      if (name) {
        if ((elements[i].type === 'checkbox' && elements[i].checked === true) || (elements[i].type !== 'checkbox')) {
          obj.push(`${name.replace('[', '%5B').replace(']', '%5D')}=${encodeURIComponent(value)}`);
        }
      }
    }
    return obj.join('&');
  }

  const theForm = document.querySelector(selectors.form);
  const theClearnBtn = document.querySelector(selectors.clearBtn);

  theClearnBtn.addEventListener('click', (event) => {
    event.preventDefault();

    document.querySelector(selectors.descriptionField).value = '';
    document.querySelector(selectors.titleField).value = '';
  });


  theForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const saveurl = Joomla.getOptions('saveurl');
    const editurl = Joomla.getOptions('editurl');
    const data = serialiseForm(theForm);

    Joomla.request({
      url: saveurl,
      method: 'POST',
      data,
      perform: true,
      onSuccess(res) {
        const response = typeof res === 'string' && res.length > 0 ? JSON.parse(res) : false;
        if (response) {
          window.location.href = `${editurl}${response.data}`;
        }
      },
      onError(xhr) {
        Joomla.renderMessages({ error: [xhr.response] });
      },
    });
  });
})(window.Joomla, document);
