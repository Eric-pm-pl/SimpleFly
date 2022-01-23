<?php 

/*
 * SimpleFly plugin for PocketMine-MP
 * Copyright (C) 2022 JeroGamingYT-pm-pl <https://github.com/JeroGamingYT-pm-pl/SimpleFly>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

declare(strict_types=1);

namespace YTBJero\SimpleFly;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\player\Player;

class EventListener implements Listener 
{
	/**@Var Main $plugin*/
	public $plugin;
	/**
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	/**
	 * @param  PlayerJoinEvent $event
	 */
	public function onPlayerJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$config = $this->plugin->getConfig();
		if($config->get('event.join.reset'))
		{
			if($player->isCreative(true)) return;
			if($player->isFlying())
			{
				$player->setFlying(false);
				$player->sendMessage($config->get('join.disable'));
			}
		}
	}

	/**
	 * @param  EntityTeleportEvent $event
	 */
	public function onPlayerTeleport(EntityTeleportEvent $event)
	{
		$player = $event->getEntity();
		$config = $this->plugin->getConfig();
		if($player instanceof Player)
		{
			if($config->get('event.world-move.disable'))
			{
				if($player->isCreative(true)) return;
				if($player->isFlying())
				{
					$player->setFlying(false);
					$player->sendMessage($config->get('world-move.disable'));
				}
			}
		}
	}

	/**
	 * @param  EntityDamageEvent $event
	 */
	public function onDamage(EntityDamageEvent $event)
	{
		$player = $event->getEntity();
		$config = $this->plugin->getConfig();
		if($event instanceof EntityDamageByEntityEvent){
			if($config->get('event.damage.disable')){
				$damager = $event->getDamager();
				if($damager instanceof Player)
				{
					if($damager->isCreative(true)) return;
					if($damager->isFlying())
					{
						$damager->setFlying(false);
						$damager->sendMessage($config->get('damage.disable'));
					}
				}
			}
		}
	}
}