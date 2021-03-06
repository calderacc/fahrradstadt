<?php declare(strict_types=1);

namespace AppBundle\Entity;

use AppBundle\Widget\WeatherWidget\WeatherModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="weather_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeatherDataRepository")
 */
class WeatherData extends WeatherModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="weatherDatas")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @var City $city
     */
    protected $city;

    /**
     * @ORM\Column(type="float")
     * @var float $temperaturMine
     */
    protected $temperatureMin;

    /**
     * @ORM\Column(type="float")
     * @var float $temperatureMax
     */
    protected $temperatureMax;

    /**
     * @ORM\Column(type="float")
     * @var float $windSpeed
     */
    protected $windSpeed;

    /**
     * @ORM\Column(type="float")
     * @var float $windDirection
     */
    protected $windDirection;

    /**
     * @ORM\Column(type="float")
     * @var float $clouds
     */
    protected $clouds;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float $rain
     */
    protected $rain;

    /**
     * @ORM\Column(type="string")
     * @var string $weather
     */
    protected $weather;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime $dateTime
     */
    protected $dateTime;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime $createdAt
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): WeatherData
    {
        $this->id = $id;

        return $this;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): WeatherData
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): WeatherData
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setCity(City $city): WeatherData
    {
        $this->city = $city;

        return $this;
    }

    public function getTemperatureMin(): ?float
    {
        return $this->temperatureMin;
    }

    public function setTemperatureMin(float $temperatureMin = null): WeatherData
    {
        $this->temperatureMin = $temperatureMin;

        return $this;
    }

    public function getTemperatureMax(): ?float
    {
        return $this->temperatureMax;
    }

    public function setTemperatureMax(float $temperatureMax = null): WeatherData
    {
        $this->temperatureMax = $temperatureMax;

        return $this;
    }

    public function getRain(): ?float
    {
        return $this->rain;
    }

    public function setRain(float $rain): WeatherData
    {
        $this->rain = $rain;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed = null): WeatherData
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getWindDirection(): ?float
    {
        return $this->windDirection;
    }

    public function setWindDirection(float $windDirection = null): WeatherData
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    public function getClouds(): ?float
    {
        return $this->clouds;
    }

    public function setClouds(float $clouds = null): WeatherData
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function getWeather(): ?string
    {
        return $this->weather;
    }

    public function setWeather(string $weather = null): WeatherData
    {
        $this->weather = $weather;

        return $this;
    }
}
