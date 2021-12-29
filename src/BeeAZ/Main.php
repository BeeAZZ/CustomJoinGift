<?php

namespace BeeAZ;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\enchantment\{Enchantment, EnchantmentInstance};
use onebone\coinapi\CoinAPI;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{
	
	public function onEnable():void{
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
@mkdir($this->getDataFolder(), 0744, true);

      $this->saveResource("config.yml");
      $this->cfg = new Config($this->getDataFolder()."config.yml");
      $this->gift = new Config($this->getDataFolder()."gift.yml",Config::YAML);
}

  public function onJoin(PlayerJoinEvent $ev) {
	
  if(!$this->gift->exists($ev->getPlayer()->getName()));
			$player = $ev->getPlayer();
			$id = $this->cfg->get("ID");
			$meta = $this->cfg->get("META");
			$amount = $this->cfg->get("AMOUNT");
			$coin = $this->cfg->get("COIN");
			$eco = $this->cfg->get("MONEY");
      $setname = $this->cfg->get("NAME");
      $setlore = $this->cfg->get("LORE");
      $idenchant = $this->cfg->get("IDENCHANT");
      $levelenchant = $this->cfg->get("LEVEL");
      $message = $this->cfg->get("MESSAGE");
   $item = Item::get($id, $meta, $amount);
    $item->setCustomName("{$setname}");
    $item->setLore(array("{$setlore}"));
    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($idenchant), $levelenchant));
	 $player->getInventory()->addItem($item);
	 EconomyAPI::getInstance()->addMoney($player, $eco);
	 CoinAPI::getInstance()->addCoin($player, $coin);
	 $player->sendMessage("{$message}");
			
$this->gift->set($ev->getPlayer()->getName());
$this->gift->save();
       }
    }