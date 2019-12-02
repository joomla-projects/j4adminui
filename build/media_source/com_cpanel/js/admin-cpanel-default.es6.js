/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((window, document, Joomla) => {
  let matchesFn = 'matches';

  const closest = (element, selector) => {
    let parent;
    let el = element;

    // Traverse parents
    while (el) {
      parent = el.parentElement;
      if (parent && parent[matchesFn](selector)) {
        return parent;
      }
      el = parent;
    }

    return null;
  };

  Joomla.unpublishModule = (element) => {
    // Get variables
    const baseUrl = 'index.php?option=com_modules&task=modules.unpublish&format=json';
    const id = element.getAttribute('data-module-id');

    Joomla.request({
      url: `${baseUrl}&cid=${id}`,
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      onSuccess: () => {
        const wrapper = closest(element, '.module-wrapper');
        wrapper.parentNode.removeChild(wrapper);

        Joomla.renderMessages({
          message: [Joomla.JText._('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS')],
        });
      },
      onError: () => {
        Joomla.renderMessages({
          error: [Joomla.JText._('COM_CPANEL_UNPUBLISH_MODULE_ERROR')],
        });
      },
    });
  };

  /**
   * Expand/collapse card body
   *
   * @param   {HTMLElement}   card  Card element
   *
   * @since   4.0.0
   */
  const toggleCard = (card) => {
    card.addEventListener('click', (event) => {
      event.preventDefault();
      const targetBody = document.getElementById(card.getAttribute('data-target'));
      const { currentTarget: el } = event;

      if (el) {
        // Toggle aria-expanded attribute
        if (el.hasAttribute('aria-expanded')) {
          if (el.getAttribute('aria-expanded') === 'true') {
            el.setAttribute('aria-expanded', 'false');
          } else {
            el.setAttribute('aria-expanded', 'true');
          }
        }

        // Toggle collapse icon
        const icon = el.querySelector('span.toggle-icon');
        if (icon) {
          if (icon.classList.contains('icon-chevron-down')) {
            icon.classList.remove('icon-chevron-down');
            icon.classList.add('icon-chevron-up');
          } else {
            icon.classList.remove('icon-chevron-up');
            icon.classList.add('icon-chevron-down');
          }
        }
      }

      if (targetBody) {
        if (targetBody.classList.contains('collapse-in')) {
          targetBody.classList.remove('collapse-in');
        } else {
          targetBody.classList.add('collapse-in');
        }
      }
    });
  };


  const onBoot = () => {
    // Find matchesFn with vendor prefix
    ['matches', 'msMatchesSelector'].some((fn) => {
      if (typeof document.body[fn] === 'function') {
        matchesFn = fn;
        return true;
      }
      return false;
    });

    // Get the dashboard's card elements
    const cpanelCards = document.querySelectorAll('.joomla-collapse-card-body');
    if (cpanelCards) {
      cpanelCards.forEach((card) => {
        toggleCard(card);
      });
    }

    const cpanelModules = document.getElementById('cpanel-modules');
    if (cpanelModules) {
      const links = [].slice.call(cpanelModules.querySelectorAll('.unpublish-module'));
      links.forEach((link) => {
        link.addEventListener('click', event => Joomla.unpublishModule(event.target));
      });
    }

    // Cleanup
    document.removeEventListener('DOMContentLoaded', onBoot);
  };

  // Initialise
  document.addEventListener('DOMContentLoaded', onBoot);
})(window, document, window.Joomla);
