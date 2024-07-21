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

        // Get the welcome message from the config.yml file
        $message = $this->getConfig()->get("message");
        if ($message === null) {
            $message = "Welcome, {username}!"; // default message
        }

        // Send the welcome message to the player
        $player->sendMessage(TextFormat::GREEN . str_replace("{username}", $username, $message));

        // Create a blindness effect for 2 seconds
        if ($player instanceof Player) {
            $effect = $player->getEffects()->add(new \pocketmine\entity\effect\BlindnessEffect(40));
            $this->getServer()->getScheduler()->scheduleDelayedTask(new \pocketmine\scheduler\CallbackTask(function() use ($player, $effect) {
                if ($player instanceof Player) {
                    $player->getEffects()->remove($effect);
                }
            }), 40);
        }
    }
}