<?php
namespace BusCoalition\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="BusCoalition\ApiBundle\CompanyRepository")
 * @ORM\Table(name="company")
 */
class Company{
    
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
}