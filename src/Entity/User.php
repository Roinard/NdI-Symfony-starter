<?php

namespace App\Entity;


use Doctrine\Common\Comparable as Comparable;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="User")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, Serializable, Comparable
{
    public $oldPass;
    public $newPass;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    protected $surname;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     */
    protected $email;
    /**
     * @ORM\Column(type="string", length=14, nullable=true)
     */
    protected $phone;
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $address;
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $city;
    /**
     * @ORM\Column(name="zipCode", type="string", length=5, nullable=true)
     */
    protected $zipCode;
    /**
     * @ORM\Column(name="dateRegistered", type="datetime")
     */

    protected $dateRegistered;
    /**
     * @ORM\Column(name="dateUpdated", type="datetime")
     */
    protected $dateUpdated;


    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="user",cascade={"persist","remove"})
     */
    private $notifications;
    /**
     * @ORM\OneToMany(targetEntity="LogEvent", mappedBy="user",cascade={"persist","remove"})
     */
    private $logEvents;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password")
     */
    private $password_repeat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $wantDarkMode;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $wantLanguage;


    /**
     * @return mixed
     */
    public function getPasswordRepeat()
    {
        return $this->password_repeat;
    }

    /**
     * @param mixed $password_repeat
     */
    public function setPasswordRepeat($password_repeat): void
    {
        $this->password_repeat = $password_repeat;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }



    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getDateRegistered()
    {
        return $this->dateRegistered;
    }

    /**
     * @param mixed $dateRegistered
     */
    public function setDateRegistered($dateRegistered): void
    {
        $this->dateRegistered = $dateRegistered;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdated($dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param mixed $notifications
     */
    public function setNotifications($notifications): void
    {
        $this->notifications = $notifications;
    }

    /**
     * @return mixed
     */
    public function getLogEvents()
    {
        return $this->logEvents;
    }

    /**
     * @param mixed $logEvents
     */
    public function setLogEvents($logEvents): void
    {
        $this->logEvents = $logEvents;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }


    public function compareTo($other)
    {
        // TODO: Implement compareTo() method.
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return mixed
     */
    public function getWantDarkMode()
    {
        return $this->wantDarkMode;
    }

    /**
     * @param mixed $wantDarkMode
     */
    public function setWantDarkMode($wantDarkMode): void
    {
        $this->wantDarkMode = $wantDarkMode;
    }

    /**
     * @return mixed
     */
    public function getWantLanguage()
    {
        return $this->wantLanguage;
    }

    /**
     * @param mixed $wantLanguage
     */
    public function setWantLanguage($wantLanguage): void
    {
        $this->wantLanguage = $wantLanguage;
    }



}