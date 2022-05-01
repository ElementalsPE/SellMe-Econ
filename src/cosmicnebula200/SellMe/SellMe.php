<?php

namespace cosmicnebula200\SellMe;

use CortexPE\Commando\PacketHooker;
use cosmicnebula200\SellMe\commands\AutoSellCommand;
use cosmicnebula200\SellMe\commands\SellCommand;
use cosmicnebula200\SellMe\listeners\EventListener;
use cosmicnebula200\SellMe\messages\Messages;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class SellMe extends PluginBase
{

    /** @var Config */
    public static Config $prices, $forms, $messageConfig;
    /** @var self */
    private static self $instance;
    /** @var array */
    public static array $autosell;
    /** @var Messages */
    public static Messages $messages;

    public function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable(): void
    {
        $this->saveResource('prices.yml');
        $this->saveResource('forms.yml');
        $this->saveResource('messages.yml');

        self::$prices = new Config($this->getDataFolder() . 'prices.yml', Config::YAML);
        self::$forms = new Config($this->getDataFolder() . 'forms.yml', Config::YAML);
        self::$messageConfig = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
        self::$messages = new Messages();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        $this->getServer()->getCommandMap()->register('SellMe', new SellCommand($this, 'sell', 'Sell command'));
        $this->getServer()->getCommandMap()->register('AutoSell', new AutoSellCommand($this, 'autosell', 'Toggle AutoSell', ['as']));

        if (!PacketHooker::isRegistered())
            PacketHooker::register($this);
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

}