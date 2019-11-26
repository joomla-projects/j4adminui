document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const dragulaFinders = document.querySelectorAll('.js-enable-dragula');
  for (let i = 0, l = dragulaFinders.length; l > i; i += 1) {
    const dragulaFinder = dragulaFinders[i];

    if (dragulaFinder) {
      let elements = dragulaFinder.getAttribute('data-containers');
      elements = elements.split(',');
      const container = [];
      elements.forEach((el) => {
        container.push(dragulaFinder.querySelector(el));
      });

      // Get the request url
      let url = null;
      if (dragulaFinder.hasAttribute('data-url-quickicon')) {
        url = dragulaFinder.getAttribute('data-url-quickicon');
      } else if (dragulaFinder.hasAttribute('data-url-card')) {
        url = dragulaFinder.getAttribute('data-url-card');
      }
      //   const url = dragulaFinder.getAttribute('data-url');
      let dataFields = dragulaFinder.getAttribute('data-fields');
      if (typeof dataFields !== 'undefined' && dataFields !== '') {
        dataFields = dataFields.split(',');
      }

      // eslint-disable-next-line no-undef
      dragula(container, {
        direction: 'vertical', // Y axis is considered when determining where an element would be dropped
        copy: false, // elements are moved by default, not copied
        moves: (el, source, handle) => handle.classList.contains('handle') || el.classList.contains('handle'),
      })
        .on('drop', (el, target) => {
          if (url) {
            // Set position of the modules
            if (el && target) {
              if (target.hasAttribute('data-position')) {
                if (target.getAttribute('data-position') === 'left') {
                  if (el.querySelector('input[name="position[]"]')) {
                    el.querySelector('input[name="position[]"]').value = '0';
                  }
                } else if (target.getAttribute('data-position') === 'right') {
                  if (el.querySelector('input[name="position[]"]')) {
                    el.querySelector('input[name="position[]"]').value = '1';
                  }
                }
              }
            }

            // Re-ordering the modules
            let order = 1;

            // Get left and right columns modules
            const leftCol = document.querySelector('#cpanel-left-col');
            const rightCol = document.querySelector('#cpanel-right-col');

            // Get ordering fields
            const leftColOrderField = leftCol.querySelectorAll('input[name="order[]"]');
            const rightColOrderField = rightCol.querySelectorAll('input[name="order[]"]');

            // Update the order value
            leftColOrderField.forEach((orderEl) => {
              orderEl.value = order;
              order += 1;
            });

            rightColOrderField.forEach((orderEl) => {
              orderEl.value = order;
              order += 1;
            });

            const data = [];
            // Collect all field data if dataFields are available
            if (dataFields.length > 0) {
              dataFields.forEach((field) => {
                const inputField = dragulaFinder.querySelectorAll(`input[name="${field}"]`);
                if (inputField.length > 1) {
                  inputField.forEach((item) => {
                    data.push(`${field}=${item.value}`);
                  });
                }
                if (inputField.length === 1) {
                  data.push(`${field}=${inputField[0].value}`);
                }
              });

              // Prepare the options
              const ajaxOptions = {
                url,
                method: 'POST',
                data: data.join('&'),
                perform: true,
              };

              // Call ajax for update order
              Joomla.request(ajaxOptions);
            }
          }
        });
    }
  }
});
