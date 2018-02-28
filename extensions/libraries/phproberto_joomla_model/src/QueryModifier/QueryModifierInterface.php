<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  QueryModifier
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\QueryModifier;

defined('_JEXEC') || die;

/**
 * Represents a query modifier.
 *
 * @since  __DEPLOY_VERSION__
 */
interface QueryModifierInterface
{
	/**
	 * Modifies the query.
	 *
	 * @return  void
	 */
	public function apply();
}
