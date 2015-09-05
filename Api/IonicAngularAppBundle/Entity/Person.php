<?php

namespace Api\IonicAngularAppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"empl" = "Employee", "admin" = "Admin"})
 * @ORM\HasLifeCycleCallBacks()
 */
class Person
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
     * @ORM\Column(name="firstName", type="string", length=25)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="secondName", type="string", length=25)
     */
    private $secondName;

    /**
     * @var string
     *
     * @ORM\Column(name="age", type="decimal")
     */
    private $age;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="membershipDate", type="date")
     */
    private $membershipDate;






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
     * Set firstName
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     * @return Person
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string 
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set age
     *
     * @param string $age
     * @return Person
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return string 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set membershipDate
     *
     * @param \DateTime $membershipDate
     * @return Person
     */
    public function setMembershipDate($membershipDate)
    {
        $this->membershipDate = $membershipDate;

        return $this;
    }

    /**
     * Get membershipDate
     *
     * @return \DateTime 
     */
    public function getMembershipDate()
    {
        return $this->membershipDate;
    }


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setMembershipDate(new \DateTime());
    }

    public function __toString()
    {
        return " first_name : .$this->getFirstName(). ";
    }


}
