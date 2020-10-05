<?php

namespace esh123cookie\rankup\store;

use rankup\RankUp;
use pocketmine\utils\config;
use pocketmine\event\Listener;

class RankStore {
	
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
	
    public function getRankCount(): int { 
	    return count($this->ranks);
    }
	
    public function getFirstRankInt(): int { 
	    return (int) array_key_first($this->ranks);
    }
	
    public function getFirstRankString(): string { 
	    return array_key_first($this->ranks);
    }
	
    public function getFirstPrice(): int { 
	    return (int) array_key_first($this->prices);
    }
	
    public function getLastRankInt(): int { 
	    return (int) array_key_last($this->ranks);
    }
	
    public function getLastRankString(): string { 
	    return array_key_last($this->ranks);
    }
	
    public function getLastPrice(): int { 
	    return (int) array_key_last($this->prices);
    }
	
    public function getRankPlace(): array { 
      	    $prices = new Config($this->plugin->getDataFolder() . "/ranks.yml", Config::YAML);
            $this->prices = $prices->getAll()["ranktype"];
            return $this->prices;
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
