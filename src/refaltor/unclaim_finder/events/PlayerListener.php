<?php

namespace refaltor\unclaim_finder\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use refaltor\unclaim_finder\Main;

class PlayerListener implements Listener
{
    public static array $cache = [];
    public Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onChangeItem(PlayerItemHeldEvent $event){
        if ($event->getItem()->getId() . ":" . $event->getItem()->getDamage() === $this->plugin->getConfig()->get('unclaim_finder')){
            self::$cache[$event->getPlayer()->getName()] = true;
        }else   self::$cache[$event->getPlayer()->getName()] = false;
    }

    public function onJoin(PlayerJoinEvent $event){
        self::$cache[$event->getPlayer()->getName()] = false;
    }
}