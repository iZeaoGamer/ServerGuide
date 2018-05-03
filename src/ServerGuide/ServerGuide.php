<?php

namespace ServerGuide;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerDropItemEvent;

class ServerGuide extends PluginBase implements Listener{
	
	# Register/Schedule needs
	public function onEnable(){
		 $this->getLogger()->info("§bServerGuide has been enabled!".PHP_EOL.
		                                             "Author: TheAz928 (Az928)".PHP_EOL.
		                                             "Github: Github.com/ShiningMC/ServerGuide");
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
	    @mkdir($this->getDataFolder());
            $this->saveDefaultConfig();
	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new CheckTask($this), 20);
	}
	
	/* @function getHelpItem
	 * @return Item
	 */
	
	public function getHelpItem(): Item{
	    $steam = $this->getConfig()->get("item");
       $i = explode(":", $steam);
       $item = Item::get($i[0], $i[1], 1);
       $item->setCustomName(str_replace("\n", PHP_EOL, $i[2]));
   return $item;
	}
	
	/*
	 * @function getTranslatedLines
	 * @return array
	 */
	
	public function getTranslatedLines(Player $player): array{
	    $x = $player->x;
		 $y = $player->y;
	    $z = $player->z;
		 $level = $player->getLevel()->getName();
		 $name = $player->getName();
		 $status = count($this->getServer()->getOnlinePlayers())."/".$this->getServer()->getMaxPlayers();
		 $return = [];
		 foreach($this->getConfig()->get("help.list", []) as $line){
	      $return[] = str_replace(["{x}", "{y}", "{z}", "{level}", "{player}", "{online count}"], [$x, $y, $z, $level, $name, $status], $line);
	   }
	return $return;
	}
	
	/*
	 * @handle PlayerInteractEvent
	 */
	
	public function onInteract(PlayerInteractEvent $event){
	    $player = $event->getPlayer();
	    $item = $event->getItem();
	    $key = $this->getHelpItem();
	    if($item->getId() == $key->getId() && $item->getDamage() == $key->getDamage()){
		   $player->sendMessage($this->getConfig()->get("header")."§r");
		   foreach($this->getTranslatedLines($player) as $line){
		     $player->sendMessage($line."§r");
		   }
		}
	}
	
	/*
	 * @handle PlayerDropItemEvent
	 */
	
	public function onDrop(PlayerDropItemEvent $event){
	    $player = $event->getPlayer();
	    $item = $event->getItem();
	    $key = $this->getHelpItem();
	    if($item->getId() == $key->getId() && $item->getDamage() == $key->getDamage()){
		   $player->sendMessage("§cYou can't do that!");
		   $event->setCancelled(true);
		}
	}
}
