<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Model;

use Cuadrik\Crm\Domain\Shared\Model\Locked;

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

    public function __construct(IsMain $isMain = null, IsActive $isActive = null, Locked $locked = null, Order $order = null)
    {
        if(!$isMain)
            $isMain = new IsMain(true);

        if(!$isActive)
            $isActive = new IsActive(true);

        if(!$locked)
            $locked = new Locked(false);

        if(!$order)
            $order = new Order(1);

        $this->isMain = $isMain;
        $this->isActive = $isActive;
        $this->locked = $locked;
        $this->order = $order;
        $this->createdAt = new CreatedAt(new \DateTime("now"));
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();

    }
}