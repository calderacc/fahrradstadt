<?php declare(strict_types=1);

namespace AppBundle\Widget\CriticalmassWidget;

use AppBundle\Entity\City;
use AppBundle\Widget\AbstractWidget;
use AppBundle\Widget\WidgetDataInterface;

class CriticalmassWidget extends AbstractWidget
{
    /** @var City $city */
    protected $city;

    public function setCity(City $city): CriticalmassWidget
    {
        $this->city = $city;

        return $this;
    }

    public function render(): WidgetDataInterface
    {
        $identifier = sprintf('criticalmass-%s', $this->city->getCriticalmassCitySlug());

        return $this->retrieveData($identifier);
    }
}
