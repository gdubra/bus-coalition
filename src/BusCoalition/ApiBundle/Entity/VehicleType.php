<?php
namespace BusCoalition\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="BusCoalition\ApiBundle\Repository\VehicleTypeRepository")
 * @ORM\Table(name="vehicle_type")
 */
class VehicleType{

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
     * @ORM\Column(type="float")
     */
    public $price;
}