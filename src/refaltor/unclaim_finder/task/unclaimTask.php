<?php

namespace refaltor\unclaim_finder\task;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\tile\Chest;
use pocketmine\tile\Tile;
use refaltor\unclaim_finder\events\PlayerListener;
use refaltor\unclaim_finder\Main;

class unclaimTask extends Task
{
    public Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }


    public function onRun(int $currentTick)
    {
        if (!empty(PlayerListener::$cache)){
            foreach (PlayerListener::$cache as $player => $bool){
                $player = Server::getInstance()->getPlayerExact($player);
                if ($player instanceof Player){
                    if ($bool){
                        $i = 0;
                        foreach ($player->getLevel()->getChunkTiles($player->getX() >> 4, $player->getZ() >> 4) as $tile) $i++;
                        switch ($this->plugin->getConfig()->get('type')){
                            case 'popup':
                                $player->sendPopup(str_replace("{%}", $i, $this->plugin->getConfig()->get('message_popup') ?? "§6- §eIl y a §a{%}% §6-"));
                                break;
                            case 'message':
                                $player->sendMessage(str_replace("{%}", $i, $this->plugin->getConfig()->get('message_popup') ?? "§6- §eIl y a §a{%}% §6-"));
                                break;
                            case 'tip':
                                $player->sendTip(str_replace("{%}", $i, $this->plugin->getConfig()->get('message_popup') ?? "§6- §eIl y a §a{%}% §6-"));
                                break;
                        }
                    }
                }
            }
        }
    }
}