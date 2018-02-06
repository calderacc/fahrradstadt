<?php declare(strict_types=1);

namespace AppBundle\Share\Annotation;

/**
 * @Annotation
 */
class RouteParameter extends AbstractAnnotation
{
    protected $name;

    public function getName(): ?string
    {
        return $this->name;
    }
}
