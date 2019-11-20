/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @since   4.0.0
 */

/**
 * Joomla tab web component
 *
 * More info about Web Component
 * https://developer.mozilla.org/en-US/docs/Web/Web_Components
 *
 * @param   string  orientation         Vertical or landscape position of tab
 *
 * Section Attributes
 * @param   string  id                  uniqueue ID.
 * @param   string  name                This attribute is responsible for tab menu name
 * @param   boolean disable             If true then this tab will be disabled
 *
 */

(() => {
  customElements.define('joomla-tab', class extends HTMLElement {
    /* Attributes to monitor */
    static get observedAttributes() { return ['recall', 'orientation', 'view']; }

    get recall() { return this.getAttribute('recall'); }

    get view() { return this.getAttribute('view'); }

    set view(value) { this.setAttribute('view', value); }

    get orientation() { return this.getAttribute('orientation'); }

    set orientation(value) { this.setAttribute('orientation', value); }

    get pills() { return this.getAttribute('pills'); }

    set pills(value) { this.setAttribute('pills', value); }

    get justified() { return this.getAttribute('justified'); }

    set justified(value) { this.setAttribute('justified', value); }

    /* Lifecycle, element created */
    constructor() {
      super();

      this.hasActive = false;
      this.currentActive = '';
      this.hasNested = false;
      this.isNested = false;
      this.tabs = [];
      this.toggleTabClass = this.toggleTabClass.bind(this);
    }

    /* Lifecycle, element appended to the DOM */
    connectedCallback() {
      if (!this.orientation || (this.orientation && ['horizontal', 'vertical'].indexOf(this.orientation) === -1)) {
        this.orientation = 'horizontal';
      }

      // get tab elements
      const self = this;
      const tabs = [].slice.call(this.querySelectorAll('section'));
      let tabsEl = [];
      const tabLinkHash = [];

      // Sanity check
      if (!tabs) {
        return;
      }

      if (this.findAncestor(this, 'joomla-tab')) {
        this.isNested = true;
      }

      if (this.querySelector('joomla-tab')) {
        this.hasNested = true;
      }

      // Use the sessionStorage state!
      if (this.hasAttribute('recall')) {
        const href = sessionStorage.getItem(this.getStorageKey());
        if (href) {
          tabLinkHash.push(href);
        }
      }

      if (this.hasNested) {
        // @todo use the recall attribute
        const href = sessionStorage.getItem(this.getStorageKey());
        if (href) {
          tabLinkHash.push(href);
        }
        // @todo end

        // Add possible parent tab to the aray for activation
        if (tabLinkHash.length && tabLinkHash[0] !== '') {
          const hash = tabLinkHash[0].substring(5);
          const element = this.querySelector(`#${hash}`);

          // Add the parent tab to the array for activation
          if (element) {
            const currentTabSet = this.findAncestor(element, 'joomla-tab');
            const parentTabSet = this.findAncestor(currentTabSet, 'joomla-tab');

            if (parentTabSet) {
              const parentTab = this.findAncestor(currentTabSet, 'section');
              if (parentTab) {
                tabLinkHash.push(`#tab-${parentTab.id}`);
              }
            }
          }
        }

        // remove the cascaded tabs and activate the right tab
        tabs.forEach((tab) => {
          if (tabLinkHash.length) {
            const theId = `#tab-${tab.id}`;

            if (tabLinkHash.indexOf(theId) === -1) {
              tab.removeAttribute('active');
            } else {
              tab.setAttribute('active', '');
            }
          }

          if (tab.parentNode === self) {
            tabsEl.push(tab);
          }
        });
      } else {
        // Activate the correct tab
        tabs.forEach((tab) => {
          if (tabLinkHash.length) {
            const theId = `#tab-${tab.id}`;
            if (tabLinkHash.indexOf(theId) === -1) {
              tab.removeAttribute('active');
            } else {
              tab.setAttribute('active', '');
            }
          }
        });

        tabsEl = tabs;
      }

      // Create the navigation
      if (this.view !== 'accordion') {
        this.createNavigation(tabsEl);
      }

      // Add missing role
      tabsEl.forEach((tab) => {
        tab.setAttribute('role', 'tabpanel');
        this.tabs.push(`#tab-${tab.id}`);
        if (tab.hasAttribute('active')) {
          this.hasActive = true;
          this.currentActive = tab.id;
          this.querySelector(`#tab-${tab.id}`).setAttribute('aria-selected', 'true');
          this.querySelector(`#tab-${tab.id}`).setAttribute('active', '');
          this.querySelector(`#tab-${tab.id}`).setAttribute('tabindex', '0');
        }
      });

      // Fallback if no active tab
      if (!this.hasActive) {
        tabsEl[0].setAttribute('active', '');
        this.hasActive = true;
        this.currentActive = tabsEl[0].id;
        this.querySelector(`#tab-${tabsEl[0].id}`).setAttribute('aria-selected', 'true');
        this.querySelector(`#tab-${tabsEl[0].id}`).setAttribute('tabindex', '0');
        this.querySelector(`#tab-${tabsEl[0].id}`).setAttribute('active', '');
      }

      // Check if there is a hash in the URI
      if (window.location.href.match(/#\S[^&]*/)) {
        const hash = window.location.href.match(/#\S[^&]*/);
        const element = this.querySelector(hash[0]);

        if (element) {
          // Activate any parent tabs (nested tables)
          const currentTabSet = this.findAncestor(element, 'joomla-tab');
          const parentTabSet = this.findAncestor(currentTabSet, 'joomla-tab');

          if (parentTabSet) {
            const parentTab = this.findAncestor(currentTabSet, 'section');
            parentTabSet.showTab(parentTab);
            // Now activate the given tab
            this.show(element);
          } else {
            // Now activate the given tab
            this.showTab(element);
          }
        }
      }
      this.tablist = this.querySelector('[role="tablist"]');
      this.listItems = [...this.tablist.querySelectorAll('li')];

      // Convert tabs to accordian
      self.checkView(self);

      window.addEventListener('resize', () => {
        self.checkView(self);
      });
      this.checkoverflow();
    }

    /* Check overflow for tabs */
    checkoverflow() {
      /* eslint-disable */
      this.totalListWidth = this.listItems.reduce((total, listItem) => total += listItem.offsetWidth, 0);
      /* eslint-enable */

      if (this.totalListWidth <= this.tablist.offsetWidth && this.tablist.classList.contains('tab-overflow')) {
        this.tablist.classList.remove('tab-overflow');
      }

      // For desktop
      this.tablist.addEventListener('mouseenter', this.toggleTabClass, true);
      this.tablist.addEventListener('mouseleave', this.toggleTabClass, true);

      // For smaller devices
      this.tablist.addEventListener('touchstart', this.toggleTabClass, true);
      this.tablist.addEventListener('touchend', this.toggleTabClass, true);
    }


    /* Lifecycle, element removed from the DOM */
    disconnectedCallback() {
      const ulEl = this.querySelector('ul');
      const navigation = [].slice.call(ulEl.querySelectorAll('a'));

      navigation.forEach((link) => {
        link.removeEventListener('click', this);
      });
      ulEl.removeEventListener('keydown', this);

      // For desktop
      this.tablist.removeEventListener('mouseenter', this.toggleTabClass, true);
      this.tablist.removeEventListener('mouseleave', this.toggleTabClass, true);
      // For smaller devices
      this.tablist.removeEventListener('touchstart', this.toggleTabClass, true);
      this.tablist.removeEventListener('touchend', this.toggleTabClass, true);
    }

    toggleTabClass() {
      if (this.totalListWidth > this.tablist.offsetWidth && this.orientation !== 'vertical') {
        this.tablist.classList.toggle('tab-overflow');
      }
    }

    /* Method to create the tabs navigation */
    createNavigation(tabs) {
      if (this.firstElementChild.nodeName.toLowerCase() === 'ul') {
        return;
      }

      const nav = document.createElement('ul');
      nav.setAttribute('role', 'tablist');

      if (this.hasAttribute('pills') && this.getAttribute('pills') === 'true') {
        nav.setAttribute('class', 'nav-pills');
      }
      if (this.hasAttribute('pills') && this.hasAttribute('justified') && this.getAttribute('justified') === 'true') {
        nav.classList.add('nav-justified');
      }

      /** Activate Tab */
      const activateTabFromLink = (e) => {
        e.preventDefault();
        const isDisable = e.target.getAttribute('disabled');
        if (isDisable === 'true') return;
        if (this.hasActive) {
          this.hideCurrent();
        }

        const currentTabLink = this.currentActive;

        // Set the selected tab as active
        // Emit show event
        this.dispatchCustomEvent('joomla.tab.show', e.target, this.querySelector(`#tab-${currentTabLink}`));
        e.target.setAttribute('active', '');
        e.target.setAttribute('aria-selected', 'true');
        e.target.setAttribute('tabindex', '0');
        this.querySelector(e.target.hash).setAttribute('active', '');
        this.querySelector(e.target.hash).removeAttribute('aria-hidden');
        this.currentActive = e.target.hash.substring(1);
        // Emit shown event
        this.dispatchCustomEvent('joomla.tab.shown', e.target, this.querySelector(`#tab-${currentTabLink}`));
        this.saveState(`#tab-${e.target.hash.substring(1)}`);
      };

      tabs.forEach((tab) => {
        if (!tab.id) {
          return;
        }

        const active = tab.hasAttribute('active');
        const liElement = document.createElement('li');
        const aElement = document.createElement('a');
        let isDisable = tab.getAttribute('disabled');
        isDisable = isDisable !== null && isDisable === 'true';
        liElement.setAttribute('role', 'presentation');
        aElement.setAttribute('role', 'tab');
        aElement.setAttribute('aria-controls', tab.id);
        aElement.setAttribute('aria-selected', active ? 'true' : 'false');
        aElement.setAttribute('tabindex', active ? '0' : '-1');
        aElement.setAttribute('href', `#${tab.id}`);
        aElement.setAttribute('id', `tab-${tab.id}`);
        aElement.innerHTML = tab.getAttribute('name');

        if (active) {
          aElement.setAttribute('active', '');
        }

        if (isDisable) {
          aElement.setAttribute('disabled', 'true');
        }

        aElement.addEventListener('click', activateTabFromLink);

        liElement.appendChild(aElement);
        nav.appendChild(liElement);

        tab.setAttribute('aria-labelledby', `tab-${tab.id}`);
        if (!active) {
          tab.setAttribute('aria-hidden', 'true');
        }
      });

      this.insertAdjacentElement('afterbegin', nav);

      // Keyboard access
      this.addKeyListeners();
    }

    hideCurrent() {
      // Unset the current active tab
      if (this.currentActive) {
        // Emit hide event
        const el = this.querySelector(`a[aria-controls="${this.currentActive}"]`);
        this.dispatchCustomEvent('joomla.tab.hide', el, this.querySelector(`#tab-${this.currentActive}`));
        el.removeAttribute('active');
        el.setAttribute('tabindex', '-1');
        this.querySelector(`#${this.currentActive}`).removeAttribute('active');
        this.querySelector(`#${this.currentActive}`).setAttribute('aria-hidden', 'true');
        el.removeAttribute('aria-selected');
        // Emit hidden event
        this.dispatchCustomEvent('joomla.tab.hidden', el, this.querySelector(`#tab-${this.currentActive}`));
      }
    }

    // eslint-disable-next-line class-methods-use-this
    showTab(tab) {
      const tabLink = document.querySelector(`#tab-${tab.id}`);
      tabLink.click();
    }

    // eslint-disable-next-line class-methods-use-this
    show(ulLink) {
      ulLink.click();
    }

    addKeyListeners() {
      const keyBehaviour = (e) => {
        // collect tab targets, and their parents' prev/next (or first/last)
        const currentTab = this.querySelector(`#tab-${this.currentActive}`);
        // const tablist = [].slice.call(this.querySelector('ul').querySelectorAll('a'));

        const previousTabItem = currentTab.parentNode.previousElementSibling
            || currentTab.parentNode.parentNode.lastElementChild;
        const nextTabItem = currentTab.parentNode.nextElementSibling
            || currentTab.parentNode.parentNode.firstElementChild;

        // don't catch key events when ⌘ or Alt modifier is present
        if (e.metaKey || e.altKey) {
          return;
        }

        if (this.tabs.indexOf(`#${document.activeElement.id}`) === -1) {
          return;
        }

        // catch left/right and up/down arrow key events
        switch (e.keyCode) {
          case 37:
          case 38:
            previousTabItem.querySelector('a').click();
            previousTabItem.querySelector('a').focus();
            e.preventDefault();
            break;
          case 39:
          case 40:
            nextTabItem.querySelector('a').click();
            nextTabItem.querySelector('a').focus();
            e.preventDefault();
            break;
          default:
            break;
        }
      };
      this.querySelector('ul').addEventListener('keyup', keyBehaviour);
    }

    // eslint-disable-next-line class-methods-use-this
    getStorageKey() {
      return window.location.href.toString().split(window.location.host)[1].replace(/&return=[a-zA-Z0-9%]+/, '').split('#')[0];
    }

    saveState(value) {
      const storageKey = this.getStorageKey();
      sessionStorage.setItem(storageKey, value);
    }

    /** Method to convert tabs to accordion and vice versa depending on screen size */
    checkView(element) {
      const el = element;
      const nav = el.querySelector('ul');
      const tabsEl = [];

      if (this.orientation === 'vertical' && document.body.getBoundingClientRect().width < 768) {
        if (this.view === 'accordion') {
          return;
        }
        el.view = 'accordion';

        // convert to accordion
        const panels = [].slice.call(el.querySelectorAll('section'));

        // remove the cascaded tabs
        for (let i = 0, l = panels.length; i < l; i += 1) {
          if (panels[i].parentNode === el) {
            tabsEl.push(panels[i]);
          }
        }

        if (tabsEl.length) {
          tabsEl.forEach((panel) => {
            const link = el.querySelector(`a[aria-controls="${panel.id}"]`);
            if (link.parentNode.parentNode === el.firstElementChild) {
              link.parentNode.appendChild(panel);
            }
          });
        }
      } else {
        if (this.view === 'tabs') {
          return;
        }
        el.view = 'tabs';
        // convert to tabs
        const panels = [].slice.call(nav.querySelectorAll('section'));

        // remove the cascaded tabs
        for (let i = 0, l = panels.length; i < l; i += 1) {
          if (panels[i].parentNode.parentNode.parentNode === el) {
            tabsEl.push(panels[i]);
          }
        }

        if (tabsEl.length) {
          tabsEl.forEach((panel) => {
            el.appendChild(panel);
          });
        }
        this.checkoverflow();
      }
    }

    // eslint-disable-next-line class-methods-use-this
    findAncestor(el, tagName) {
      let element = el;
      if (!element) { return false; }
      while (element.nodeName.toLowerCase() !== tagName) {
        // Ensure we haven't reached the top of the dom tree
        if (element.parentElement === null) {
          return false;
        }
        element = element.parentElement;
      }
      return element;
    }

    // eslint-disable-next-line class-methods-use-this
    dispatchCustomEvent(eventName, element, related) {
      const OriginalCustomEvent = new CustomEvent(eventName, { bubbles: true, cancelable: true });
      OriginalCustomEvent.relatedTarget = related;
      element.dispatchEvent(OriginalCustomEvent);
      element.removeEventListener(eventName, element);
    }
  });
})();
