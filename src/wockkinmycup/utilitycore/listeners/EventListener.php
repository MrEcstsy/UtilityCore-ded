<?php

namespace wockkinmycup\utilitycore\listeners;

use pocketmine\block\inventory\EnchantInventory;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use wockkinmycup\utilitycore\Loader;

class EventListener implements Listener
{

    public function autoLapis(InventoryOpenEvent $e): void
    {
        $inv = $e->getInventory();
        if ($inv instanceof EnchantInventory) {
            $inv->setItem(1, VanillaItems::LAPIS_LAZULI()->setCount(32));
        }
    }

    public function onTransaction(InventoryTransactionEvent $event): void
    {
        $transaction = $event->getTransaction();
        $sourceInv = $transaction->getSource()->getCurrentWindow();

        if ($sourceInv instanceof EnchantInventory) {
            $actions = $transaction->getActions();

            foreach ($actions as $action) {
                $targetItem = $action->getTargetItem();

                if ($targetItem->getTypeId() === ItemTypeIds::LAPIS_LAZULI) {
                    $event->cancel();
                }
            }
        }
    }
}