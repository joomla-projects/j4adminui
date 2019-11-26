document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const dragulaFinders = document.querySelectorAll('.js-enable-dragula');
  for (let i = 0; i < dragulaFinders.length; i += 1) {
    const dragulaFinder = dragulaFinders[i];
    if (dragulaFinder) {
      let elements = dragulaFinder.getAttribute('data-containers');
      elements = elements.split(',');
      const container = [];

      elements.forEach((el) => {
        container.push(dragulaFinder.querySelector(el));
      });
      const url = dragulaFinder.getAttribute('data-url');
      let dataFields = dragulaFinder.getAttribute('data-fields');
      if (typeof dataFields !== 'undefined' && dataFields !== '') {
        dataFields = dataFields.split(',');
      }
      // eslint-disable-next-line no-undef
      dragula(container, {
        direction: 'vertical', // Y axis is considered when determining where an element would be dropped
        copy: false, // elements are moved by default, not copied
      })
        .on('drop', () => {
          if (url) {
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
