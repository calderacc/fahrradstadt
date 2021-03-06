<?php declare(strict_types=1);

namespace AppBundle\Weather\Retriever;

use AppBundle\Entity\City;
use AppBundle\Entity\WeatherData;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class WeatherRetriever
{
    /** @var Doctrine $doctrine */
    protected $doctrine;

    /** @var City $city */
    protected $city;

    /** @var OpenWeatherMap $openWeatherMap */
    protected $openWeatherMap;

    /** @var WeatherData $weatherData */
    protected $weatherData;

    public function __construct(Doctrine $doctrine, string $openweathermapApiKey)
    {
        $this->doctrine = $doctrine;

        $this->openWeatherMap = new OpenWeatherMap($openweathermapApiKey);
    }

    public function setCity(City $city): WeatherRetriever
    {
        $this->city = $city;

        return $this;
    }

    public function fetch(): WeatherRetriever
    {
        $currentWeather = $this->retrieveWeather();
        $this->weatherData = $this->createWeatherData($currentWeather);

        return $this;
    }

    public function getWeatherData(): WeatherData
    {
        return $this->weatherData;
    }

    protected function retrieveWeather(): CurrentWeather
    {
        $lang = 'de';
        $units = 'metric';

        $latLng = [
            'lat' => $this->city->getLatitude(),
            'lon' => $this->city->getLongitude(),
        ];

        $weather = $this->openWeatherMap->getWeather($latLng, $units, $lang);

        return $weather;
    }

    protected function createWeatherData(CurrentWeather $currentWeather): WeatherData
    {
        $weatherData = new WeatherData();

        $weatherData
            ->setCity($this->city)
            ->setTemperatureMin($currentWeather->temperature->min->getValue())
            ->setTemperatureMax($currentWeather->temperature->max->getValue())
            ->setClouds($currentWeather->clouds->getValue())
            ->setWindDirection($currentWeather->wind->direction->getValue())
            ->setWindSpeed($currentWeather->wind->speed->getValue())
            ->setWeather($currentWeather->weather->description)
            ->setRain($currentWeather->precipitation->getValue())
            ->setDateTime($currentWeather->lastUpdate);

        return $weatherData;
    }
}
