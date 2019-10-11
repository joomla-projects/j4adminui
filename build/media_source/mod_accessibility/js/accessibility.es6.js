/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((Joomla, document) => {
    'use strict';
    if (!Joomla) {
        throw new Error('Joomla API not properly initialised');
    }
    const selectors = {
        a11yCollapseBtn     : '#accessibility-collapse-control',
        a11ySidebar         : '.accessibility-sidebar',
        a11yScalingWrap     : '.accessibility-scaling',
        a11yActionBtn       : '.accessible-action-btn',
        a11yMagnifierBtn    : '[data-type="magnifier"]',
        a11yMouseHighlighter: '#a11y-mouse-highlighter',
        bodyRoot            : 'body',
        htmlRoot            : 'html',
    };
    //document.querySelector('[data-type="magnifier"]')

    const a11yCollapseBtn       = document.querySelector(selectors.a11yCollapseBtn);
    const a11ySidebar           = document.querySelector(selectors.a11ySidebar);
    const a11yScalingWrap       = document.querySelector(selectors.a11yScalingWrap);
    const a11yActionBtn         = [...document.querySelectorAll(selectors.a11yActionBtn)];
    const a11yMagnifierBtn      = document.querySelector(selectors.a11yMagnifierBtn);
    let   actionStatus          = false;
    const bodyRoot              = document.querySelector(selectors.bodyRoot);
    const htmlRoot              = document.querySelector(selectors.htmlRoot);
    
    const mouseHighlighter      = document.querySelector(selectors.a11yMouseHighlighter);
    const cursorPointer         = document.querySelector('.a11y-cursor-pointer');
    const cursorPointerInner    = document.querySelector('.a11y-cursor-pointer-inner');
    const supportsCssVariables  = window.CSS && window.CSS.supports && window.CSS.supports('--fake-var', 0);

    // Accessibility sidebar controller
    a11yCollapseBtn.addEventListener('click', (e) => {
        e.preventDefault();
        a11ySidebar.classList.toggle('active');
    });

    // Disapear sidebar if click outside of the siderbar
    document.addEventListener('click', (e) => {
        if ( !e.target.classList.contains('header-item-link') && (!event.target.closest(".mod-accessibility") && a11ySidebar.classList.contains('active')) ) {
            a11ySidebar.classList.remove('active');
        }
    });

    // all action buttons
    a11yActionBtn.forEach(actionBtn=>{
        actionBtn.addEventListener('click', (e) => {
            e.preventDefault();
            //let actionStatus    = false;
            const actionType    = actionBtn.getAttribute('data-type');
            const cuurentActionStatus = checkActionStatus(actionBtn);

            // if accessiblity action type grascale
            if (actionType == 'grayscale') {
                // reset contrast
                if (htmlRoot.classList.contains('a11y-enable-contrast')) {
                    htmlRoot.classList.remove('a11y-enable-contrast');
                    document.querySelector('[data-type="contrast"]').classList.remove('active');
                }
                
                // apply/remove grayscale
                htmlRoot.classList.toggle('a11y-grayscale');
                actionStatus = true;
                changeAcitonStatus(actionBtn);
            }

            // if accessiblity action type big white cursor
            if (actionType == 'bbcursor') {
                // reset white cursor
                if (bodyRoot.classList.contains('a11y-big-white-cursor')) {
                    bodyRoot.classList.remove('a11y-big-white-cursor');
                    document.querySelector('[data-type="bhcursor"]').classList.remove('active');
                }
                // apply/remove black cursor
                bodyRoot.classList.toggle('a11y-big-black-cursor');
                actionStatus = true;
                changeAcitonStatus(actionBtn);
            }

            // if accessiblity action type big white cursor
            if (actionType == 'bhcursor') {
                // reset black cursor
                if (bodyRoot.classList.contains('a11y-big-black-cursor')) {
                    bodyRoot.classList.remove('a11y-big-black-cursor');
                    document.querySelector('[data-type="bbcursor"]').classList.remove('active');
                }
                // apply/remove white cursor
                bodyRoot.classList.toggle('a11y-big-white-cursor');
                actionStatus = true;
                changeAcitonStatus(actionBtn);
            }

            // if accessiblity action type no motion
            if (actionType == 'nomotion') {
                bodyRoot.classList.toggle('a11y-no-motion');
                actionStatus = true;
                changeAcitonStatus(actionBtn);
            }

            // if accessiblity action type contrast
            if (actionType == 'contrast') {
                // reset grayscale
                if (htmlRoot.classList.contains('a11y-grayscale')) {
                    htmlRoot.classList.remove('a11y-grayscale');
                    document.querySelector('[data-type="grayscale"]').classList.remove('active');
                }
                // apply/remove contast
                htmlRoot.classList.toggle('a11y-enable-contrast');
                actionStatus = true;
                changeAcitonStatus(actionBtn);
            }
            
            // if accessiblity type magnifier
            if (actionType == 'magnifier') {
                magnifierInit();
                // apply/remove magnifier
                bodyRoot.classList.toggle('a11y-magnifier');
                actionStatus = true;
                changeAcitonStatus(actionBtn);
            }
        });
    });

    // check action status
    function checkActionStatus(action, actionType = '') {
        if(actionType == 'checkbox') {
            return action.checked;
        } else {
            if (action.classList.contains('active')) {
                return true;
            }
        }
        return false;
    }
    
    // *** text magnifier *** //
    function magnifierInit() {
        activateMagnifier();
    }

    function activateMagnifier() {
        const magnifiableTags = ['p', 'a', 'span', 'li', 'ul', 'img', 'button'];
        const selectors = magnifiableTags.reduce((accumulator, magnifiableTag) => {
            const getSelectors = [...document.querySelectorAll(`${magnifiableTag}`)];
            return [...accumulator, ...getSelectors];
        }, []);
        selectors.forEach((selector) => {
            selector.addEventListener('mouseenter', showMagnifier);
            selector.addEventListener('mouseleave', removeMagnifier);
        });
    }

    function showMagnifier(event) {
        event.preventDefault();
        // if mouse magnifier isn't enabled then return false
        if (checkActionStatus(document.querySelector('[data-type="magnifier"]')) == false) {
            return false;
        }
        let txt;
        if (event.target.title) {
            txt = event.target.title;
        } else {
            txt = event.target.innerText.replace(/<[^>]*>/g, "");
        }

        if (txt !== '') {
            generateMagnifier(txt, event.target);
        }
    }

    function generateMagnifier(text, item) {
        const itemRect = item.getBoundingClientRect();
        const magnifierWrap = document.createElement('span');
        magnifierWrap.classList.add('a11y-magnified-text');
        magnifierWrap.appendChild(document.createTextNode(text));

        const { firstChild } = document.body;
        firstChild.parentNode.insertBefore(magnifierWrap, firstChild);

        // positioning magnifier
        magnifierWrap.style.top = `${Math.round(itemRect.bottom)}px`
        magnifierWrap.style.left = `${Math.round(itemRect.left + (itemRect.width / 2))}px`;
    }

    function removeMagnifier() {
        const magnifiers = document.querySelectorAll('.a11y-magnified-text');
        magnifiers.forEach((magnifier) => {
            document.body.removeChild(magnifier);
        });
    }

    // *** Mouse highligter *** //
    if (a11yScalingWrap !== null) {
        // mouse highlighter default options
        let options = {
            movementSmoothness: 2,
            currentX: 0,
            currentY: 0,
            currentScale: 1,
            clientX: 0,
            clientY: 0,
            clientScale: 1,
            target: null
        };

        function pointerMove(e) {
            // if mouse highlighter isn't enabled then return false
            if (checkActionStatus(mouseHighlighter, 'checkbox') == false) {
                return false;
            }
            if (e.clientX) {
                // position of the mouse based on the window
                let mouseX = e.clientX;
                let mouseY = e.clientY;

                // get the target position, usualy the mouse position if not snapping
                options.clientX = options.target ? options.target.x : mouseX; // mouse X position or snap target
                options.clientY = options.target ? options.target.y : mouseY; // mouse Y position or snap target
            }
        }

        function repeatOften() {
            // set positions on option
            options.currentX = +(options.currentX + (options.clientX - options.currentX) / options.movementSmoothness).toFixed(2);
            options.currentY = +(options.currentY + (options.clientY - options.currentY) / options.movementSmoothness).toFixed(2);
            if (supportsCssVariables) {
                // set the css variables
                cursorPointer.style.setProperty('--x', options.currentX + 'px');
                cursorPointer.style.setProperty('--y', options.currentY + 'px');
            } else {
                cursorPointer.style.transform = 'translate3d(' + options.currentX + 'px,' + options.currentY + 'px,0)';
                cursorPointerInner.style.transform = 'scale(' + options.currentScale.toFixed(2) + ')';
            }

            requestAnimationFrame(repeatOften);
        }

        // pointer init
        function pointerInit() {
            // if mouse highlighter isn't enabled then return false
            if (checkActionStatus(mouseHighlighter, 'checkbox') == false) {
                return false;
            }
            requestAnimationFrame(repeatOften);
            cursorPointer.style.display = 'block';
            cursorPointerInner.style.display = 'block';
            cursorPointerInner.style.setProperty('--scale', 1);
        }

        function pointerAppear() {
            bodyRoot.addEventListener('mousemove', pointerInit);
            bodyRoot.addEventListener('mousemove', pointerMove);
            // mouse enter and leave on the screen
            bodyRoot.addEventListener('mouseenter', pointerInit);
            bodyRoot.addEventListener('mouseleave', pointerDisapear);
        }

        // pointer dispear
        function pointerDisapear() {
            if (supportsCssVariables) {
                cursorPointerInner.style.setProperty('--scale', 0);
            } else {
                cursorPointerInner.style.transform = 'scale(0)';
            }

            bodyRoot.removeEventListener('mousemove', pointerInit);
        }
        
        // check to appear/disapear highlighter
        mouseHighlighter.addEventListener('click', (e) => {
            if (e.target.checked) {
                pointerAppear();
            } else {
                pointerDisapear();
            }

            // change action status
            actionStatus = true;
            changeAcitonStatus('', 'checkbox')
        });
    }

    // if content scaling class has exist
    if (a11yScalingWrap !== null) {
        // *** Content Scalling *** //
        const increment = document.querySelector('#increment');
        const decrement = document.querySelector('#decrement');
        const fontPercent = document.querySelector('.font-percent-value');
        window.fontPercent = 0;

        let validTags = ['p', 'div', 'span', 'i', 'b', 'strong', 'section', 'article', 'h1', 'h2', 'h3', 'h4',
            'h5', 'h6', 'table', 'tr', 'th', 'td', 'a', 'ul', 'ol', 'li', 'input', 'button'];

        validTags = validTags.map(element => `${element}:not(.font-unresizable)`);

        const elements = [...document.querySelectorAll(validTags.join(', '))];

        elements.forEach(el => {
            let fontSize = window.getComputedStyle(el, null).getPropertyValue('font-size');
            if (typeof fontSize != 'undefined' && fontSize != '') {
                el.setAttribute('data-original-font-size', fontSize);
            }
        });

        increment.addEventListener('click', function (event) {
            window.fontPercent += 1;
            fontPercent.innerHTML = (window.fontPercent * 10) + '%';
            elements.forEach(el => {
                let fontSize = window.getComputedStyle(el, null).getPropertyValue('font-size');
                if (typeof fontSize != 'undefined' && fontSize != '') {
                    fontSize = parseFloat(fontSize);
                    fontSize += 1;
                    el.style.fontSize = `${fontSize}px`;
                }
            });
        });

        decrement.addEventListener('click', function (event) {
            window.fontPercent -= 1;
            fontPercent.innerHTML = (window.fontPercent * 10) + '%';
            elements.map(el => {
                let fontSize = window.getComputedStyle(el, null).getPropertyValue('font-size');
                if (typeof fontSize != 'undefined' && fontSize != '') {
                    fontSize = parseFloat(fontSize);
                    fontSize -= 1;
                    el.style.fontSize = `${fontSize}px`;
                }
            });
        });
    }

    // change action status
    function changeAcitonStatus(actionBtn, actionType = '') {
        if(actionType != 'checkbox') {
            actionBtn.classList.toggle('active');
        }
        // show action message
        if (actionStatus == true) {
            Joomla.renderMessages({ message: ['Successfully applied '] });
        } else {
            Joomla.renderMessages({ warning: ['Something went wrong'] });
        }
    }

})(window.Joomla, document);
