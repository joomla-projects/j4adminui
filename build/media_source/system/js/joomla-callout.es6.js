(() => {
  class JoomlaCalloutElement extends HTMLElement {
    /* Attributes to monitor */
    static get observedAttributes() {
      return ['for', 'dismiss', 'position'];
    }

    get for() { return this.getAttribute('for'); }

    set for(value) { return this.setAttribute('for', value); }

    get dismiss() { return this.getAttribute('dismiss'); }

    get position() { return this.getAttribute('position'); }

    set position(value) { return this.setAttribute('position', value); }


    connectedCallback() {
      if (!this.position || (this.position && ['top', 'bottom', 'left', 'right'].indexOf(this.position) === -1)) {
        this.position = 'right';
      }

      this.setAttribute('aria-labelledby', this.for.substring(1));
      const button = document.querySelector(this.for);
      const innerLinks = this.querySelectorAll('a');

      if (!button.id) {
        return;
      }
      if (this.hasAttribute('dismiss')) {
        this.appendCloseButton();
      }

      button.setAttribute('aria-haspopup', true);
      button.setAttribute('aria-expanded', false);

      window.addEventListener('scroll', (e) => {
        e.preventDefault();
        if (this.hasAttribute('expanded')) {
          const buttonRect = button.getBoundingClientRect();
          const space1 = 5;
          const calloutRect = this.getBoundingClientRect();
          const copyPosition = this.checkPosition(this.position, buttonRect, calloutRect);
          this.calloutPosition(copyPosition, buttonRect, calloutRect, space1);
        }
      });

      button.addEventListener('click', (event) => {
        event.preventDefault();
        if (this.hasAttribute('expanded')) {
          this.removeAttribute('expanded');
          event.target.setAttribute('aria-expanded', false);
        } else {
          this.setAttribute('expanded', '');
          event.target.setAttribute('aria-expanded', true);
          const buttonRect = button.getBoundingClientRect();
          const space = 5;
          const calloutRect = this.getBoundingClientRect();
          const copyPosition = this.checkPosition(this.position, buttonRect, calloutRect);
          this.calloutPosition(copyPosition, buttonRect, calloutRect, space);
        }

        document.addEventListener('click', (evt) => {
          if (evt.target !== button && evt.target !== this) {
            if (!this.findAncestor(evt.target, 'joomla-callout')) {
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

    // eslint-disable-next-line class-methods-use-this
    checkPosition(currentPosition, buttonRect, calloutRect) {
      if (currentPosition === 'bottom' && (buttonRect.top + calloutRect.height) > window.innerHeight) {
        this.setAttribute('position', 'top');
        return 'top';
      } if (currentPosition === 'top' && buttonRect.top < (buttonRect.height + calloutRect.height)) {
        this.setAttribute('position', 'bottom');
        return 'bottom';
      } if (currentPosition === 'right' && (buttonRect.right + calloutRect.width) > window.innerWidth) {
        this.setAttribute('position', 'left');
        return 'left';
      } if (currentPosition === 'left' && (buttonRect.width + calloutRect.width) > buttonRect.right) {
        this.setAttribute('position', 'right');
        return 'right';
      }
      return currentPosition;
    }

    calloutPosition(copyPosition, buttonRect, calloutRect, space) {
      const diffWidth = Math.round(Math.abs(calloutRect.width - buttonRect.width) / 2);
      const diffHeight = Math.round(Math.abs(calloutRect.height - buttonRect.height) / 2);
      switch (copyPosition) {
        case 'top':
          this.style.top = `${Math.round(buttonRect.top - (calloutRect.height + space))}px`;
          if (buttonRect.width < calloutRect.width) {
            this.style.left = `${Math.round(buttonRect.left - diffWidth)}px`;
          } else {
            this.style.left = `${Math.round(buttonRect.left + diffWidth)}px`;
          }
          break;
        case 'bottom':
          this.style.top = `${Math.round(buttonRect.bottom) + space}px`;
          if (buttonRect.width < calloutRect.width) {
            this.style.left = `${Math.round(buttonRect.left - diffWidth)}px`;
          } else {
            this.style.left = `${Math.round(buttonRect.left + diffWidth)}px`;
          }
          break;
        case 'left':
          this.style.left = `${Math.round((buttonRect.left) - (calloutRect.width + space))}px`;
          if (buttonRect.height < calloutRect.height) {
            this.style.top = `${Math.round(buttonRect.top - diffHeight)}px`;
          } else {
            this.style.top = `${Math.round(buttonRect.top + diffHeight)}px`;
          }
          break;
        default:
          this.style.left = `${Math.round((buttonRect.left) + (buttonRect.width + space))}px`;
          if (buttonRect.height < calloutRect.height) {
            this.style.top = `${Math.round(buttonRect.top - diffHeight)}px`;
          } else {
            this.style.top = `${Math.round(buttonRect.top + diffHeight)}px`;
          }
          break;
      }
    }


    /*eslint-disable */
    /* Method to dispatch events */
    dispatchCustomEvent(eventName) {
      const OriginalCustomEvent = new CustomEvent(eventName);
      OriginalCustomEvent.relatedTarget = this;
      this.dispatchEvent(OriginalCustomEvent);
      this.removeEventListener(eventName, this);
    }


    /* eslint-enable */

    close() {
      const button = document.querySelector(`#${this.getAttribute('aria-labelledby')}`);
      this.removeAttribute('expanded');
      button.setAttribute('aria-expanded', false);
    }

    appendCloseButton() {
      const self = this;
      const closeButton = document.createElement('button');
      if (this.hasAttribute('dismiss')) {
        closeButton.classList.add('joomla-callout--close');
        closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';
        closeButton.setAttribute('aria-label', this.getText('JCLOSE', 'Close'));
      }

      if (this.firstChild) {
        this.insertBefore(closeButton, this.firstChild);
      } else {
        this.appendChild(closeButton);
      }

      /* Add the required listener */
      if (closeButton) {
        closeButton.addEventListener('click', (e) => {
          e.preventDefault();
          self.dispatchCustomEvent('joomla.alert.buttonClicked');
          self.close();
        });
      }
    }
    /* eslint-disable */
    findAncestor(el, tagName) {
      while ((el = el.parentElement) && el.nodeName.toLowerCase() !== tagName);
      return el;
    }
    
    /* Method to get the translated text */
    getText(str, fallback) {
      // TODO: Remove coupling to Joomla CMS Core JS here
      /* eslint-disable-next-line no-undef */
      return (window.Joomla && Joomla.JText && Joomla.JText._ && typeof Joomla.JText._ === 'function' && Joomla.JText._(str)) ? Joomla.JText._(str) : fallback;
    }
  }

  customElements.define('joomla-callout', JoomlaCalloutElement);
})();
