<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * LogEvent
 *
 * @ORM\Table(name="LogEvent")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class LogEvent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="logEvents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=255)
     */
    private $target;

    /**
     * @var string
     *
     * @ORM\Column(name="entity", type="string", length=255)
     */
    private $entity;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=255, nullable=true)
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="oldval", type="text", nullable=true)
     */
    private $oldval;

    /**
     * @var string
     *
     * @ORM\Column(name="newval", type="text", nullable=true)
     */
    private $newval;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="eventDate", type="datetime")
     */
    private $eventDate;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->eventDate = new DateTime();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return LogEvent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set target
     *
     * @param string $target
     * @return LogEvent
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set entity
     *
     * @param string $entity
     * @return LogEvent
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get field
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set field
     *
     * @param string $field
     * @return LogEvent
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get oldval
     *
     * @return string
     */
    public function getOldval()
    {
        return $this->oldval;
    }

    /**
     * Set oldval
     *
     * @param string $oldval
     * @return LogEvent
     */
    public function setOldval($oldval)
    {
        $this->oldval = $oldval;

        return $this;
    }

    /**
     * Get newval
     *
     * @return string
     */
    public function getNewval()
    {
        return $this->newval;
    }

    /**
     * Set newval
     *
     * @param string $newval
     * @return LogEvent
     */
    public function setNewval($newval)
    {
        $this->newval = $newval;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set eventDate
     *
     * @param DateTime $eventDate
     * @return LogEvent
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }
}
