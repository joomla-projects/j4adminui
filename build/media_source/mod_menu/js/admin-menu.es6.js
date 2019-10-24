/* eslint-disable no-undef */
/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
((Joomla, document) => {
  'use strict';

  /**
   * Check if HTML5 localStorage enabled on the browser
   *
   * @since   4.0.0
   */
  Joomla.localStorageEnabled = () => {
    const test = 'joomla-cms';
    try {
      localStorage.setItem(test, test);
      localStorage.removeItem(test);
      return true;
    } catch (e) {
      return false;
    }
  };

  const closest = (element, selector) => {
    let matchesFn;
    let parent;

    // find vendor prefix
    ['matches', 'msMatchesSelector'].some((fn) => {
      if (typeof document.body[fn] === 'function') {
        matchesFn = fn;
        return true;
      }
      return false;
    });

    // Traverse parents
    while (element) {
      parent = element.parentElement;
      if (parent && parent[matchesFn](selector)) {
        return parent;
      }
      // eslint-disable-next-line no-param-reassign
      element = parent;
    }

    return null;
  };

  const wrapper = document.getElementById('wrapper');
  const sidebar = document.getElementById('sidebar-wrapper');
  const menuToggleIcon = document.getElementById('menu-collapse-icon');
  const documentContainer = document.querySelector('.container-main');
  // If the sidebar doesn't exist, for example, on edit views, then remove the "closed" class
  if (!sidebar) {
    wrapper.classList.remove('main-sidebar-collapsed');
  }
  if (wrapper) {
    if (documentContainer && !wrapper.classList.contains('main-sidebar-collapsed')) {
      documentContainer.classList.add('menu-collapsed');
    }
  }
  if (sidebar) {
    // Sidebar
    const menuToggle = document.getElementById('menu-collapse');
    const firsts = [].slice.call(sidebar.querySelectorAll('.collapse-level-1'));

    // Apply 2nd level collapse
    firsts.forEach((first) => {
      const seconds = [].slice.call(first.querySelectorAll('.collapse-level-1'));
      seconds.forEach((second) => {
        if (second) {
          second.classList.remove('collapse-level-1');
          second.classList.add('collapse-level-2');
        }
      });
    });

    const menuClose = () => {
      sidebar.querySelector('.collapse').classList.remove('in');
    };
    if (typeof menuToggle !== 'undefined' && menuToggle !== null) {
    // Toggle menu
      menuToggle.addEventListener('click', () => {
        wrapper.classList.toggle('main-sidebar-collapsed');
        menuToggleIcon.classList.toggle('icon-angle-double-left');
        menuToggleIcon.classList.toggle('icon-angle-double-right');
        if (documentContainer) {
          documentContainer.classList.toggle('menu-collapsed');
        }
        const listItems = [].slice.call(document.querySelectorAll('.main-nav > li'));
        listItems.forEach((item) => {
          item.classList.remove('open');
        });
        const elem = document.querySelector('.child-open');
        if (elem) {
          elem.classList.remove('child-open');
        }

        // Save the sidebar state and dispatch event
        if (wrapper.classList.contains('main-sidebar-collapsed')) {
          if (typeof Joomla.Cookies !== 'undefined') {
            Joomla.Cookies.set('main-sidebar', 'closed', 31536000, '/', '');
          }
          Joomla.Event.dispatch('joomla:menu-toggle', 'closed');
        } else {
          if (typeof Joomla.Cookies !== 'undefined') {
            Joomla.Cookies.set('main-sidebar', 'open', 31536000, '/', '');
          }
          Joomla.Event.dispatch('joomla:menu-toggle', 'open');
        }
      });
    }


    /**
     * Sidebar Nav
     */
    const allLinks = wrapper.querySelectorAll('a.no-dropdown, a.collapse-arrow, .menu-dashboard > a');
    const currentUrl = window.location.href.toLowerCase();
    const mainNav = document.getElementById('menu');
    const menuParents = [].slice.call(mainNav.querySelectorAll('li.parent > a'));
    const subMenusClose = [].slice.call(mainNav.querySelectorAll('li.parent .close'));

    // Set active class
    allLinks.forEach((link) => {
      if (currentUrl === link.href) {
        link.classList.add('active');
        // Auto Expand Levels
        if (!link.parentNode.classList.contains('parent')) {
          const firstLevel = closest(link, '.collapse-level-1');
          const secondLevel = closest(link, '.collapse-level-2');
          if (firstLevel) firstLevel.parentNode.classList.add('active');
          if (secondLevel) secondLevel.parentNode.classList.add('active');
        }
      }
    });

    // Child open toggle
    const openToggle = (event) => {
      let menuItem = event.currentTarget.parentNode;

      if (menuItem.tagName.toLowerCase() === 'span') {
        menuItem = event.currentTarget.parentNode.parentNode;
      }

      if (menuItem.classList.contains('open')) {
        mainNav.classList.remove('child-open');
        menuItem.classList.remove('open');
      } else {
        const siblings = [].slice.call(menuItem.parentNode.children);
        siblings.forEach((sibling) => {
          sibling.classList.remove('open');
        });

        wrapper.classList.remove('main-sidebar-collapsed');
        if (typeof Joomla.Cookies !== 'undefined') {
          Joomla.Cookies.set('main-sidebar', 'open', 31536000, '/');
        }
        if (menuToggleIcon.classList.contains('icon-angle-double-right')) {
          menuToggleIcon.classList.toggle('icon-angle-double-right');
          menuToggleIcon.classList.toggle('icon-angle-double-left');
        }
        mainNav.classList.add('child-open');

        if (menuItem.parentNode.classList.contains('main-nav')) {
          menuItem.classList.add('open');
        }
      }
      Joomla.Event.dispatch('joomla:menu-toggle', 'open');
    };

    menuParents.forEach((parent) => {
      parent.addEventListener('click', openToggle);
      parent.addEventListener('keyup', openToggle);
    });

    // Menu close
    subMenusClose.forEach((subMenu) => {
      subMenu.addEventListener('click', () => {
        const menuChildsOpen = [].slice.call(mainNav.querySelectorAll('.open'));

        menuChildsOpen.forEach((menuChild) => {
          menuChild.classList.remove('open');
        });

        mainNav.classList.remove('child-open');
      });
    });

    // Accessibility
    const allLiEls = [].slice.call(sidebar.querySelectorAll('ul[role="menubar"] li'));
    allLiEls.forEach((liEl) => {
      // We care for enter and space
      liEl.addEventListener('keyup', (e) => {
        if (e.keyCode === 32 || e.keyCode === 13) {
          e.target.querySelector('a').click();
        }
      });
    });

    if (Joomla.localStorageEnabled()) {
      if (localStorage.getItem('adminMenuState') === 'true') {
        menuClose();
      }
    }
  }
  // eslint-disable-next-line no-new
  new JoomlaMenu('#menu');
})(window.Joomla, document);
