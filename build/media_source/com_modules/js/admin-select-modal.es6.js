/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    // search modules
    const inputField = document.querySelector('#j-search-cpanel-module');
    const moduleOptions = Joomla.getOptions('modules') || [];
    
    const modules = moduleOptions.items;
    const modulesContainer = document.querySelector('#new-modules-list');

    /**
     * Find match modules
     * @param {string} keyword - search keyword
     * @return {Array} match modules
     * 
     * @since 4.0.0
     */
    const findMatches = (keyword) => {
      const keywords = keyword.split(' ').join('|');
      const regex = new RegExp(keywords);
      return modules.filter(module => {
        if (regex.test(module.name.toLowerCase())) {
          return module;
        }
      });
    };

    /**
     * Render filtered modules
     * @param {Array} items - filtered modules
     * @return {string} html string
     * 
     * @since 4.0.0
     */
    const renderModules = (items) => {
      items = typeof items == 'object' && items instanceof Array && items.length > 0 ? items : false;
      let html = '<div class="row">';
      if (!!items) {
        items.forEach(item => {
          let link = `${moduleOptions.routeUrl}?option=com_modules&task=module.add&client_id=${moduleOptions.clientId}${moduleOptions.modalLink}&eid=${item.extension_id}`;
          let description = (typeof item.desc != 'undefined' && item.desc.length > 0) ? item.desc.substring(0, Math.min(200, item.desc.length)) : '';
          description = description.length === item.desc.length ? description : description + '...';

          html += `
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="j-card mb-4">
                <div class="j-card-header">
                  <strong>${item.name}</strong>
                </div>
      
                <div class="j-card-body">
                  <p class="text-muted m-0">
                    ${description}
                  </p>
                </div>
      
                <div class="j-card-footer">
                  <div class="j-card-footer-item">
                    <a href="${link}" class="${moduleOptions.functionPlain ? ' select-link' : ''}" data-function="${moduleOptions.functionPlain ? moduleOptions.functionEscape : ''}" >
                      ${Joomla.Text._('COM_MODULES_SELECT')}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          `;

        });
      } else {
        html += `
        <div class="col">
          <div class="j-alert j-alert-info d-flex">
            <div class="j-alert-icon-wrap"><span class="icon-info-circle" aria-hidden="true"></span><span class="sr-only">Info</span></div>
            <div class="j-alert-info-wrap">No Matching Results</div>
          </div>
        </div>
        `;
      }
      html += '</div>'; // end row

      return html;
    };
    
    if (inputField) {
      let timeout;
      inputField.addEventListener('keyup', (event) => {
        event.preventDefault();
        
        if (timeout) clearTimeout(timeout);
        let value = event.target.value;

        // wait 250ms before executing the task
        timeout = setTimeout(() => {
          let newList = findMatches(value);
          modulesContainer.innerHTML = renderModules(newList);
        }, 250);
        
      });
    }


    const elems = document.querySelectorAll('#new-modules-list a.select-link');

    elems.forEach((elem) => {
      elem.addEventListener('click', (event) => {
        let targetElem = event.currentTarget;

        // There is some bug with events in iframe where currentTarget is "null"
        // => prevent this here by bubble up
        if (!targetElem) {
          targetElem = event.target;

          if (targetElem && !targetElem.classList.contains('select-link')) {
            targetElem = targetElem.parentNode;
          }
        }

        const functionName = targetElem.getAttribute('data-function');

        if (functionName && typeof window.parent[functionName] === 'function') {
          window.parent[functionName](targetElem);
        }
      });
    });
  });
})(document);
