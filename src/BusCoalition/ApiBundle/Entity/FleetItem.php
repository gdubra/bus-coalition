<?php
namespace BusCoalition\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="BusCoalition\ApiBundle\VehicleRepository")
 * @ORM\Table(name="fleet_item")
 */
class FleetItem{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="VehicleType")
     * @ORM\JoinColumn(name="vehicle_type_id", referencedColumnName="id")
     **/
    public $vehicleType;
    
    /**
     * @ORM\Column(type="float")
     */
    public $amount;
}