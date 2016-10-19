<?php

namespace Jacoz\Symfony\ApiBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampFieldsTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function updatedTimestamps()
    {
        $now = new \DateTime();

        if (!$this->getCreatedAt()) {
            $this->setCreatedAt($now);
        }

        $this->setUpdatedAt($now);
    }
}
