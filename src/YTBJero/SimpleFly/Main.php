<?php

/*
 * SimpleFly plugin for PocketMine-MP
 * Copyright (C) 2022 Taylor-pm-pl <https://github.com/Taylor-pm-pl/SimpleFly>
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
        $this->getServer()
            ->getPluginManager()
            ->registerEvents(new EventListener($this), $this);
        $this->saveDefaultConfig();
    }

    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param String $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() !== "fly" || !$sender instanceof Player) {
            return true;
        }

        if (empty($args[0])) {
            $this->handleSelfFlyCommand($sender);
        } else {
            $this->handleOtherFlyCommand($sender, $args[0]);
        }

        return true;
    }

    private function handleSelfFlyCommand(Player $player): void {
        if ($player->isCreative(true)) {
            $player->sendMessage($this->getConfig()->get("fly.creative"));
            return;
        }

        if ($player->isFlying()) {
            if (!$this->setFly($player, false)) {
                $player->sendMessage($this->getConfig()->get("fly.not-allowed"));
                return;
            }
            $player->sendMessage($this->getConfig()->get("fly.off"));
        } else {
            if (!$this->setFly($player, true)) {
                $player->sendMessage($this->getConfig()->get("fly.not-allowed"));
                return;
            }
            $player->sendMessage($this->getConfig()->get("fly.on"));
        }
    }

    private function handleOtherFlyCommand(Player $sender, string $playerName): void {
        $targetPlayer = $this->getServer()->getPlayerExact($playerName);
        if ($targetPlayer === null) {
            $sender->sendMessage($this->getConfig()->get("fly.other.not-found"));
            return;
        }

        if ($targetPlayer->isCreative(true)) {
            $sender->sendMessage(str_replace("{PLAYER}", $targetPlayer->getName(), $this->getConfig()->get("fly.other.creative")));
            return;
        }

        if ($targetPlayer->isFlying()) {
            if (!$this->setFly($targetPlayer, false)) {
                $targetPlayer->sendMessage($this->getConfig()->get("fly.not-allowed"));
                return;
            }
            $sender->sendMessage(str_replace("{PLAYER}", $targetPlayer->getName(), $this->getConfig()->get("fly.other.off")));
        } else {
            if (!$this->setFly($targetPlayer, true)) {
                $targetPlayer->sendMessage($this->getConfig()->get("fly.not-allowed"));
                return;
            }
            $sender->sendMessage(str_replace("{PLAYER}", $targetPlayer->getName(), $this->getConfig()->get("fly.other.on")));
        }
    }

    public function setFly(Player $player, bool $value): bool {
        $worldName = $player->getWorld()->getDisplayName();
        $worlds = $this->getConfig()->get("worlds");
        $mode = strval($this->getConfig()->get("mode"));

        $isBlacklist = match ($mode) {
            "blacklist" => true,
            "whitelist" => false,
            default => true
        };

        if (($isBlacklist && !in_array($worldName, $worlds)) || (!$isBlacklist && in_array($worldName, $worlds))) {
            $player->setFlying($value);
            $player->setAllowFlight($value);
            return true;
        }

        return false;
    }
}
