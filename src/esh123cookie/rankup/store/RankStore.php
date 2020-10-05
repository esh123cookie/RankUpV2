<?php

namespace esh123cookie\rankup\store;

use rankup\RankUp;
use pocketmine\utils\config;
use pocketmine\event\Listener;

class RankStore {
	
    private $config;
	
    private $plugin;
	
    public $price;

    public $rank;

    public function __construct(RankUp $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }  
	
    public function getRankPrices(): array { 
      	    $prices = new Config($this->plugin->getDataFolder() . "/ranks.yml", Config::YAML);
            $rankPrices = $prices->getAll()["price"];
            return $rankPrices;
    }
	
    public function getRanks(): array { 
      	    $ranks = new Config($this->plugin->getDataFolder() . "/ranks.yml", Config::YAML);
            $rank = $ranks->getAll()["rank"];
            return $rank;
    }
}
