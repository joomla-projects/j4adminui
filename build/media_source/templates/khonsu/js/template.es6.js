/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((Joomla, doc) => {
  'use strict';

  const storageEnabled = typeof Storage !== 'undefined';

  const mobile = window.matchMedia('(max-width: 992px)');
  const small = window.matchMedia('(max-width: 575.98px)');
  const smallLandscape = window.matchMedia('(max-width: 767.98px)');
  const tablet = window.matchMedia('(min-width: 576px) and (max-width:991.98px)');

  /**
   * Toggle Class
   * @param {Object}  element       Any valid html element
   * @param {String}  removeClass   element class that need to remove
   * @param {String}  addClass      element class that need to add
   */
  function toggleClass(element, removeClass, addClass) {
    if (!element) return;
    element.classList.remove(removeClass);
    element.classList.add(addClass);
  }

  /**
   * Shrink or extend the logo, depending on sidebar
   *
   * @param {string} [change] is the sidebar 'open' or 'closed'
   *
   * @since   4.0.0
   */
  function changeLogo(change) {
    const logo = doc.querySelector('.logo');
    const isLogin = doc.querySelector('body.com_login');

    if (!logo || isLogin) {
      return;
    }

    const state = change || Joomla.Cookies.get('main-sidebar');

    if (state === 'closed') {
      logo.classList.add('small');
    } else {
      logo.classList.remove('small');
    }
  }

  /**
   * Method that add a fade effect and transition on sidebar and content side
   * after login and logout
   *
   * @since   4.0.0
   */
  function fade(fadeAction, transitAction) {
    const sidebar = doc.querySelector('.sidebar-wrapper');
    const sidebarChildren = sidebar ? sidebar.children : [];
    const sideChildrenLength = sidebarChildren.length;
    const contentMain = doc.querySelector('.container-main');
    const contentChildren = contentMain ? contentMain.children : [];
    const contChildrenLength = contentChildren.length;

    for (let i = 0; i < sideChildrenLength; i += 1) {
      if (sidebarChildren[i]) {
        sidebarChildren[i].classList.add(`load-fade${fadeAction}`);
      }
    }
    for (let i = 0; i < contChildrenLength; i += 1) {
      if (contentChildren[i]) {
        contentChildren[i].classList.add(`load-fade${fadeAction}`);
      }
    }
    if (sidebar) {
      if (transitAction) {
        // Transition class depends on the width of the sidebar
        if (storageEnabled
          && localStorage.getItem('main-sidebar') === 'closed') {
          sidebar.classList.add(`transit-${transitAction}-closed`);
          changeLogo('small');
        } else {
          sidebar.classList.add(`transit-${transitAction}`);
        }
      }
      sidebar.classList.toggle('fade-done', fadeAction !== 'out');
    }
    if (contentMain) {
      contentMain.classList.toggle('fade-done', fadeAction !== 'out');
    }
  }

  /**
   * toggle arrow icon between down and up depending on position of the nav header
   *
   * @param {string} [positionTop] set if the nav header positioned to the 'top' otherwise 'bottom'
   *
   * @since   4.0.0
   */
  function toggleArrowIcon(positionTop) {
    const navDropDownIcon = doc.querySelectorAll('.nav-item.dropdown span[class*="fa-angle-"]');
    const remIcon = (positionTop) ? 'fa-angle-up' : 'fa-angle-down';
    const addIcon = (positionTop) ? 'fa-angle-down' : 'fa-angle-up';

    if (!navDropDownIcon) {
      return;
    }

    navDropDownIcon.forEach((item) => {
      item.classList.remove(remIcon);
      item.classList.add(addIcon);
    });
  }

  /**
   * adjust color of svg logos
   *
   * @since   4.0.0
   */
  function changeSVGLogoColor() {
    const logoImgs = document.querySelectorAll('.logo img');

    logoImgs.forEach((img) => {
      const imgID = img.getAttribute('id');
      const imgClass = img.getAttribute('class');
      const imgURL = img.getAttribute('src');

      Joomla.request({
        url: imgURL,
        method: 'GET',
        onSuccess: (response) => {
          // Get the SVG tag, ignore the rest
          const parsedImg = new DOMParser().parseFromString(response, 'image/svg+xml');
          const svg = parsedImg.getElementsByTagName('svg')[0];

          // Add replaced image's ID to the new SVG
          if (imgID) {
            svg.setAttribute('id', imgID);
          }

          // Add replaced image's classes to the new SVG
          if (imgClass) {
            svg.setAttribute('class', `${imgClass} replaced-svg`);
          }

          // Remove any invalid XML tags as per http://validator.w3.org
          svg.removeAttribute('xmlns:a');

          // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
          if (!svg.hasAttribute('viewBox') && svg.hasAttribute('height') && svg.hasAttribute('width')) {
            svg.setAttribute('viewBox', `0 0 ${svg.getAttribute('height')} ${svg.getAttribute('width')}`);
          }

          // Replace image with new SVG
          img.parentElement.replaceChild(svg, img);
        },
      });
    });
  }

  /**
   * Trigger fade out on login and logout
   *
   * @since   4.0.0
   */
  function fadeLoginLogout() {
    // Fade out login form when login was successful
    const loginForm = doc.getElementById('form-login');
    if (loginForm) {
      loginForm.addEventListener('joomla:login', () => {
        fade('out', 'narrow');
      });
    } else {
      // Fade out dashboard on logout
      const logoutBtn = doc.querySelector('.header-items a[href*="task=logout"]');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
          fade('out', 'wider');
        });
      }
    }
  }

  /**
   * Change appearance for mobile devices
   *
   * @since   4.0.0
   */
  function setMobile() {
    const menu = doc.querySelector('.sidebar-wrapper');
    const sidebarNav = doc.querySelector('.sidebar-nav');
    const subhead = doc.querySelector('.subhead');
    const wrapper = doc.querySelector('.wrapper');
    const header = doc.querySelector('#header');
    const toggleBtn = header.querySelector('.toggler-burger');
    const menuToggleIcon = header.querySelector('#menu-collapse-icon');
    changeLogo('closed');

    if (small.matches) {
      toggleArrowIcon();
      if (menu) {
        wrapper.classList.remove('main-sidebar-collapsed');
      }
      if (toggleBtn && menu) {
        if (menu.classList.contains('show')) {
          toggleBtn.classList.remove('collapsed');
        } else {
          toggleBtn.classList.add('collapsed');
        }
      }
    } else {
      toggleArrowIcon('top');
    }
    if (tablet.matches && menu) {
      wrapper.classList.add('main-sidebar-collapsed');
      if (menuToggleIcon && menuToggleIcon.classList.contains('icon-angle-double-left')) {
        toggleClass(menuToggleIcon, 'icon-angle-double-left', 'icon-angle-double-right');
      }
    }

    if (smallLandscape.matches) {
      if (sidebarNav) sidebarNav.classList.add('collapse');
      if (subhead) subhead.classList.add('collapse');
      if (menu) {
        if (menu.classList.contains('collapse')) {
          menu.classList.remove('collapse');
        }
      }
    } else {
      if (sidebarNav) sidebarNav.classList.remove('mm-collapse');
      if (subhead) subhead.classList.remove('mm-collapse');
    }
  }

  /**
   * Change appearance for mobile devices
   *
   * @since   4.0.0
   */
  function setDesktop() {
    const sidebarWrapper = doc.querySelector('.sidebar-wrapper');
    const wrapper = doc.querySelector('#wrapper');
    const menu = doc.querySelector('#menu');
    const menuToggleIcon = wrapper.querySelector('#menu-collapse-icon');

    if (!sidebarWrapper) {
      changeLogo('closed');
    } else {
      changeLogo();
    }
    if (sidebarWrapper) {
      if (sidebarWrapper.classList.contains('collapse')) {
        sidebarWrapper.classList.remove('collapse');
      }
      if (sidebarWrapper.classList.contains('show')) {
        sidebarWrapper.classList.remove('show');
      }
    }
    const state = Joomla.Cookies.get('main-sidebar');
    if (state === 'closed' || (menu && menu.classList.contains('disabled'))) {
      wrapper.classList.add('main-sidebar-collapsed');
      if (menuToggleIcon && menuToggleIcon.classList.contains('icon-angle-double-left')) {
        toggleClass(menuToggleIcon, 'icon-angle-double-left', 'icon-angle-double-right');
      }
    } else {
      wrapper.classList.remove('main-sidebar-collapsed');
      if (menuToggleIcon && menuToggleIcon.classList.contains('icon-angle-double-right')) {
        toggleClass(menuToggleIcon, 'icon-angle-double-right', 'icon-angle-double-left');
      }
    }
    toggleArrowIcon('top');
  }

  /**
   * React on resizing window
   *
   * @since   4.0.0
   */
  function reactToResize() {
    window.addEventListener('resize', () => {
      if (mobile.matches) {
        setMobile();
      } else {
        setDesktop();
      }
    });
    /* mobile if android or iOS and not emulated in mac or win pc (for dev) */
    /* or if windows phone or blackberry (no dev in windows) */
  }

  /**
   * Subhead gets white background when user scrolls down
   *
   * @since   4.0.0
   */
  function subheadScrolling() {
    const subhead = doc.querySelector('.subhead');
    if (subhead) {
      doc.addEventListener('scroll', () => {
        if (window.scrollY > 0) {
          subhead.classList.add('subhead-is-sticky');
        } else {
          subhead.classList.remove('subhead-is-sticky');
        }
      });
    }
  }

  doc.addEventListener('DOMContentLoaded', () => {
    changeSVGLogoColor();
    fadeLoginLogout();
    reactToResize();
    subheadScrolling();

    if (mobile.matches) {
      setMobile();
    } else {
      setDesktop();

      if (!navigator.cookieEnabled) {
        Joomla.renderMessages({ error: [Joomla.Text._('JGLOBAL_WARNCOOKIES')] }, undefined, false, 6000);
      }
      window.addEventListener('joomla:menu-toggle', (event) => {
        changeLogo(event.detail);
      });
    }
  });
})(window.Joomla, document);
