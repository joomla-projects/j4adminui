/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @since   4.0.0
 */

/**
 * Joomla modal web component
 *
 * More info about Web Component
 * https://developer.mozilla.org/en-US/docs/Web/Web_Components
 *
 * @param   string  id                  uniqueue ID.
 *                                      This ID will pass by target attribute (data-href)
 * @param   string  class               classes
 * @param   string  title               The new title for the modal.
 * @param   string  close-button-title  Close button text
 * @param   string  iframe              Iframe url for open iframe into modal
 *
 */

(() => {
  customElements.define('joomla-modal', class extends HTMLElement {
    constructor() {
      super();
      this.KEYCODE = { tab: 9, esc: 27 };
      this.triggerBtn = '';
      this.evDocumentClose = this.documentClose.bind(this);
      this.focusableElements = null;
      this.focusableSelectors = ['a[href]', 'area[href]', 'input:not([disabled])', 'select:not([disabled])', 'textarea:not([disabled])', 'button:not([disabled])', 'iframe', 'object', 'embed', '[contenteditable]', '[tabindex]:not([tabindex^="-"])'];
      this.container = this.querySelector('.joomla-modal-dialog');
    }

    static get observedAttributes() {
      return ['width', 'height', 'innerWidth', 'innerHeight', 'iframe', 'class'];
    }

    connectedCallback() {
      if (!this.id) {
        throw new Error('`Joomla-modal` requires an id');
      }
      this.title = this.getAttribute('title') || 'Modal';
      this.setAttribute('role', 'dialog');
      this.setAttribute('area-expand', 'false');
      this.classList.add('fade');
      this.iframe = this.getAttribute('iframe') || '';
      this.width = this.getAttribute('width') || '40vw';
      this.height = this.getAttribute('height') || '600px';
      if (!this.container) {
        const cont = document.createElement('div');
        cont.classList.add('joomla-modal-dialog');
        cont.setAttribute('role', 'document');
        cont.innerHTML = this.innerHTML;
        this.innerHTML = '';
        this.appendChild(cont);
        this.container = this.querySelector('.joomla-modal-dialog');
      }

      this.header = this.querySelector('header');
      this.main = this.querySelector('section');
      this.footer = this.querySelector('footer');

      this.setAttribute('tabindex', -1);

      // Unique Id
      const randomId = `modal-title-${new Date().getUTCMilliseconds()}`;
      this.setAttribute('aria-labelledby', randomId);

      if (!this.header) {
        const htag = document.createElement('h5');
        htag.innerText = this.title;
        htag.id = randomId;
        const closeButton = document.createElement('button');
        closeButton.setAttribute('aria-label', 'Close');
        closeButton.setAttribute('data-dismiss', '');
        closeButton.innerHTML = '<span aria-hidden="true">×</span>';

        const header = document.createElement('header');

        header.appendChild(htag);
        header.appendChild(closeButton);

        this.container.insertAdjacentElement('afterbegin', header);
      }
      this.header = this.container.querySelector('header');
      this.body = this.container.querySelector('section');
      this.footer = this.container.querySelector('footer');
      if (this.width !== '') {
        this.container.style.width = this.width;
      }

      this.triggerBtn = document.querySelector(`[data-href="#${this.id}"]`);
      if (this.triggerBtn) {
        this.triggerBtn.addEventListener('click', this.open.bind(this));
      }
    }

    disconnectedCallback() {
      if (this.triggerBtn) {
        this.triggerBtn.removeEventListener('click', this.open.bind(this));
      }
    }


    /* Method to dispatch events */
    dispatchCustomEvent(eventName) {
      const OriginalCustomEvent = new CustomEvent(eventName);
      OriginalCustomEvent.relatedTarget = this;
      this.dispatchEvent(OriginalCustomEvent);
      this.removeEventListener(eventName, this);
    }

    open(event) {
      if (event) {
        event.preventDefault();
      }
      // Comply with the Joomla API
      // Set the current Modal ID
      Joomla.Modal.setCurrent(this);
      this.dropShadow = document.createElement('div');
      this.dropShadow.classList.add('j-modal-backdrop', 'fade');
      this.dropShadow.classList.add('j-modal-backdrop', 'show');
      document.body.appendChild(this.dropShadow);
      this.removeAttribute('aria-hidden');
      // Iframe specific code, reload
      if (this.body) {
        this.iframeEl = this.main.querySelector('iframe');
        if (this.iframe) {
          if (this.iframeEl) {
            this.iframeEl.parentNode.remove(this.iframeEl);
          }
          const newIframe = document.createElement('iframe');
          newIframe.width = '100%';
          newIframe.src = this.iframe;
          newIframe.setAttribute('frameborder', 0);
          newIframe.style.height = this.height;
          this.body.appendChild(newIframe);
          this.iframeEl = this.main.querySelector('iframe');
        }
      }

      // Adjust the dimensions
      this.adjustDimensions();

      this.scrollTop = 0;
      this.classList.add('show');
      this.setAttribute('area-expand', 'true');
      this.focusableElements = [].slice.call(this.querySelectorAll(this.focusableSelectors.join()));
      if (this.focusableElements.length) {
        this.focusableElements[0].focus();
      } else {
        this.header.querySelector('button').focus();
      }

      this.evKeypress = this.keyPress.bind(this);
      this.evClose = this.close.bind(this);

      // Keyboard handling
      document.addEventListener('keydown', this.evKeypress);
      // Close on click outside the modal
      document.addEventListener('click', this.evDocumentClose);

      // Is there a close button?
      const modalButtons = [].slice.call(this.querySelectorAll('[data-dismiss]'));
      // Add listeners for close
      modalButtons.forEach((modalButton) => {
        modalButton.addEventListener('click', this.evClose);
      });
      this.dispatchCustomEvent('joomla.modal.show');
    }

    close(event) {
      if (event) {
        event.preventDefault();
      }
      this.removeEventListener('keydown', this.evKeypress);
      document.removeEventListener('click', this.evDocumentClose);

      // Is there a close button?
      const modalButtons = [].slice.call(this.querySelectorAll('[data-dismiss]'));
      // Add listeners for close
      modalButtons.forEach((modalButton) => {
        modalButton.removeEventListener('click', this.evClose);
      });

      this.setAttribute('aria-hidden', 'true');
      this.classList.remove('show');
      this.setAttribute('area-expand', 'false');

      if (this.triggerBtn) {
        this.triggerBtn.focus();
      }
      this.dispatchCustomEvent('joomla.modal.close');

      this.style.animation = 'fadeOutUp .3s';
      this.style.opacity = 0;
      setTimeout(() => {
        if (this.dropShadow) {
          document.body.removeChild(this.dropShadow);
        }
        if (this.main.querySelector('iframe')) {
          this.main.removeChild(this.main.querySelector('iframe'));
        }
        this.dispatchCustomEvent('joomla.modal.closed');
        this.style.animation = null;
        this.style.opacity = null;
      }, 200);
    }

    documentClose(event) {
      if (!this.container.contains(event.target) && event.target === this) {
        this.close();
      }
    }

    keyPress(e) {
      // ESC key
      if (e.keyCode === this.KEYCODE.esc) {
        this.close();
      }
      // TAB key
      if (e.keyCode === this.KEYCODE.tab) {
        // this.handleTabEvent(e);
        // Get the index of the current active element within the modal
        const focusedIndex = this.focusableElements.indexOf(document.activeElement);
        // Handle TAB event if need to skip
        // If first element is focused and shift key is in use
        if (e.shiftKey && (focusedIndex === 0 || focusedIndex === -1)) {
          // Focus last item within modal
          this.focusableElements[this.focusableElements.length - 1].focus();
          e.preventDefault();
        }
        // If last element is focused and shift key is not in use
        if (!e.shiftKey && focusedIndex === this.focusableElements.length - 1) {
          // Focus first item within modal
          this.focusableElements[0].focus();
          e.preventDefault();
        }
      }
    }

    adjustDimensions() {
      let modalHeight = this.offsetHeight;
      modalHeight += parseInt(window.getComputedStyle(this).getPropertyValue('margin-top'), 10);
      modalHeight += parseInt(window.getComputedStyle(this).getPropertyValue('margin-bottom'), 10);

      const bodyHeight = this.body.getBoundingClientRect.height;
      let bodyHeightOuter = this.body.offsetHeight;
      bodyHeightOuter += parseInt(window.getComputedStyle(this.body).getPropertyValue('margin-top'), 10);
      bodyHeightOuter += parseInt(window.getComputedStyle(this.body).getPropertyValue('margin-bottom'), 10);

      let headerHeight = 0;
      if (this.header !== null) {
        headerHeight = this.header.offsetHeight;
        headerHeight += parseInt(window.getComputedStyle(this.header).getPropertyValue('margin-top'), 10);
        headerHeight += parseInt(window.getComputedStyle(this.header).getPropertyValue('margin-bottom'), 10);
      }

      let footerHeight = 0;
      if (this.footer !== null) {
        footerHeight = this.footer.offsetHeight;
        footerHeight += parseInt(window.getComputedStyle(this.footer).getPropertyValue('margin-top'), 10);
        footerHeight += parseInt(window.getComputedStyle(this.footer).getPropertyValue('margin-bottom'), 10);
      }

      const padding = this.offsetTop;
      const maxModalHeight = window.height - (padding * 2);
      const modalBodyPadding = (bodyHeightOuter - bodyHeight);
      const maxModalBodyHeight = maxModalHeight - (headerHeight + footerHeight + modalBodyPadding);

      if (this.iframeEl) {
        const iframeHeight = this.iframeEl.getBoundingClientRect().height;

        if (iframeHeight > maxModalBodyHeight) {
          this.container.style.maxHeight = maxModalBodyHeight;
          this.container.style.overflowY = 'auto';
          this.iframeEl.style.maxHeight = maxModalBodyHeight - modalBodyPadding;
        }
      } else if (modalHeight > maxModalHeight) {
        this.container.style.maxHeight = maxModalBodyHeight;
        this.container.style.overflowY = 'auto';
      }
    }
  });
})();
