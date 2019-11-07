<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Templates\Administrator\Controller;

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Utilities\ArrayHelper;
/**
 * Template styles list controller class.
 *
 * @since  1.6
 */
class StylesController extends AdminController
{
	/**
	 * Method to clone and existing template style.
	 *
	 * @return  void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		$this->checkToken();

		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new \Exception(Text::_('COM_TEMPLATES_NO_TEMPLATE_SELECTED'));
			}

			$pks = ArrayHelper::toInteger($pks);

			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Text::_('COM_TEMPLATES_SUCCESS_DUPLICATED'));
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage($e->getMessage(), 'error');
		}

		$this->setRedirect('index.php?option=com_templates&view=styles');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Style', $prefix = 'Administrator', $config = array())
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}

	/**
	 * Method to set the home template for a client.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function setDefault()
	{
		// Check for request forgeries
		$this->checkToken();

		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new \Exception(Text::_('COM_TEMPLATES_NO_TEMPLATE_SELECTED'));
			}

			$pks = ArrayHelper::toInteger($pks);

			// Pop off the first element.
			$id = array_shift($pks);

			/* @var \Joomla\Component\Templates\Administrator\Model\StyleModel $model */
			$model = $this->getModel();
			$model->setHome($id);
			$this->setMessage(Text::_('COM_TEMPLATES_SUCCESS_HOME_SET'));
		}
		catch (\Exception $e)
		{
			$this->setMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_templates&view=styles');
	}

	/**
	 * Method to unset the default template for a client and for a language
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function unsetDefault()
	{
		// Check for request forgeries
		$this->checkToken('request');

		$pks = $this->input->get->get('cid', array(), 'array');
		$pks = ArrayHelper::toInteger($pks);

		try
		{
			if (empty($pks))
			{
				throw new \Exception(Text::_('COM_TEMPLATES_NO_TEMPLATE_SELECTED'));
			}

			// Pop off the first element.
			$id = array_shift($pks);

			/* @var \Joomla\Component\Templates\Administrator\Model\StyleModel $model */
			$model = $this->getModel();
			$model->unsetHome($id);
			$this->setMessage(Text::_('COM_TEMPLATES_SUCCESS_HOME_UNSET'));
		}
		catch (\Exception $e)
		{
			$this->setMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_templates&view=styles');
	}

	/**
	 * Install template from upload file
	 *
	 * @since 	4.0.0
	 */
	public function install() {
		// Check for request forgeries.
		$this->checkToken();

		/** @var \Joomla\Component\Installer\Administrator\Model\InstallModel $model */
		$model = Factory::getApplication()->bootComponent('com_installer')
			->getMVCFactory()->createModel('install', 'Administrator', ['ignore_request' => true]);

		// TODO: Reset the users acl here as well to kill off any missing bits.
		$result = $model->install();

		$app = $this->app;
		$redirect_url = $app->getUserState('com_templates.redirect_url');

		if (!$redirect_url)
		{
			$redirect_url = base64_decode($this->input->get('return'));
		}

		// Don't redirect to an external URL.
		if (!Uri::isInternal($redirect_url))
		{
			$redirect_url = '';
		}

		if (empty($redirect_url))
		{
			$redirect_url = Route::_('index.php?option=com_templates&view=styles', false);
		}
		else
		{
			// Wipe out the user state when we're going to redirect.
			$app->setUserState('com_templates.redirect_url', '');
			$app->setUserState('com_templates.message', '');
			$app->setUserState('com_templates.extension_message', '');
		}

		$this->setRedirect($redirect_url);

		return $result;
	}

	/**
	 * Install an extension from drag & drop ajax upload.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function ajax_upload()
	{
		try{
			$message = $this->app->getUserState('com_templates.message');

			// Do install
			$result = $this->install();

			// Get redirect URL
			$redirect = Route::_('index.php?option=com_templates&view=styles', false);

			// // Push message queue to session because we will redirect page by \Javascript, not $app->redirect().
			// // The "application.queue" is only set in redirect() method, so we must manually store it.
			$this->app->getSession()->set('application.queue', $this->app->getMessageQueue());

			header('Content-Type: application/json');

			echo new JsonResponse(array('redirect' => $redirect), $message, !$result);
			$this->app->close();
		} catch (Exception $e) {
			echo new JsonResponse(array('message' => $e->getMessage(),'success'=>false));
		}
	}
}
