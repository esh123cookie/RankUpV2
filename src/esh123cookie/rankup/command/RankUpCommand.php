<?php

namespace esh123cookie\rankup\command;

use esh123cookie\rankup\RankUp;
use esh123cookie\rankup\store\RankStore;
//tasks
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\utils\Utils;
use pocketmine\plugin\Plugin;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;

use onebone\economyapi\EconomyAPI;

use pocketmine\utils\Config;

class RankUpCommand implements Listener{

    private $plugin;
	
    private $store;

    public function __construct(RankUp $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getStore() { 
	$this->store = new RankStore($this->plugin);
	return $this->store;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
   
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
	   $config = new Config($this->plugin->playerFolder . strtolower($sender->getName()) . ".yml", Config::YAML);
      	   $rank = $this->getRank($sender, $config->get("rank"));
	   if($command->getName() == "rankup") {
	      if ($sender instanceof Player) {
		  $this->rankUp($sender);
              }
              return true;
	   }
	   if($command->getName() == "ru") {
	      if ($sender instanceof Player) {
		  $this->rankUp($sender);
              }
              return true;
	   }
    }
	
    public function rankUp(Player $player) {
	    $config = new Config($this->plugin->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
	    $first = array_key_first($this->getStore()->getRankCount());
	    $last = array_key_last($this->getStore()->getRankCount());
	    $rank = $this->plugin->getRank($player);
      	    $messages = new Config($this->plugin->getDataFolder() . "/messages.yml", Config::YAML);
	    if($rank >= $last) { 
	       $this->message($player, $messages->get("max-rank"));
	    }else{
	       $key = ($rank + 1);
       	       $nextRank = $this->getStore()->get_next_key_array($this->getStore()->getRanks(), [$key]);
	       $money = $this->getStore()->get_next_key_array($this->getStore()->getRankPrices(), [$key]);
	       if(EconomyAPI::getInstance()->myMoney($player) >= $money) { 
	          EconomyAPI::getInstance()->removeMoney($player, $money); 
	          $this->setRank($nextRank, $player);
	          $this->setRankInt($player, $key);
	          $this->setNextRankInt($player, $key);
	          $this->worldMessage($messages->get("rankup"));
	       }else{
		  $this->message($player, $messages->get("no-money"));
	       }
	    }
    }
	    
    public function message(Player $player, string $message) {
	    return $player->sendMessage($message);
    }	
	    
    public function worldMessage(string $message) {
	    return $this->plugin->getServer()->broadcastMessage($message);
    }
	    
    public function setRankInt(Player $player, int $key) { 
	$config = new Config($this->plugin->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
	return $config->set("rank", $key);
	$config->save();
    }
	
    public function setNextRankInt(Player $player, int $key) { 
	$config = new Config($this->plugin->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
	$math = ($key + 1);
	return $config->set("nextrank", $math);
	$config->save();
    }
	    
    public function setRank(Player $player, $rank) {
    	 return $this->getServer()->getPluginManager()->getPlugin("PureChat")->setPrefix($rank, $player);
    }
	
    public function getCurrentRank(Player $player): string {
	       $key = $this->plugin->getRank($player);
       	       return $this->getStore()->get_next_key_array($this->getStore()->getRanks(), [$key]);
    }
	
    public function getCurrentRankPrice(Player $player): string {
	       $key = $this->plugin->getRank($player);
       	       return $this->getStore()->get_next_key_array($this->getStore()->getRankPrices(), [$key]);
    }   
	
    public function getNextRank(Player $player) {
	       $key = ($this->plugin->getRank($player) + 1);
       	       $nextRank = $this->getStore()->get_next_key_array($this->getStore()->getRanks(), [$key]);
    }
	
    public function getNextRankPrice(Player $player) {
	       $key = ($this->plugin->getRank($player) + 1);
       	       $nextRank = $this->getStore()->get_next_key_array($this->getStore()->getRankPrices(), [$key]);
    }   
}
