document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const dragContainer = document.querySelectorAll('.js-draggable-container');

  dragContainer.forEach((container) => {
    const url = container.getAttribute('data-url');
    let dataFields = container.getAttribute('data-fields');
    if (typeof dataFields !== 'undefined' && dataFields !== '') {
      dataFields = dataFields.split(',');
    }
    // eslint-disable-next-line no-undef
    dragula([container], {
      direction: 'vertical', // Y axis is considered when determining where an element would be dropped
      copy: false, // elements are moved by default, not copied
    })
      .on('drop', () => {
        if (url) {
          const data = [];
          // Collect all field data if dataFields are available
          if (dataFields.length > 0) {
            dataFields.forEach((field) => {
              const inputField = container.querySelectorAll(`input[name="${field}"]`);
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
  });
});
