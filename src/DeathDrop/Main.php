<?php

namespace DeathDrop;

use pocketmine\Player;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\network\protocol\TextPacket;
use pocketmine\network\protocol\AddPlayerPacket;
use pocketmine\entity\Entity;

class Main extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }
    
    public function onDeath(PlayerDeathEvent $event){
      $this->strikeLightning($event->getEntity());
      $event->setDrops([Item::get(322, 1, 1)]);
    }
    
    public function strikeLightning(Player $p){
		$light = new AddEntityPacket();
		$light->type = 93;
		$light->eid = Entity::$entityCount++;
		$light->metadata = array();
		$light->speedX = 0;
		$light->speedY = 0;
		$light->speedZ = 0;
		$light->x = $p->x;
		$light->y = $p->y;
		$light->z = $p->z;
		foreach($p->getLevel()->getPlayers() as $levelplayers){
		    $levelplayers->dataPacket($light);
		}
	}
}


