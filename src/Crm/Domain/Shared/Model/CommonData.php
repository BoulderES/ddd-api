<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Model;

use DateTimeInterface;

class CommonData
{
    protected int $id;

    protected string $description;

    protected bool $isLocked;

    protected bool $isMain;

    protected bool $isActive;

    protected int $order;

    protected string $createdAt;

    protected string $updatedAt;

    protected string $children;

    public function preUpdateHandler()
    {
        $this->updatedAt = date(DateTimeInterface::ATOM);
    }

    public function __construct(IsMain $isMain = null, IsActive $isActive = null, IsLocked $isLocked= null, Order $order = null)
    {
        if(!$isMain)
            $isMain     = new IsMain(true);

        if(!$isActive)
            $isActive   = new IsActive(true);

        if(!$isLocked)
            $isLocked   = new IsLocked(false);

        if(!$order)
            $order      = new Order(1);

        $this->isMain       = $isMain->value();
        $this->isActive     = $isActive->value();
        $this->isLocked       = $isLocked->value();
        $this->order        = $order->value();
        $this->createdAt    = date(DateTimeInterface::ATOM);
//        $this->children     = new \Doctrine\Common\Collections\ArrayCollection();

    }
}