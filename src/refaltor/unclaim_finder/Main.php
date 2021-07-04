<?php

namespace refaltor\unclaim_finder;

use pocketmine\plugin\PluginBase;
use refaltor\unclaim_finder\events\PlayerListener;
use refaltor\unclaim_finder\task\unclaimTask;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->saveResource('config.yml');
        $this->getScheduler()->scheduleRepeatingTask(new unclaimTask($this), $this->getConfig()->get('frame rate'));
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
    }
}