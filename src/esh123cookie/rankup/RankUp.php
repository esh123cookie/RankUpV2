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
  
      private $config;
  
      public function onEnable(){
        $this->getLogger()->info("§cRankup plugin made by esh123cookie");
        if(getConfig->get("change") !== null) {
           $this->getLogger()->info("§cRankup is unable to change suffix or prefix. Issue is in config.");
        }
      }
  
      public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
      {
           if($cmd->getName() == "rankup") {
           if($sender->hasPermission($this->getConfig()->get("permission1"))) {
              $this->Rankup($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission2"))) {
              $this->Rankup2($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission3"))) {
              $this->Rankup3($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission4"))) {
              $this->Rankup4($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission5"))) {
              $this->Rankup5($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission6"))) {
              $this->Rankup6($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission7"))) {
              $this->Rankup7($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission8"))) {
              $this->Rankup8($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission9"))) {
              $this->Rankup9($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission10"))) {
              $this->Rankup10($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission11"))) {
              $this->Rankup11($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission12"))) {
              $this->Rankup12($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission13"))) {
              $this->Rankup13($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission14"))) {
              $this->Rankup14($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission15"))) {
              $this->Rankup15($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission16"))) {
              $this->Rankup16($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission17"))) {
              $this->Rankup17($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission18"))) {
              $this->Rankup18($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission19"))) {
              $this->Rankup19($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission20"))) {
              $this->Rankup20($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission21"))) {
              $this->Rankup21($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission22"))) {
              $this->Rankup22($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission23"))) {
              $this->Rankup23($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission24"))) {
              $this->Rankup24($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission25"))) {
              $this->Rankup25($sender);
           }elseif($sender->hasPermission($this->getConfig()->get("permission26"))) {
              $this->Rankup26($sender);
              }
              return true;
           }
      }
  
      public function Rankup($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price1");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank1"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank1"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg1"));
              }
      }
  
      public function Rankup2($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price2");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank2"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank2"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd2");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd2);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg2"));
              }
      }
  
      public function Rankup3($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price3");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank3"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank3"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd3");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd3);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg3"));
              }
      }
  
      public function Rankup4($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price4");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank4"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank4"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd4");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd4);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg4"));
              }
      }
  
      public function Rankup5($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price5");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank5"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank5"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd5");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd5);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg5"));
              }
      }

      public function Ranku6($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price6");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank6"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank6"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd6");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd6);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg6"));
              }
      }
  
      public function Rankup7($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price7");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank7"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank7"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd7");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd7);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg7"));
              }
      }

      public function Rankup8($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price8");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank8"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank8"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd8");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd8);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg8"));
              }
      }
  
      public function Rankup9($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price9");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank9"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank9"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd9");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd9);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg9"));
              }
      }

      public function Rankup10($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price10");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank10"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank10"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd10");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd10);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg10"));
              }
      }

      public function Rankup11($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price11");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank12"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank12"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd11");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd11);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg12"));
              }
      }
  
      public function Rankup12($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price12");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank12"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank12"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd12");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd12);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg12"));
              }
      }
  
      public function Rankup13($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price13");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank13"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank13"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd13");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd13);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg13"));
              }
      }
  
      public function Rankup14($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price14");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank14"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank14"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd14");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd14);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg14"));
              }
      }
  
      public function Rankup15($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price15");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank15"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank15"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd15");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd15);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg15"));
              }
      }
  
      public function Rankup16($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price16");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank16"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank16"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd16");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd16);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg16"));
              }
      }

      public function Rankup17($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price17");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank17"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank17"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd17");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd17);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg17"));
              }
      }
  
      public function Rankup18($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price18");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank18"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank18"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd18");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd18);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg18"));
              }
      }

      public function Rankup19($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price19");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank19"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank19"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd19");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd19);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg19"));
              }
      }
  
      public function Rankup20($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price20");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank20"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank20"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd20");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd20);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg20"));
              }
      }
  
      public function Rankup21($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price21");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank21"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank21"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd21");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd21);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg21"));
              }
      }
  
      public function Rankup22($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price22");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank22"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank22"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd22");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd22);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg22"));
              }
      }
  
      public function Rankup23($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price23");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank23"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank23"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd23");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd23);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg23"));
              }
      }
  
      public function Rankup24($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price24");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank24"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank24"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd24");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd24);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg24"));
              }
      }
  
      public function Rankup25($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price25");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank25"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank25"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd25");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd25);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg25"));
              }
      }
  
      public function Rankup26($sender) {
		       $this->pureChat = $pureChat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
              $amount = $this->getConfig()->get("price26");
             	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender) >= ($amount)){
                 $change = $this->getConfig()->get("change");
                 if($change == ("suffix")){
                 $suffix = $pureChat->getSuffix($this->getConfig()->get("rank26"));
	               $pureChat->setSuffix($sender, $suffix);
                 }elseif($change == ("prefix")){
                 $prefix = $pureChat->getPrefix($this->getConfig()->get("rank26"));
	               $pureChat->setPrefix($sender, $prefix);
                 $cmd = $this->getConfig()->get("cmd26");
		             $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $cmd26);
                 }
              }else{ 
                 $sender->sendMessage($this->getConfig()->get("msg26"));
              }
      }
}
