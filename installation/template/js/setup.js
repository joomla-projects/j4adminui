/**
 * @package     Joomla.Installation
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Method to set the language for the installation UI via AJAX
 *
 * @return {Boolean}
 */
Joomla.setlanguage = function(form) {
  var data = Joomla.serialiseForm(form);
  Joomla.removeMessages();
  document.body.appendChild(document.createElement('joomla-core-loader'));

  Joomla.request({
    url: Joomla.baseUrl,
    method: 'POST',
    data: data,
    perform: true,
    onSuccess: function(response, xhr){
      response = JSON.parse(response);
      Joomla.replaceTokens(response.token);
      var loaderElement = document.querySelector('joomla-core-loader');

      if (response.messages) {
        Joomla.renderMessages(response.messages);
      }

      if (response.error) {
        loaderElement.parentNode.removeChild(loaderElement);
        Joomla.renderMessages({'error': [response.message]});
      } else {
        loaderElement.parentNode.removeChild(loaderElement);
        Joomla.goToPage(response.data.view, true);
      }
    },
    onError:   function(xhr){
      var loaderElement = document.querySelector('joomla-core-loader');
      loaderElement.parentNode.removeChild(loaderElement);
      try {
        var r = JSON.parse(xhr.responseText);
        Joomla.replaceTokens(r.token);
        alert(r.message);
      } catch (e) {}
    }
  });

  return false;
};

Joomla.checkInputs = function() {
  document.getElementById('jform_admin_password2').value = document.getElementById('jform_admin_password').value;

  var inputs = [].slice.call(document.querySelectorAll('input[type="password"], input[type="text"], input[type="email"], select')),
    state = true;
  inputs.forEach(function(item) {
    if (!item.valid) state = false;
  });

	if (Joomla.checkFormField(['#jform_site_name', '#jform_admin_user', '#jform_admin_email', '#jform_admin_password', '#jform_db_type', '#jform_db_host', '#jform_db_user', '#jform_db_name'])) {
		Joomla.checkDbCredentials();
	}
};


Joomla.checkDbCredentials = function() {
	// Joomla.loadingLayer("show");
	const dbCheck = document.querySelector('#db-check .j-spinner');
	const dbCheckLi = document.querySelector('#db-check');

	var form = document.getElementById('adminForm'),
		data = Joomla.serialiseForm(form);
	
	if (dbCheck) dbCheck.classList.remove('inactive');
	if (dbCheckLi) dbCheckLi.classList.add('active');
	
	Joomla.request({
		method: "POST",
		url : Joomla.installationBaseUrl + '?task=installation.dbcheck&format=json',
		data: data,
		perform: true,
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		onSuccess: function(response, xhr){
			response = JSON.parse(response);
			
			Joomla.updateProgress(10);
			if (dbCheck) dbCheck.classList.add('done');

			if (response.messages) {
				Joomla.renderMessages(response.messages);
				if (response.messages.error) {
					Joomla.updateProgress(-10);
					dbCheck.classList.remove('done');
					Joomla.setValidationStatus('#navStepLi3', 'show');
				} else {
					Joomla.setValidationStatus('#navStepLi3', 'hide');
				}
			}

			Joomla.replaceTokens(response.token);
			// Joomla.loadingLayer("hide");

			if (response.error) {
				Joomla.updateProgress(-10);
				dbCheck.classList.remove('done');
				dbCheck.classList.add('inactive');
				Joomla.renderMessages(response.message);
			} else if (response.data && response.data.validated === true) {
				// Run the installer - we let this handle the redirect for now
				// TODO: Convert to promises
				Joomla.install(['config'], form);
			}
		},
		onError:   function(xhr){
			Joomla.renderMessages([['', Joomla.JText._('JLIB_DATABASE_ERROR_DATABASE_CONNECT', 'A Database error occurred.')]]);
			//Install.goToPage('summary');
			// Joomla.loadingLayer('hide');
			Joomla.updateProgress(-10);
			Joomla.setValidationStatus('#navStepLi3', 'show');
			try {
				var r = JSON.parse(xhr.responseText);
				Joomla.replaceTokens(r.token);
				alert(r.message);
			} catch (e) {
			}
		}
	});
};

/**
 * Visible section and check if it is allowed to visible
 * 
 */
Joomla.isFilled = function(src) {
	const srcEl = document.querySelector(src);

	if (srcEl) {
		const fields = [...srcEl.querySelectorAll('input[required], select[required]')];
		let counter = 0;

		if (fields.length) {
			fields.forEach((field) => {
				if (field.value != '' && !field.classList.contains('invalid')) {
					counter += 1;
				}
			});
		}

		if (counter === fields.length) {
			return true;
		}
	}
	return false;
};

const clearAllActives = function() {
	const installStep0 = document.querySelector('#installStep0');
	const installStep1 = document.querySelector('#installStep1');
	const installStep2 = document.querySelector('#installStep2');
	const installStep3 = document.querySelector('#installStep3');
	const installStep4 = document.querySelector('#installStep4');
	const installStep5 = document.querySelector('#installStep5');

	const navStep0 	= document.querySelector('#navStep0');
	const navStep1 	= document.querySelector('#navStep1');
	const navStep2 	= document.querySelector('#navStep2');
	const navStep3 	= document.querySelector('#navStep3');
	const navStep4 	= document.querySelector('#navStep4');
	const navStep5 	= document.querySelector('#navStep5');

	installStep0.classList.remove('active');
	installStep1.classList.remove('active');
	installStep2.classList.remove('active');
	installStep3.classList.remove('active');
	installStep4.classList.remove('active');
	// installStep5.classList.remove('active');
	
	navStep0.classList.remove('active');
	navStep1.classList.remove('active');
	navStep2.classList.remove('active');
	navStep3.classList.remove('active');
	navStep4.classList.remove('active');
	// navStep5.classList.remove('active');
};

const completePath = function(index) {
	const navSteps = [];
	navSteps.push(document.querySelector('#navStep0'));
	navSteps.push(document.querySelector('#navStep1'));
	navSteps.push(document.querySelector('#navStep2'));
	navSteps.push(document.querySelector('#navStep3'));
	navSteps.push(document.querySelector('#navStep4'));
	navSteps.push(document.querySelector('#navStep5'));

	for (let i = 0; i < index ; i += 1) {
		navSteps[i].classList.add('completed');
	}
};

(function() {
	// Merge options from the session storage
	if (sessionStorage && sessionStorage.getItem('installation-data')) {
		Joomla.extend(this.options, sessionStorage.getItem('installation-data'));
	}


	const languageForm 	= document.querySelector('#languageForm');
	const adminForm    	= document.querySelector('#adminForm');

	const installStep0 	= document.querySelector('#installStep0');
	const installStep1 	= document.querySelector('#installStep1');
	const installStep2 	= document.querySelector('#installStep2');
	const installStep3 	= document.querySelector('#installStep3');
	const installStep4 	= document.querySelector('#installStep4');
	const installStep5 	= document.querySelector('#installStep5');

	const navStep0 	= document.querySelector('#navStep0');
	const navStep1 	= document.querySelector('#navStep1');
	const navStep2 	= document.querySelector('#navStep2');
	const navStep3 	= document.querySelector('#navStep3');
	const navStep4 	= document.querySelector('#navStep4');
	const navStep5 	= document.querySelector('#navStep5');

	const btnStep0 	= document.querySelector('#step0');
	const btnStep1 	= document.querySelector('#step1');
	const btnStep2 	= document.querySelector('#step2');
	const btnStep3 	= document.querySelector('#setupButton');
	const btnStep4 	= document.querySelector('#step4');
	const btnStep5 	= document.querySelector('#step5');
	
	Joomla.pageInit();

	var el = document.querySelector('.nav-steps.hidden');

	if (el) {
		el.classList.remove('hidden');
	}

	// Focus to the next field
	if (document.getElementById('jform_site_name')) {
		document.getElementById('jform_site_name').focus();
	}

	// Select language
	var languageEl = document.getElementById('jform_language');

	if (languageEl) {
		languageEl.addEventListener('change', function(e) {
			var form = document.getElementById('languageForm');
			Joomla.setlanguage(form);
		})
	}

	if (navStep1) {
		navStep1.addEventListener('click', function(e){
			e.preventDefault();
			
			if (Joomla.isFilled('#installStep0')) {
				clearAllActives();

				if (adminForm.classList.contains('d-none')) {
					adminForm.classList.remove('d-none');
					adminForm.classList.add('active');
					languageForm.classList.remove('active');
					languageForm.classList.add('d-none');
				}
				
				installStep1.classList.add('active');
				navStep1.classList.add('active');
				navStep0.classList.remove('active');
				completePath(1);
				Joomla.removeMessages();

				Joomla.setValidationStatus('#navStepLi0', 'hide');
			} else {
				Joomla.setValidationStatus('#navStepLi0', 'show');
			}
		});
	}

	if (navStep2) {
		navStep2.addEventListener('click', function(e){
			e.preventDefault();
			if (Joomla.isFilled('#installStep1')) {
				clearAllActives();
				installStep2.classList.add('active');
				navStep2.classList.add('active');
				completePath(2);

				Joomla.removeMessages();
				Joomla.setValidationStatus('#navStepLi1', 'hide');
			} else {
				Joomla.setValidationStatus('#navStepLi1', 'show');
			}
		});
	}

	if (navStep3) {
		navStep3.addEventListener('click', function(e){
			e.preventDefault();
			if (Joomla.isFilled('#installStep2')) {
				clearAllActives();
				installStep3.classList.add('active');
				navStep3.classList.add('active');
				completePath(3);

				Joomla.removeMessages();
				Joomla.setValidationStatus('#navStepLi2', 'hide');
			} else {
				Joomla.setValidationStatus('#navStepLi2', 'show');
			}
		});
	}


	// button clicks
	if (btnStep0) {
		btnStep0.addEventListener('click', function(e){
			e.preventDefault();
			
			if (Joomla.isFilled('#installStep0')) {
				if (installStep1) {
					clearAllActives();
					if (adminForm.classList.contains('d-none')) {
						adminForm.classList.remove('d-none');
						adminForm.classList.add('active');
						languageForm.classList.remove('active');
						languageForm.classList.add('d-none');
					}
					
					installStep1.classList.add('active');
					navStep1.classList.add('active');
					navStep0.classList.remove('active');
					
					// Focus to the next field
					if (document.getElementById('jform_site_name')) {
						document.getElementById('jform_site_name').focus();
					}
					
					completePath(1);
					Joomla.removeMessages();
					Joomla.setValidationStatus('#navStepLi0', 'hide');
				}
			} else {
				Joomla.setValidationStatus('#navStepLi0', 'show');
			}
		});
	}


	if (document.getElementById('step1')) {
		document.getElementById('step1').addEventListener('click', function(e) {
			e.preventDefault();
			
			if (Joomla.isFilled('#installStep1')) {
				if (installStep2) {
					clearAllActives();
					installStep2.classList.add('active');
					navStep2.classList.add('active');

					// Focus to the next field
					if (document.getElementById('jform_admin_user')) {
						document.getElementById('jform_admin_user').focus();
					}
					completePath(2);
					Joomla.removeMessages();
					Joomla.setValidationStatus('#navStepLi1', 'hide');
				}
			} else {
				Joomla.setValidationStatus('#navStepLi1', 'show');
			}
		});
	}

	if (document.getElementById('step2')) {
		document.getElementById('step2').addEventListener('click', function(e) {
			e.preventDefault();

			if (Joomla.isFilled('#installStep2')) {
				if (installStep3) {
					clearAllActives();

					installStep3.classList.add('active');
					navStep3.classList.add('active');
					document.getElementById('setupButton').style.display = 'block';
					
					Joomla.makeRandomDbPrefix();
					
					// Focus to the next field
					if (document.getElementById('jform_db_type')) {
						document.getElementById('jform_db_type').focus();
					}
					completePath(3);
					Joomla.removeMessages();
					Joomla.setValidationStatus('#navStepLi2', 'hide');
				}
			} else {
				Joomla.setValidationStatus('#navStepLi2', 'show');
			}
		});

		document.getElementById('setupButton').addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			if (Joomla.isFilled('#installStep3')) {
				clearAllActives();
				installStep4.classList.add('active');
				navStep4.classList.add('active');
				completePath(4);
				Joomla.checkInputs();
				Joomla.removeMessages();
				Joomla.setValidationStatus('#navStepLi3', 'hide');
			} else {
				Joomla.setValidationStatus('#navStepLi3', 'show');
			}
		});
	}

})();
