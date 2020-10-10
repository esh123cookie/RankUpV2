<?php

namespace esh123cookie\rankup\command;

use esh123cookie\rankup\RankUp;
use esh123cookie\rankup\store\RankStore; 
use esh123cookie\rankup\command\CommandStore; 
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;

class CommandRankUp extends PluginCommand{

    private $owner;

    public function __construct(string $name, RankUp $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) { 
           $data = new CommandStore($this->getPlugin());
           $data->rankUp($sender);
        }
    }
}
