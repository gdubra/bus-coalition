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
}