/* eslint-disable no-param-reassign */
/* eslint-disable no-cond-assign */
(() => {
  class JoomlaDropdownElement extends HTMLElement {
    constructor() {
      super();
      this.position = 'left';
    }

    /* Attributes to monitor */
    static get observedAttributes() {
      return ['for', 'position'];
    }

    get for() { return this.getAttribute('for'); }

    set for(value) { return this.setAttribute('for', value); }

    connectedCallback() {
      this.setAttribute('aria-labelledby', this.for.substring(1));
      const button = document.querySelector(this.for);
      const innerLinks = this.querySelectorAll('a');

      if (!button.id) {
        return;
      }

      this.position = this.getAttribute('position') ? this.getAttribute('position') : this.position;

      button.setAttribute('aria-haspopup', true);
      button.setAttribute('aria-expanded', false);

      button.addEventListener('click', (event) => {
        event.preventDefault();
        if (this.hasAttribute('expanded')) {
          this.removeAttribute('expanded');
          event.target.setAttribute('aria-expanded', false);
        } else {
          this.setAttribute('expanded', '');
          event.target.setAttribute('aria-expanded', true);
        }

        this.setPosition();

        document.addEventListener('click', (evt) => {
          if (!button.contains(evt.target) && evt.target !== button) {
            if (!this.findAncestor(evt.target, 'joomla-dropdown')) {
              this.close();
            }
          }
        });

        innerLinks.forEach((innerLink) => {
          innerLink.addEventListener('click', () => {
            this.close();
          });
        });
      });
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
      if (this.position === 'left' && (dropdownRect.left + dropdownRect.width) > window.innerWidth) {
        this.setAttribute('position', 'right');
      } else if (this.position === 'right' && (dropdownRect.right + dropdownRect.width) > window.innerWidth) {
        this.setAttribute('position', 'left');
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
      const button = document.querySelector(`#${this.getAttribute('aria-labelledby')}`);
      this.removeAttribute('expanded');
      button.setAttribute('aria-expanded', false);
    }

    // eslint-disable-next-line class-methods-use-this
    findAncestor(el, tagName) {
      while ((el = el.parentElement) && el.nodeName.toLowerCase() !== tagName);
      return el;
    }
  }

  customElements.define('joomla-dropdown', JoomlaDropdownElement);
})();
