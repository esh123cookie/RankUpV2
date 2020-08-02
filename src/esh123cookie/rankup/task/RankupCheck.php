<?php

namespace esh123cookie\rankup\task;  

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
      
use esh123cookie\rankup\RankUp;   
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\plugin\Plugin;
use pocketmine\level\ProviderManager;
use pocketmine\Player;

class RankupCheck extends PluginTask {

      private rank;
      private nextrank;
      
      private $plugin;
	
      public function __construct(Plugin $plugin){
	      $this->plugin = $plugin;
      }
   
      public function getPlugin(){
	      return $this->plugin;
      }
      
    public function onRun($tick){
    
	    foreach ($this->plugin->getServer()->getOnlinePlayers() as $player){
    
	  	$config = new Config($this->plugin->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
      $this->plugin->nextrank = $this->plugin->getNextRank($player, $config->get("nextrank"));
	    $rank = new Config($this->plugin->getDataFolder() . "data." . $player->getLowerCaseName() . ".yml", Config::YAML);
      $this->plugin->rank = $this->plugin->getNextRank($player, $config->get("nextrank"));
	    if($this->plugin->rank == "A") { 
	       $rank->set("nextrank", "B");
	       $rank->save();
	    }elseif($this->plugin->rank == "B") { 
	       $rank->set("nextrank", "C");
	       $rank->save();
	    }elseif($this->plugin->rank == "C") { 
	       $rank->set("nextrank", "D");
	       $rank->save();
	    }elseif($this->plugin->rank == "D") { 
	       $rank->set("nextrank", "E");
	       $rank->save();
	    }elseif($this->plugin->rank == "E") { 
	       $rank->set("nextrank", "F");
	       $rank->save();
	    }elseif($this->plugin->rank == "F") { 
	       $rank->set("nextrank", "G");
	       $rank->save();
	    }elseif($this->plugin->rank == "G") { 
	       $rank->set("nextrank", "H");
	       $rank->save();
	    }elseif($this->plugin->rank == "H") { 
	       $rank->set("nextrank", "I");
	       $rank->save();
	    }elseif($this->plugin->rank == "I") { 
	       $rank->set("nextrank", "J");
	       $rank->save();
	    }elseif($this->plugin->rank == "J") { 
	       $rank->set("nextrank", "K");
	       $rank->save();
	    }elseif($this->plugin->rank == "K") { 
	       $rank->set("nextrank", "L");
	       $rank->save();
	    }elseif($this->plugin->rank == "L") { 
	       $rank->set("nextrank", "M");
	       $rank->save();
	    }elseif($this->plugin->rank == "M") { 
	       $rank->set("nextrank", "N");
	       $rank->save();
	    }elseif($this->plugin->rank == "N") { 
	       $rank->set("nextrank", "O");
	       $rank->save();
	    }elseif($this->plugin->rank == "O") { 
	       $rank->set("nextrank", "P");
	       $rank->save();
	    }elseif($this->plugin->rank == "P") { 
	       $rank->set("nextrank", "Q");
	       $rank->save();
	    }elseif($this->plugin->rank == "Q") { 
	       $rank->set("nextrank", "R");
	       $rank->save();
	    }elseif($this->plugin->rank == "R") { 
	       $rank->set("nextrank", "S");
	       $rank->save();
	    }elseif($this->plugin->rank == "S") { 
	       $rank->set("nextrank", "T");
	       $rank->save();
	    }elseif($this->plugin->rank == "T") { 
	       $rank->set("nextrank", "U");
	       $rank->save();
	    }elseif($this->plugin->rank == "U") { 
	       $rank->set("nextrank", "V");
	       $rank->save();
	    }elseif($this->plugin->rank == "V") { 
	       $rank->set("nextrank", "W");
	       $rank->save();
	    }elseif($this->plugin->rank == "Y") { 
	       $rank->set("nextrank", "X");
	       $rank->save();
	    }elseif($this->plugin->rank == "Z") { 
	       $rank->set("nextrank", "Y");
	       $rank->save();
         }
	    }
}
