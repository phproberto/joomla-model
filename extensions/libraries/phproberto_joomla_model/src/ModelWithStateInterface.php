<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Model
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model;

defined('_JEXEC') || die;

use Phproberto\Joomla\Model\State\StateInterface;

/**
 * Represents a model with plugable state classes.
 *
 * @since  __DEPLOY_VERSION__
 */
interface ModelWithStateInterface
{
	/**
	 * Retrieve the model state.
	 *
	 * @return  StateInterface
	 */
	public function state();
}
