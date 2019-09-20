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
        form: '#form-draftarticle',
        submitBtn: '#mod-draftarticle-submit',
        cancelBtn: '#mod-draftarticle-cancel'
    };

    Joomla.serialiseForm = function( form ) {
		var i, l, obj = [], elements = form.querySelectorAll( "input, select, textarea" );
		for(i = 0, l = elements.length; i < l; i++) {
			var name = elements[i].name;
			var value = elements[i].value;
			if(name) {
				if ((elements[i].type === 'checkbox' && elements[i].checked === true) || (elements[i].type !== 'checkbox')) {
					obj.push(name.replace('[', '%5B').replace(']', '%5D') + '=' + encodeURIComponent(value));
				}
			}
		}
		return obj.join("&");
	};
    
    const theForm = document.querySelector(selectors.form);
    const theCancelBtn = document.querySelector(selectors.cancelBtn);

    theForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const saveurl = Joomla.getOptions('saveurl');
        const data = Joomla.serialiseForm(theForm);
        
        console.log('formData', data, saveurl);

        Joomla.request({
            url: saveurl,
            method: 'POST',
            data,
            perform: true,
            onSuccess: function(response) {
                console.log(response);
            },
            onError: function(xhr) {
                Joomla.renderMessages({error: [xhr.response]});
            }
        });
    });


})(window.Joomla, document);