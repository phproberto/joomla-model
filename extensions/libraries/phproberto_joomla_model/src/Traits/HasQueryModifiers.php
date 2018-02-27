<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Traits
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Traits;

defined('_JEXEC') or die;

use Phproberto\Joomla\Model\QueryModifier\QueryModifierInterface;

/**
 * Trait for models with query modifiers.
 *
 * @since  __DEPLOY_VERSION__
 */
trait HasQueryModifiers
{
	/**
	 * Apply a query modifier.
	 *
	 * @param   QueryModifierInterface  $modifier  [description]
	 *
	 * @return  void
	 */
	public function applyQueryModifier(QueryModifierInterface $modifier)
	{
		$modifier->apply();
	}

	/**
	 * Apply an array of query modifiers.
	 *
	 * @param   QueryModifierInterface[]  $modifiers  Query modifiers to apply
	 *
	 * @return  void
	 */
	public function applyQueryModifiers(array $modifiers)
	{
		foreach ($modifiers as $modifier)
		{
			$modifier->apply();
		}
	}
}
