<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  State
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\State;

defined('_JEXEC') or die;

/**
 * Represents a state property.
 *
 * @since  __DEPLOY_VERSION__
 */
class PopulableProperty extends Property
{
	/**
	 * Can this property be populated from request?
	 *
	 * @var  boolean
	 */
	protected $isPopulable = true;
}
