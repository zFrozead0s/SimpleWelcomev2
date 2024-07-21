<?php

namespace Bienvenidas;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\entity\effect\Effect;
use pocketmine\scheduler\Task;
use Bienvenidas\Tasks\RemoveBlindnessTask;

class Main extends PluginBase {
    public function onEnable(): void {
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
        $effect = new Effect(15, 40); // assuming 15 is the correct effect ID for blindness
        $player->getEffects()->add($effect);
        $this->getServer()->getScheduler()->scheduleDelayedTask(new RemoveBlindnessTask($player, $effect), 40);
    }
}