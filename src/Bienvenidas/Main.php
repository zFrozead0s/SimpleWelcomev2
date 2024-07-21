<?php

namespace Bienvenidas;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $username = $player->getName();

        $this->sendWelcomeMessage($player, $username);
        $this->applyBlindnessEffect($player);
    }

    private function sendWelcomeMessage(Player $player, string $username) {
        $message = $this->getConfig()->get("message");
        if ($message === null) {
            $message = "Welcome, {username}!"; // default message
        }

        $player->sendMessage(TextFormat::GREEN . str_replace("{username}", $username, $message));
    }

    private function applyBlindnessEffect(Player $player) {
        $effect = $player->getEffects()->add(new \pocketmine\entity\effect\BlindnessEffect(40));
        $this->getServer()->getScheduler()->scheduleDelayedTask(new \pocketmine\scheduler\CallbackTask(function() use ($player, $effect) {
            if ($player->getEffects()->has($effect)) {
                $player->getEffects()->remove($effect);
            }
        }), 40);
    }
}