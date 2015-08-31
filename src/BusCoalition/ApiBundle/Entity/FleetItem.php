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
     * Set amount
     *
     * @param float $amount
     * @return FleetItem
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set vehicleType
     *
     * @param \BusCoalition\ApiBundle\Entity\VehicleType $vehicleType
     * @return FleetItem
     */
    public function setVehicleType(\BusCoalition\ApiBundle\Entity\VehicleType $vehicleType = null)
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    /**
     * Get vehicleType
     *
     * @return \BusCoalition\ApiBundle\Entity\VehicleType 
     */
    public function getVehicleType()
    {
        return $this->vehicleType;
    }
}
