<?php

namespace cosmicnebula200\SellMe\commands;

use CortexPE\Commando\BaseCommand;
use cosmicnebula200\ElementalsSkyBlock\permissions\Permissions;
use cosmicnebula200\SellMe\SellMe;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AutoSellCommand extends BaseCommand
{

    protected function prepare(): void
    {
        $this->setPermission(Permissions::EARTH);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $form = new SimpleForm(function (Player $player, ?int $data): void {
            if ($data === null)
                return;
            SellMe::$autosell[$player->getName()] = !$data;
        });
        $form->setTitle(TextFormat::colorize(SellMe::$forms->getNested('autosell-form.title', '&l&dAutoSell Form')));
        $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('autosell-form.on', '&l&dOn')));
        $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('autosell-form.off', '&l&dOff')));
        $form->sendToPlayer($sender);
    }

}