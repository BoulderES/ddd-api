<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Model;

use DateTimeInterface;

class CommonData
{
    protected int $id;

    protected Description $description;

    protected Locked $locked;

    protected IsMain $isMain;

    protected IsActive $isActive;

    protected Order $order;

    protected CreatedAt $createdAt;

    protected UpdatedAt $updatedAt;

    protected $children;

    public function preUpdateHandler()
    {
        $this->updatedAt = date(DateTimeInterface::ATOM);
    }

    public function __construct(IsMain $isMain = null, IsActive $isActive = null, IsLocked $isLocked= null, Order $order = null)
    {
        if(!$isMain)
            $isMain     = IsMain::fromBool(true);

        if(!$isActive)
            $isActive   = IsActive::fromBool(true);

        if(!$isLocked)
            $isLocked   = IsLocked::fromBool(false);

        if(!$order)
            $order      = Order::fromInt(1);

        $this->isMain       = $isMain;
        $this->isActive     = $isActive;
        $this->isLocked       = $isLocked;
        $this->order        = $order;
        $this->createdAt    = date(DateTimeInterface::ATOM);
        $this->children     = new \Doctrine\Common\Collections\ArrayCollection();

    }
}