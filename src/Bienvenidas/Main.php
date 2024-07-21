<?php

namespace Bienvenidas;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\entity\effect\Effect;
use pocketmine\scheduler\Task;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\effect\EffectInstance;

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

        $player->sendMessage(TextFormat::GREEN. str_replace("{username}", $username, $message));
    }

    private function applyBlindnessEffect(Player $player) {

$effect = new EffectInstance(VanillaEffects::BLINDNESS(), 40);
$player->getEffects()->add($effect);
        $player->getEffects()->add($effect);
        $this->getScheduler()->scheduleDelayedTask(new Task(function() use ($player, $effect) {
            if ($player->getEffects()->has($effect)) {
                $player->getEffects()->remove($effect);
            }
        }), 40);
    }
}
