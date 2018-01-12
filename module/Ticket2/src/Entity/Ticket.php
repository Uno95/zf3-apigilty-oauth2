<?php

namespace Ticket2\Entity;

/**
 * Ticket
 */
class Ticket
{
    /**
     * @var string
     */
    private $userProfileUuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $deletedAt;

    /**
     * @var string
     */
    private $uuid;


    /**
     * Set userProfileUuid
     *
     * @param string $userProfileUuid
     *
     * @return Ticket
     */
    public function setUserProfileUuid($userProfileUuid)
    {
        $this->userProfileUuid = $userProfileUuid;

        return $this;
    }

    /**
     * Get userProfileUuid
     *
     * @return string
     */
    public function getUserProfileUuid()
    {
        return $this->userProfileUuid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Ticket
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Ticket
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Ticket
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Ticket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ticket
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Ticket
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param string $deletedAt
     *
     * @return Ticket
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
