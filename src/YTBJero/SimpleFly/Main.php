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

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{

	public function onEnable(): void 
	{
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->saveDefaultConfig();
	}

	/**
	 * @param  CommandSender $sender
	 * @param  Command       $command
	 * @param  String        $label
	 * @param  Array         $args
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, Command $command, String $label, Array $args): bool 
	{
		if($command->getName() == "fly")
		{
			if(empty($args[0])){
				if($sender->isCreative(true))
				{
					$sender->sendMessage($this->getConfig()->get('fly.creative'));
					return false;
				}
				if($sender->isFlying())
				{
					$sender->setFlying(false);
					$sender->sendMessage($this->getConfig()->get('fly.off'));
					return false;
				} else{
					$sender->setFlying(true);
					$sender->sendMessage($this->getConfig()->get('fly.on'));
					return false;
				}
			}
			if(isset($args[0])){
				if($this->getServer()->getPlayerExact($args[0]) !== null)
				{
					$player = $this->getServer()->getPlayerExact($args[0]);
					if($player->isCreative(true))
					{
						$sender->sendMessage(str_replace('{PLAYER}', $player->getName(), $this->getConfig()->get('fly.other.creative')));
						return false;
					} else{
						if($player->isFlying())
						{
							$player->setFlying(false);
							$sender->sendMessage(str_replace('{PLAYER}', $player->getName(), $this->getConfig()->get('fly.other.off')));
							return false;
						} else{
							$player->setFlying(true);
							$sender->sendMessage(str_replace('{PLAYER}', $player->getName(), $this->getConfig()->get('fly.other.on')));
							return false;
						}
					}
				} else{
					$sender->sendMessage($this->getConfig()->get('fly.other.not-found'));
					return false;
				}
			}
		}
		return true;
	}
}