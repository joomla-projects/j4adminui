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
        a11yActionBtn: '.accessible-action-btn',
        a11yMouseHighlighter: '#a11y-mouse-highlighter',
        bodyRoot: 'body',
        htmlRoot: 'html',
    };
    const a11yActionBtn  = [...document.querySelectorAll(selectors.a11yActionBtn)];
    const bodyRoot       = document.querySelector(selectors.bodyRoot);
    const htmlRoot       = document.querySelector(selectors.htmlRoot);
    
    const mouseHighlighter = document.getElementById('a11y-mouse-highlighter');
    const cursorPointer = document.querySelector('.a11y-cursor-pointer');
    const cursorPointerInner = document.querySelector('.a11y-cursor-pointer-inner');
    const supportsCssVariables = window.CSS && window.CSS.supports && window.CSS.supports('--fake-var', 0);

    // default options
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
    //grayscaleBtn.addEventListener('click', (e) => {
    a11yActionBtn.forEach(actionBtn=>{
        //console.log(action);
        actionBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let actionStatus    = false;
            const actionType    = actionBtn.getAttribute('data-type');

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
            }

            // if accessiblity action type no motion
            if (actionType == 'nomotion') {
                bodyRoot.classList.toggle('a11y-no-motion');
                actionStatus = true;
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
            }
            
            // if accessiblity type magnifier
            if (actionType == 'magnifier') {
                // apply/remove magnifier
                bodyRoot.classList.toggle('a11y-magnifier');
                actionStatus = true;
            }
            
            if (actionStatus == true) {
                actionBtn.classList.toggle('active');
                Joomla.renderMessages({ message: ['Successfully applied '] });
            } else {
                Joomla.renderMessages({ warning: ['Something went wrong'] });
            }

            // const accessibilityUrl = Joomla.getOptions('accessibilityUrl');
            // const data = '';

            // Joomla.request({
            //     url: accessibilityUrl,
            //     method: 'POST',
            //     data,
            //     perform: true,
            //     onSuccess(res) {
            //         console.log(res);
            //         // const response = typeof res === 'string' && res.length > 0 ? JSON.parse(res) : false;
            //         // const data = response.data;
            //         // if (data.status) {

            //         // }
            //     },
            //     onError(xhr) {
            //         Joomla.renderMessages({ error: [xhr.response] });
            //     },
            // });

        });
    });

    // mouse highligter
    function pointerMove(e) {
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
        // set state
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

    function pointerInit() {
        requestAnimationFrame(repeatOften);
        cursorPointer.style.display = 'block';
        cursorPointerInner.style.display = 'block';
        cursorPointerInner.style.setProperty('--scale', 1);
        // remove previous mouse/cursor move
        if (window.PointerEvent) {
            bodyRoot.removeEventListener('pointermove', pointerInit);
        } else {
            bodyRoot.removeEventListener('mousemove', pointerInit);
        }
    }

    // pointer dispear
    function pointerDisapear() {
        if (supportsCssVariables) {
            cursorPointerInner.style.setProperty('--scale', 0);
        } else {
            cursorPointerInner.style.transform = 'scale(0)';
        }

        if (window.PointerEvent) {
            bodyRoot.removeEventListener('pointermove', pointerInit);
        } else {
            bodyRoot.removeEventListener('mousemove', pointerInit);
        }
    }
    
    mouseHighlighter.addEventListener('click', (e) => {
        if (e.target.checked) {

            if (window.PointerEvent) {
                bodyRoot.addEventListener('pointermove', pointerInit);
                bodyRoot.addEventListener('pointermove', pointerMove);

                // mouse enter and leave on the screen
                bodyRoot.addEventListener('pointerenter', pointerInit);
                bodyRoot.addEventListener('pointerleave', pointerDisapear);
            } else {
                bodyRoot.addEventListener('mousemove', pointerInit);
                bodyRoot.addEventListener('mousemove', pointerMove);

                // mouse enter and leave on the screen
                bodyRoot.addEventListener('mouseenter', pointerInit);
                bodyRoot.addEventListener('mouseleave', pointerDisapear);
            }
        } else {
            if (window.PointerEvent) {
                pointerDisapear();
                console.log('pointermove');
            } else {
                pointerDisapear();
                console.log('mousemove');
            }
        }
    });
    
    // a11yMouseHighlighter.addEventListener('click', (e) => {
    //     e.preventDefault();
    //     //console.log('checked');
    //     // if (a11yMouseHighlighter.checked == true) {
    //     //     console.log('checked');
    //     //     a11yMouseHighlighter.checked = true;
    //     // }
    // });



    // $(function () {
    //     const cursorPointer = document.querySelector('.a11y-cursor-pointer');
    //     const cursorPointerInner = document.querySelector('.a11y-cursor-pointer-inner');
    //     const supportsCssVariables = window.CSS && window.CSS.supports && window.CSS.supports('--fake-var', 0);
        
    //     // default options
    //     let options = {
    //         movementSmoothness: 2,
    //         currentX: 0,
    //         currentY: 0,
    //         currentScale: 1,
    //         clientX: 0,
    //         clientY: 0,
    //         clientScale: 1,
    //         target: null
    //     };

    //     function pointerMove(e) {
    //         if (e.clientX) {
    //             // position of the mouse based on the window
    //             let mouseX = e.clientX;
    //             let mouseY = e.clientY;

    //             // get the target position, usualy the mouse position if not snapping
    //             options.clientX = options.target ? options.target.x : mouseX; // mouse X position or snap target
    //             options.clientY = options.target ? options.target.y : mouseY; // mouse Y position or snap target
    //         }
    //     }

    //     function repeatOften() {
    //         // set state
    //         options.currentX = +(options.currentX + (options.clientX - options.currentX) / options.movementSmoothness).toFixed(2);
    //         options.currentY = +(options.currentY + (options.clientY - options.currentY) / options.movementSmoothness).toFixed(2);
    //         if (supportsCssVariables) {
    //             // set the css variables
    //             cursorPointer.style.setProperty('--x', options.currentX + 'px');
    //             cursorPointer.style.setProperty('--y', options.currentY + 'px');
    //         } else {
    //             cursorPointer.style.transform = 'translate3d(' + options.currentX + 'px,' + options.currentY + 'px,0)';
    //             cursorPointerInner.style.transform = 'scale(' + options.currentScale.toFixed(2) + ')';
    //         }

    //         requestAnimationFrame(repeatOften);
    //     }

    //     function pointerInit() {
    //         requestAnimationFrame(repeatOften);
    //         cursorPointer.style.display = 'block';
    //         cursorPointerInner.style.display = 'block';
    //         cursorPointerInner.style.setProperty('--scale', 1);
    //         // remove previous mouse/cursor move
    //         if (window.PointerEvent) {
    //             bodyRoot.removeEventListener('pointermove', pointerInit);
    //         } else {
    //             bodyRoot.removeEventListener('mousemove', pointerInit);
    //         }
    //     }

    //     // pointer dispear
    //     function pointerDisapear() {
    //         if (supportsCssVariables) {
    //             cursorPointerInner.style.setProperty('--scale', 0);
    //         } else {
    //             cursorPointerInner.style.transform = 'scale(0)';
    //         }
    //     }

    //     if (window.PointerEvent) {
    //         bodyRoot.addEventListener('pointermove', pointerInit);
    //         bodyRoot.addEventListener('pointermove', pointerMove);

    //         // mouse enter and leave on the screen
    //         bodyRoot.addEventListener('pointerenter', pointerInit);
    //         bodyRoot.addEventListener('pointerleave', pointerDisapear);
    //     } else {
    //         bodyRoot.addEventListener('mousemove', pointerInit);
    //         bodyRoot.addEventListener('mousemove', pointerMove);
            
    //         // mouse enter and leave on the screen
    //         bodyRoot.addEventListener('mouseenter', pointerInit);
    //         bodyRoot.addEventListener('mouseleave', pointerDisapear);
    //     }
    // });

})(window.Joomla, document);
