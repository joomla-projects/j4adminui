/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @since   4.0.0
 */

/* eslint-disable */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory()
    : typeof define === 'function' && define.amd ? define(factory)
      : (global = global || self, global.JoomlaMenu = factory());
}(this, () => {
  'use strict';
  /* eslint-enable */
  // eslint-disable-next-line func-names
  const JoomlaMenu = (function () {
    class JoomlaMenuClass {
      constructor(element, options) {
        this.settings = {
          triggerParent: 'li',
          subMenuEl: 'ul',
          toggle: true,
          triggerElement: 'a',
        };
        this.classList = {
          ACTIVE: 'active',
          COLLAPSE: 'collapse',
          COLLAPSED: 'collapsed',
          COLLAPSING: 'collapsing',
          MENUCLASS: 'j-menu',
          SHOW: 'open',
        };
        this.isTranstioning = false;
        this.element = typeof element === 'string' ? document.querySelector(element) : element;
        this.config = Object.assign({}, this.settings, options);

        this.init();
      }

      /**
       * Initiate function for the admin menu
       * If has no element then return false
       *
       * Collect all sub menu ul and check if any one has open class
       * If has open class then show otherwise hide them
       * Bind click event each link which has sub-menus
       */
      init() {
        if (this.element === null) { return; }
        const { classList } = this;
        this.element.classList.add(classList.MENUCLASS);
        this.ulCollection = [].slice.call(this.element.querySelectorAll(this.config.subMenuEl));

        for (let i = 0, item = this.ulCollection; i < item.length; i += 1) {
          const ul = item[i];
          const li = ul.parentNode;
          ul.classList.add(classList.COLLAPSE);
          if (li.classList.contains(classList.ACTIVE)) {
            this.show(ul);
          } else {
            this.hide(ul);
          }
          const a = li.querySelector(this.config.triggerElement);
          if (a.getAttribute('area-disabled') === 'true') {
            return;
          }
          a.setAttribute('area-expanded', 'false');
          a.addEventListener('click', this.clickEvent.bind(this), false);
        }
      }

      /**
       * Show selected sub element
       * @param {element} ul
       */
      show(ul) {
        if (ul.classList.contains(this.classList.COLLAPSING)) { return; }
        const complete = () => {
          ul.classList.remove(this.classList.COLLAPSING);
          ul.style.height = '';
          ul.removeEventListener('transitionend', complete);
          this.isTranstioning = false;
        };
        const li = ul.parentNode;
        li.classList.add(this.classList.ACTIVE);
        const a = li.querySelector(this.config.triggerElement);
        a.setAttribute('area-expanded', 'true');
        ul.style.height = '0px';
        ul.classList.remove(this.classList.COLLAPSE);
        ul.classList.remove(this.classList.SHOW);
        ul.classList.add(this.classList.COLLAPSING);
        const eleParentSiblins = [].slice
          .call(li.parentNode.children)
          .filter(c => c !== li);
        if (eleParentSiblins.length > 0) {
          for (
            let i = 0,
              itemParentSiblins = eleParentSiblins;
            i < itemParentSiblins.length; i += 1) {
            const sibli = itemParentSiblins[i];
            const sibUl = sibli.querySelector(this.config.subMenuEl);
            if (sibUl !== null) {
              this.hide(sibUl);
            }
          }
        }
        this.isTranstioning = true;
        ul.classList.add(this.classList.COLLAPSED, this.classList.SHOW);
        ul.style.height = `${ul.scrollHeight}px`;
        ul.addEventListener('transitionend', complete);
      }

      /**
       * Hide selected sub element
       * @param {element} ul
       */
      hide(ul) {
        if (this.isTranstioning || !ul.classList.contains(this.classList.SHOW)) { return; }
        const li = ul.parentNode;
        li.classList.remove(this.classList.ACTIVE);
        const complete = () => {
          ul.classList.remove(this.classList.COLLAPSING);
          ul.classList.add(this.classList.COLLAPSE);
          ul.style.height = '';
          ul.removeEventListener('transitionend', complete);
          this.isTranstioning = false;
        };
        ul.style.height = `${ul.getBoundingClientRect().height}px`;
        ul.style.height = `${ul.offsetHeight}px`;
        ul.classList.add(this.classList.COLLAPSING);
        ul.classList.remove(this.classList.COLLAPSE);
        ul.classList.remove(this.classList.SHOW);
        this.setTransitioning = true;
        ul.addEventListener('transitionend', complete);
        ul.style.height = '0px';
        const a = li.querySelector(this.config.triggerElement);
        a.setAttribute('aria-expanded', 'false');
        a.classList.add(this.classList.COLLAPSED);
      }

      /**
       * Toggle provide ul element
       * @param {element} ul
       */
      toggle(ul) {
        if (ul.parentNode.classList.contains(this.classList.ACTIVE)) {
          this.hide(ul);
        } else {
          this.show(ul);
        }
      }

      // eslint-disable-next-line class-methods-use-this
      clickEvent(event) {
        if (event.currentTarget.tagName === 'A') {
          event.preventDefault();
        }
        const li = event.currentTarget.parentNode;
        const ul = li.querySelector(this.config.subMenuEl);
        this.toggle(ul);
      }
    }
    return JoomlaMenuClass;
  }());
  return JoomlaMenu;
}));
