<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This action is used to update one or more mailings (delete, ...)
 *
 * @author Dave Lens <dave.lens@netlash.com>
 */
class BackendMailmotorMassMailingAction extends BackendBaseAction
{
	/**
	 * Execute the action
	 */
	public function execute()
	{
		parent::execute();

		// action to execute
		$action = SpoonFilter::getGetValue('action', array('delete'), 'delete');

		// no id's provided
		if(!isset($_GET['id'])) $this->redirect(BackendModel::createURLForAction('index') . '&error=no-items-selected');

		// at least one id
		else
		{
			// redefine id's
			$ids = (array) $_GET['id'];

			// delete comment(s)
			if($action == 'delete')
			{
				BackendMailmotorCMHelper::deleteMailings($ids);

				// trigger event
				BackendModel::triggerEvent($this->getModule(), 'after_delete_mailings', array('ids' => $ids));
			}
		}

		// redirect
		$this->redirect(BackendModel::createURLForAction('index') . '&report=delete-mailings');
	}
}
