/**
 * @package     Joomla.Installation
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

(function() {
	// Make sure that we have the Joomla object
	Joomla = window.Joomla || {};
	Joomla.installation = Joomla.installation || {};

	Joomla.progressValue = 0;
	Joomla.progress = document.querySelector('#installation-progress');

	Joomla.updateProgress = function(updateValue = 25, defaultValue = 0) {
		if (defaultValue > 0) {
			Joomla.progressValue = defaultValue;	
		} else {
			if (updateValue >= 0) {
				Joomla.progressValue += updateValue;
			} else {
				Joomla.progressValue -= (updateValue * (-1));
			}
		}
		
		if (Joomla.progressValue < 0) Joomla.progressValue = 0;
		if (Joomla.progress) {
			Joomla.progress.style.width = `${Joomla.progressValue}%`;
			document.querySelector('.j-progress-percent').innerHTML = `${Joomla.progressValue}%`;
		}
	};

	// If invalid step then add exclamation error beside the step text
	Joomla.setValidationStatus = function(selector, status) {
		const element = document.querySelector(selector);

		if (element) {
			if (status == 'show') {
				if (!element.classList.contains('j-insallation-has-error')) {
					element.classList.add('j-insallation-has-error');
				}
			} else if (status == 'hide') {
				if (element.classList.contains('j-insallation-has-error')) {
					element.classList.remove('j-insallation-has-error');
				}
			}
		}
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

	const dbBackup = document.querySelector('#db-backup .j-spinner');
	const dbBackupLi = document.querySelector('#db-backup');
	const dbCreate = document.querySelector('#db-create .j-spinner');
	const dbCreateLi = document.querySelector('#db-create');
	const configFile = document.querySelector('#configuration-file .j-spinner');
	const configFileLi = document.querySelector('#configuration-file');

	/**
	 * Method to request a different page via AJAX
	 *
	 * @param  page        The name of the view to request
	 * @param  fromSubmit  Unknown use
	 *
	 * @return {Boolean}
	 */
	Joomla.goToPage = function(page, fromSubmit) {
		if (!fromSubmit) {
			Joomla.removeMessages();
			// Joomla.loadingLayer("show");
		}
		
		if (page) {
			Joomla.updateProgress(0, 100);
			window.location = Joomla.baseUrl + '?view=' + page + '&layout=default';
		}

		return false;
	};

	/**
	 * Method to submit a form from the installer via AJAX
	 *
	 * @return {Boolean}
	 */
	Joomla.submitform = function(form) {
		var data = Joomla.serialiseForm(form);

		// Joomla.loadingLayer("show");
		Joomla.removeMessages();

		Joomla.request({
			type     : "POST",
			url      : Jooomla.baseUrl,
			data     : data,
			dataType : 'json',
			onSuccess: function (response, xhr) {
				response = JSON.parse(response);

				if (response.messages) {
					Joomla.renderMessages(response.messages);
				}

				if (response.error) {
					Joomla.renderMessages({'error': [response.message]});
					// Joomla.loadingLayer("hide");
					Joomla.updateProgress(-25);
				} else {
					// Joomla.loadingLayer("hide");
					if (response.data && response.data.view) {
						Install.goToPage(response.data.view, true);
					}
					Joomla.updateProgress();
				}
			},
			onError  : function (xhr) {
				// Joomla.loadingLayer("hide");
				Joomla.updateProgress(-25);
				busy = false;
				try {
					var r = JSON.parse(xhr.responseText);
					Joomla.replaceTokens(r.token);
					alert(r.message);
				} catch (e) {
				}
			}
		});

		return false;
	};

	Joomla.scrollTo = function (elem, pos)
	{
		var y = elem.scrollTop;
		y += (pos - y) * 0.3;
		if (Math.abs(y-pos) < 2)
		{
			elem.scrollTop = pos;
			return;
		}
		elem.scrollTop = y;
		setTimeout(Joomla.scrollTo, 40, elem, pos);
	};

	Joomla.checkFormField = function(fields) {
		var state = [];
		fields.forEach(function(field) {
			state.push(document.formvalidator.validate(document.querySelector(field)));
		});

		if (state.indexOf(false) > -1) {
			return false;
		}
		return true;
	};

	// Init on dom content loaded event
	Joomla.makeRandomDbPrefix = function() {
		var numbers = '0123456789', letters = 'abcdefghijklmnopqrstuvwxyz', symbols = numbers + letters;
		var prefix = letters[Math.floor(Math.random() * 24)];

		for (var i = 0; i < 4; i++ ) {
			prefix += symbols[Math.floor(Math.random() * 34)];
		}

		document.getElementById('jform_db_prefix').value = prefix + '_';

		return prefix + '_';
	};

	/**
	 * Initializes JavaScript events on each request, required for AJAX
	 */
	Joomla.pageInit = function() {
		// Attach the validator
		[].slice.call(document.querySelectorAll('form.form-validate')).forEach(function(form) {
			document.formvalidator.attachToForm(form);
		});

		// Create and append the loading layer.
		// Joomla.loadingLayer("load");

		// Check for FTP credentials
		Joomla.installation = Joomla.installation || {};

		// autofocus the language selector at the beginning
		if (document.querySelector('#installStep0'))
			document.querySelector('#installStep0').querySelector('select').focus();

		// @todo FTP persistent data ?
		// Initialize the FTP installation data
		// if (sessionStorage && sessionStorage.getItem('installation-data')) {
		// 	var data = sessionStorage.getItem('installData').split(',');
		// 	Joomla.installation.data = {
		// 		ftpUsername: data[0],
		// 		ftpPassword: data[1],
		// 		ftpHost: data[2],
		// 		ftpPort: data[3],
		// 		ftpRoot: data[4]
		// 	};
		// }
		return 'Loaded...'
	};


	/**
	 * Executes the required tasks to complete site installation
	 *
	 * @param tasks       An array of install tasks to execute
	 */
	Joomla.install = function(tasks, form) {
		if (!form) {
			throw new Error('No form provided')
		}
		if (!tasks.length) {
			Joomla.goToPage('remove');
			return;
		}

		var task = tasks.shift();
		var data = Joomla.serialiseForm(form);
		// Joomla.loadingLayer("show");
		
		if (dbBackup && dbBackup.classList.contains('inactive')) dbBackup.classList.remove('inactive');
		if (dbBackupLi) dbBackupLi.classList.add('active');
		if (dbCreate && dbCreate.classList.contains('inactive')) dbCreate.classList.remove('inactive');
		if (dbCreateLi) dbCreateLi.classList.add('active');
		if (configFile && configFile.classList.contains('inactive')) configFile.classList.remove('inactive');
		if (configFileLi) configFileLi.classList.add('active');

		if (tasks.indexOf('backup') == -1) {
			Joomla.updateProgress(25);
			if (dbBackup) dbBackup.classList.add('done');
		}

		if (tasks.indexOf('database') == -1) {
			Joomla.updateProgress(30);
			if (dbCreate) dbCreate.classList.add('done');
		}

		Joomla.request({
			method: "POST",
			url : Joomla.baseUrl + '?task=installation.' + task + '&format=json',
			data: data,
			perform: true,
			onSuccess: function(response, xhr){
				response = JSON.parse(response);
				Joomla.replaceTokens(response.token);

				if (response.error === true)
				{
					// Joomla.loadingLayer('hide');
					Joomla.renderMessages({"error": [response.message]});
					return false;
				}

				if (response.messages) {
					// Joomla.loadingLayer('hide');
					Joomla.renderMessages(response.messages);
					return false;
				}
				
				if (!response.error) {
					if (task == 'config') {
						Joomla.updateProgress(35);
						if (configFile) configFile.classList.add('done');
					} else if (task == 'database') {
						Joomla.updateProgress(30);
						if (dbCreate) dbCreate.classList.add('done');
					} else if (task == 'backup') {
						Joomla.updateProgress(25);
						if (dbBackup) dbBackup.classList.add('done');
					}
				} else {
					if (task == 'config') {
						Joomla.updateProgress(-35);
						if (configFile) {
							if (configFile.classList.contains('done')) configFile.classList.remove('done');
							configFile.classList.add('inactive');
							configFile.classList.remove('active');
						}
					} else if (task == 'database') {
						Joomla.updateProgress(-30);
						if (dbCreate) {
							if (dbCreate.classList.contains('done')) dbCreate.classList.remove('done');
							dbCreate.classList.add('inactive');
							dbCreate.classList.remove('active');
						}
					} else if (task == 'backup') {
						Joomla.updateProgress(-25);
						if (dbBackup) {
							if (dbBackup.classList.contains('done')) dbBackup.classList.remove('done');
							dbBackup.classList.add('inactive');
							dbBackupLi.classList.remove('active');
						}
					}
				}

				// Joomla.loadingLayer('hide');
				Joomla.install(tasks, form);
			},
			onError: function(xhr){
				Joomla.renderMessages([['', Joomla.JText._('JLIB_DATABASE_ERROR_DATABASE_CONNECT', 'A Database error occurred.')]]);
				Joomla.goToPage('remove');

				try {
					var r = JSON.parse(xhr.responseText);
					Joomla.replaceTokens(r.token);
					alert(r.message);
				} catch (e) {
				}
			}
		});
	};

	/* Load scripts async */
	document.addEventListener('DOMContentLoaded', function() {
		var page = document.getElementById('installer-view');

		// Set the base URL
		Joomla.baseUrl = Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php';

		// Show the container
		var container = document.getElementById('container-installation');
		if (container) {
			Joomla.installationBaseUrl = container.getAttribute('data-base-url');
			Joomla.installationBaseUrl += "installation/index.php"
		} else {
			throw new Error('Javascript required to be enabled!')
		}

		if (page && page.getAttribute('data-page-name')) {
			var script = document.querySelector('script[src*="template.js"]');
			el = document.createElement('script');
			el.src = script.src.replace("template.js", page.getAttribute('data-page-name') + '.js');
			document.head.appendChild(el);
		}

		if (container) {
			container.classList.remove('no-js');
			container.style.display = "block";
		}
	});
})();
