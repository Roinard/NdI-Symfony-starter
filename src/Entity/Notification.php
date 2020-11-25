<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 * @ORM\Table(name="Notification")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=2048, nullable=true)
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pinned", type="boolean")
     */
    private $pinned;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateSent", type="datetime", nullable=true)
     */
    private $dateSent;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateSeen", type="datetime", nullable=true)
     */
    private $dateSeen;

    /**
     * @var string
     *
     * @ORM\Column(name="linkPath", type="string", length=255, nullable=true)
     */
    private $linkPath;

    /**
     * @var string
     *
     * @ORM\Column(name="linkArg1Name", type="string", length=255, nullable=true)
     */
    private $linkArg1Name;

    /**
     * @var string
     *
     * @ORM\Column(name="linkArg1Val", type="string", length=255, nullable=true)
     */
    private $linkArg1Val;

    /**
     * @var string
     *
     * @ORM\Column(name="linkArg2Name", type="string", length=255, nullable=true)
     */
    private $linkArg2Name;

    /**
     * @var string
     *
     * @ORM\Column(name="linkArg2Val", type="string", length=255, nullable=true)
     */
    private $linkArg2Val;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;


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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get pinned
     *
     * @return boolean
     */
    public function getPinned()
    {
        return $this->pinned;
    }

    /**
     * Set pinned
     *
     * @param boolean $pinned
     * @return Notification
     */
    public function setPinned($pinned)
    {
        $this->pinned = $pinned;

        return $this;
    }

    /**
     * Get dateSent
     *
     * @return DateTime
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * Set dateSent
     *
     * @param DateTime $dateSent
     * @return Notification
     */
    public function setDateSent($dateSent)
    {
        $this->dateSent = $dateSent;

        return $this;
    }

    /**
     * Get dateSeen
     *
     * @return DateTime
     */
    public function getDateSeen()
    {
        return $this->dateSeen;
    }

    /**
     * Set dateSeen
     *
     * @param DateTime $dateSeen
     * @return Notification
     */
    public function setDateSeen($dateSeen)
    {
        $this->dateSeen = $dateSeen;

        return $this;
    }

    /**
     * Get linkPath
     *
     * @return string
     */
    public function getLinkPath()
    {
        return $this->linkPath;
    }

    /**
     * Set linkPath
     *
     * @param string $linkPath
     * @return Notification
     */
    public function setLinkPath($linkPath)
    {
        $this->linkPath = $linkPath;

        return $this;
    }

    /**
     * Get linkArg1Name
     *
     * @return string
     */
    public function getLinkArg1Name()
    {
        return $this->linkArg1Name;
    }

    /**
     * Set linkArg1Name
     *
     * @param string $linkArg1Name
     * @return Notification
     */
    public function setLinkArg1Name($linkArg1Name)
    {
        $this->linkArg1Name = $linkArg1Name;

        return $this;
    }

    /**
     * Get linkArg1Val
     *
     * @return string
     */
    public function getLinkArg1Val()
    {
        return $this->linkArg1Val;
    }

    /**
     * Set linkArg1Val
     *
     * @param string $linkArg1Val
     * @return Notification
     */
    public function setLinkArg1Val($linkArg1Val)
    {
        $this->linkArg1Val = $linkArg1Val;

        return $this;
    }

    /**
     * Get linkArg2Name
     *
     * @return string
     */
    public function getLinkArg2Name()
    {
        return $this->linkArg2Name;
    }

    /**
     * Set linkArg2Name
     *
     * @param string $linkArg2Name
     * @return Notification
     */
    public function setLinkArg2Name($linkArg2Name)
    {
        $this->linkArg2Name = $linkArg2Name;

        return $this;
    }

    /**
     * Get linkArg2Val
     *
     * @return string
     */
    public function getLinkArg2Val()
    {
        return $this->linkArg2Val;
    }

    /**
     * Set linkArg2Val
     *
     * @param string $linkArg2Val
     * @return Notification
     */
    public function setLinkArg2Val($linkArg2Val)
    {
        $this->linkArg2Val = $linkArg2Val;

        return $this;
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

    /**
     * Set user
     *
     * @param User $user
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function defaultValues()
    {
        $this->seen = false;
        $this->pinned = false;
        $this->dateSent = new DateTime();
    }
}
