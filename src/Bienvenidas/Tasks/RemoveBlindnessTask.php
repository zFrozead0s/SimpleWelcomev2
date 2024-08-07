<?php

namespace Bienvenidas\Tasks;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;
use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\VanillaEffects;

class RemoveBlindnessTask extends Task {
    private $player;
    private $effect;

    public function __construct(Player $player, Effect $effect) {
        $this->player = $player;
        $this->effect = $effect;
    }

    public function onRun(int $currentTick): void {
        if ($this->player->getEffects()->has($this->effect)) {
            $this->player->getEffects()->remove($this->effect);
        }
    }
}