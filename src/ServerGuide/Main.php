<?php
namespace ServerGuide;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\inventory\Inventory;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerItemHeldEvent;

/*
 * Developed by TheAz928(Az928)
 * Editing or copying isn't allowed
 * Leet.cc or play.mc cannot use this plugin
 * Twitter @TheAz928
 * Github team: Github.com/ShiningMC
 *
  */

class Main extends PluginBase implements Listener{
	
	public $prefix;
	
	public function onEnable(){
		  $this->saveDefaultConfig();
		  $this->cfg = $this->getConfig()->getAll();
		  $this->prefix = $this->cfg["prefix"];
		  $this->getServer()->getPluginManager()->registerEvents($this, $this);
		  $this->getLogger()->info("§aServerGuide has been enabled!");
<?php
namespace ServerGuide;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\inventory\Inventory;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerItemHeldEvent;

/*
 * Developed by TheAz928(Az928)
 * Editing or copying isn't allowed
 * Leet.cc or play.mc cannot use this plugin
 * Twitter @TheAz928
 * Github team: Github.com/ShiningMC
 *
  */

class Main extends PluginBase implements Listener{
	
	public $prefix;
	
	public function onEnable(){
		  $this->saveDefaultConfig();
		  $this->cfg = $this->getConfig()->getAll();
		  $this->prefix = $this->cfg["prefix"];
		  $this->getServer()->getPluginManager()->registerEvents($this, $this);
		  $this->getLogger()->info("§aServerGuide has been enabled!");
		}
		
	/* @param getGuideItem */
	
	 public function getGuideItem(){
	      $data = $this->cfg["guide.item"];
	      $tmp = explode(":", $data);
	      $item = Item::get($tmp[0], $tmp[1], 1);
	      $item->setCustomName($this->cfg["guide.item.name"]);
	   return $item;
		}
		
	 /* @param removeGuideItem */
	
	 public function removeGuideItem(Player $player){
	       if($player->getInventory()->contains($this->getGuideItem())){
		      $data = $this->cfg["guide.item"];
	         $tmp = explode(":", $data);
		     $player->getInventory()->removeItem(Item::get($tmp[0], $tmp[1], 1));
		    }
		}
		
	 /* @param sendGuide */
	
    public function sendGuide(Player $player){
	      $player->sendMessage($this->cfg["prefix"]);
	    if(isset($this->cfg["guide.list"])){
          foreach($this->cfg["guide.list"] as $help){
	           $player->sendMessage("§r§6".$help."§r");
	      }
	   }
	}
	
	 /* @param analize player */
	
	 public function analyze(Player $player){
	      $inv = $player->getInventory();
	      $data = $this->cfg["guide.item"];
	      $tmp = explode(":", $data);
	      if($player instanceof Player){
		    if($inv->contains(Item::get($tmp[0], $tmp[1], 1))){
		       $inv->removeItem(Item::get($tmp[0], $tmp[1], 64));
		       $inv->addItem($this->getGuideItem());
		     }else{
		      $inv->addItem($this->getGuideItem());
			 }
	     }
	  }
	 public function analyzeRespawn(PlayerRespawnEvent $event){
	      $player = $event->getPlayer();
	      $this->analyze($player);
		}
	  public function analyzeJoin(PlayerJoinEvent $event){
	      $player = $event->getPlayer();
	      $this->analyze($player);
	      //$player->getInventory()->setItemInHand($player->getInventory()->getItem($this->getGuideItem()));
		}
	 public function getGuide(PlayerItemHeldEvent $event){
	      $player = $event->getPlayer();
	      $eitem = $event->getItem();
	      $data = $this->cfg["guide.item"];
	      $tmp = explode(":", $data);
	      if($eitem->getId() == $tmp[0] && $eitem->getDamage() == $tmp[1] && $eitem->getCustomName() == $this->cfg["guide.item.name"]){
		     $this->sendGuide($player);
             }
		}
}
