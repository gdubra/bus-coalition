<?php
namespace BusCoalition\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="BusCoalition\ApiBundle\Repository\FundSourceRepository")
 * @ORM\Table(name="fund_source")
 */
class FundSource{
    
    const FORMULA_FUND_SOURCE = 'formula';
    const DISCRETIONARY_FUND_SOURCE = 'discretionary';
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @ORM\Column(type="string", length=30, unique=true)
     */
    public $name;
    
    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('formula', 'discretionary')")
     */
    public $type;
    
    /**
     * @ORM\Column(type="integer")
     */
    public $startYear;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public $endYear;

    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    public $required;
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
     * Set name
     *
     * @param string $name
     * @return FundSource
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
     * Set type
     *
     * @param string $type
     * @return FundSource
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * Set startYear
     *
     * @param integer $startYear
     * @return FundSource
     */
    public function setStartYear($startYear)
    {
        $this->startYear = $startYear;

        return $this;
    }

    /**
     * Get startYear
     *
     * @return integer 
     */
    public function getStartYear()
    {
        return $this->startYear;
    }

    /**
     * Set endYear
     *
     * @param integer $endYear
     * @return FundSource
     */
    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;

        return $this;
    }

    /**
     * Get endYear
     *
     * @return integer 
     */
    public function getEndYear()
    {
        return $this->endYear;
    }
}
