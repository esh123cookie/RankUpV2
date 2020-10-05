<?php

namespace rankup\store;

use rankup\RankUp;
use pocketmine\utils\config;
use pocketmine\event\Listener;

class RankStore {
	
    private $config;
	
    private $plugin;

    public function __construct(RankUp $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
