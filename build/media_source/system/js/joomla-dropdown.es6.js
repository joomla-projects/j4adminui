/* eslint-disable no-param-reassign */
/* eslint-disable no-cond-assign */
(() => {
  class JoomlaDropdownElement extends HTMLElement {
    constructor() {
      super();
      this.position = 'right';
      this.checkSubmenu = this.checkSubmenu.bind(this);
      this.clickOutside = this.clickOutside.bind(this);
      this.toggleMenu = this.toggleMenu.bind(this);
    }

    /* Attributes to monitor */
    static get observedAttributes() {
      return ['for', 'position'];
    }

    get for() { return this.getAttribute('for'); }

    set for(value) { return this.setAttribute('for', value); }

    connectedCallback() {
      this.setAttribute('aria-labelledby', this.for.substring(1));
      this.button = document.querySelector(`[data-target=${this.for}]`);
      const innerLinks = this.querySelectorAll('a');

      if (!this.button.hasAttribute('data-target')) {
        return;
      }

      this.position = this.getAttribute('position') ? this.getAttribute('position') : this.position;
      // set the position for submenu items
      innerLinks.forEach((link) => {
        if (link.parentElement.classList.contains('has-submenu')) {
          link.parentElement.classList.add(this.position);
        }
      });
      this.button.setAttribute('aria-haspopup', true);
      this.button.setAttribute('aria-expanded', false);
      this.button.addEventListener('click', this.toggleMenu, true);
    }

    disconnectedCallback() {
      this.button.removeEventListener('click', this.toggleMenu, true);
    }

    toggleMenu(event) {
      if (event.target.tagName === 'A') {
        event.preventDefault();
      }
      if (this.hasAttribute('expanded')) {
        this.removeAttribute('expanded');
        event.target.setAttribute('aria-expanded', false);
      } else {
        this.setAttribute('expanded', '');
        event.target.setAttribute('aria-expanded', true);
      }

      this.setPosition();

      document.addEventListener('click', this.clickOutside, true);
      const innerLinks = this.querySelectorAll('a');
      innerLinks.forEach((innerLink) => {
        innerLink.addEventListener('click', this.checkSubmenu, true);
      });
      // toggle dropdown onhover
      const lists = this.querySelectorAll('li.has-submenu');
      lists.forEach((list) => {
        if (list.getAttribute('data-action') !== 'click') {
          list.addEventListener('mouseenter', this.showSubmenu, true);
          list.addEventListener('mouseleave', this.hideSubmenu, true);
        }
      });
    }

    // eslint-disable-next-line class-methods-use-this
    showSubmenu(event) {
      event.preventDefault();
      if (event.target.classList.contains('has-submenu')) {
        event.target.toggleAttribute('open');
      }
    }

    // eslint-disable-next-line class-methods-use-this
    hideSubmenu(event) {
      event.preventDefault();
      if (event.target.classList.contains('has-submenu') && event.target.hasAttribute('open')) {
        event.target.toggleAttribute('open');
      }
    }

    clickOutside(event) {
      if (this.button.contains(event.target) === false && event.target !== this.button) {
        if (!this.findAncestor(event.target, 'joomla-dropdown')) {
          this.close();
        }
      }
    }

    checkSubmenu(event) {
      // check for drop-down items
      const hasSubmenu = event.target.parentElement.classList.contains('has-submenu');
      const clickable = event.target.parentElement.getAttribute('data-action') === 'click';
      if (hasSubmenu && clickable) {
        const allDropdowns = this.querySelectorAll('.has-submenu');
        allDropdowns.forEach((dropdown) => {
          if (dropdown.hasAttribute('open') && dropdown !== event.target.parentElement) {
            dropdown.toggleAttribute('open');
          }
        });
        event.target.parentElement.toggleAttribute('open');
      } else {
        this.close();
      }
    }

    attributeChangedCallback(attr, oldValue, newValue) {
      switch (attr) {
        case 'position':
          if (!newValue || newValue === '') {
            this.position = newValue;
            this.setPosition();
          }
          break;
        default:
          break;
      }
    }

    setPosition() {
      const dropdownRect = this.getBoundingClientRect();
      const button = document.querySelector(`[data-target=${this.for}]`);
      const buttonRect = button.getBoundingClientRect();

      if (this.position === 'left' && (dropdownRect.width + buttonRect.width) > dropdownRect.right) {
        this.setAttribute('position', 'left');
      } else if (this.position === 'right' && (buttonRect.right + dropdownRect.width) > window.innerWidth) {
        this.setAttribute('position', 'right');
      }
    }

    /* Method to dispatch events */
    dispatchCustomEvent(eventName) {
      const OriginalCustomEvent = new CustomEvent(eventName);
      OriginalCustomEvent.relatedTarget = this;
      this.dispatchEvent(OriginalCustomEvent);
      this.removeEventListener(eventName, this);
    }

    close() {
      // removing 'open' attribute of dropdown items
      const dropdownItems = document.querySelectorAll('.has-submenu');
      dropdownItems.forEach((item) => {
        if (item.hasAttribute('open')) {
          item.toggleAttribute('open');
        }
      });
      const button = document.querySelector(`[data-target=${this.getAttribute('aria-labelledby')}]`);
      this.removeAttribute('expanded');
      if (button) button.setAttribute('aria-expanded', false);

      // remove the click listener on list items
      window.removeEventListener('click', this.checkSubmenu, true);
      document.removeEventListener('click', this.clickOutside, true);
    }

    // eslint-disable-next-line class-methods-use-this
    findAncestor(el, tagName) {
      while ((el = el.parentElement) && el.nodeName.toLowerCase() !== tagName);
      return el;
    }
  }

  customElements.define('joomla-dropdown', JoomlaDropdownElement);
})();
