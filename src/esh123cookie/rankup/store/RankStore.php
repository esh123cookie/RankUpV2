<?php

namespace esh123cookie\rankup\store;

use esh123cookie\rankup\RankUp;
use pocketmine\utils\config;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;

class RankStore implements Listener{
	
    private $config;
	
    private $plugin;
	
    public $prices;

    public $ranks;

    public function __construct(RankUp $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function get_next_key_array($array, $key){ //rank will be displayed as int and turned to string
    	$keys = array_keys($array);
    	$position = array_search($key, $keys);
    	if (isset($keys[$position + 1])) {
            $nextKey = $keys[$position + 1];
	}
    return $nextKey; //$this->get_next_key_array((array ($arr), (int) ($num) - 1));
    }
	
    public function getRankCount(): int { 
	    return count($this->ranks);
    }
	
    public function getFirstRankInt(): int { 
	    return (int) array_key_first($this->ranks);
    }
	
    public function getFirstPrice(): int { 
	    return (int) array_key_first($this->prices);
    }
	
    public function getLastRankInt(): int { 
	    return (int) array_key_last($this->ranks);
    }
	
    public function getLastPrice(): int { 
	    return (int) array_key_last($this->prices);
    }
	
    public function getRankPrices(): array { 
      	    $prices = new Config($this->plugin->getDataFolder() . "/ranks.yml", Config::YAML);
            $this->prices = $prices->getAll()["price"];
            return $this->prices;
    }
	
    public function getRanks(): array { 
      	    $ranks = new Config($this->plugin->getDataFolder() . "/ranks.yml", Config::YAML);
            $this->ranks = $ranks->getAll()["rank"];
            return $this->ranks;
    }
}
