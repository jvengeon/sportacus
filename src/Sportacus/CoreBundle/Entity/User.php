<?php

namespace Sportacus\CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="google_id", type="string", nullable=true)
	 */
	private $googleId;
	
	
	/** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
	protected $googleAccessToken;
	
	/**
	 * @ORM\OneToMany(targetEntity="Measure", mappedBy="user")
	 */
	protected $mesures;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->mesures = new ArrayCollection();
		// your own logic
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
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string 
     */
    public function getGoogleAccessToken()
    {
        return $this->googleAccessToken;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Add mesures
     *
     * @param \Sportacus\CoreBundle\Entity\Measure $mesures
     * @return User
     */
    public function addMesure(\Sportacus\CoreBundle\Entity\Measure $mesures)
    {
        $this->mesures[] = $mesures;

        return $this;
    }

    /**
     * Remove mesures
     *
     * @param \Sportacus\CoreBundle\Entity\Measure $mesures
     */
    public function removeMesure(\Sportacus\CoreBundle\Entity\Measure $mesures)
    {
        $this->mesures->removeElement($mesures);
    }

    /**
     * Get mesures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesures()
    {
        return $this->mesures;
    }
}
