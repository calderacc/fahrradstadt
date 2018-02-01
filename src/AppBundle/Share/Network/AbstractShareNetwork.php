<?php

namespace AppBundle\Share\Network;

use AppBundle\Entity\Photo;
use AppBundle\Share\Annotation\Shareable;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractShareNetwork implements ShareNetworkInterface
{
    protected $name;

    protected $icon;

    protected $backgroundColor;

    protected $textColor;

    protected $router;

    protected $annotationReader;

    public function __construct(Router $router, AnnotationReader $annotationReader)
    {
        $this->router = $router;
        $this->annotationReader = $annotationReader;
    }

    public function getIdentifier(): string
    {
        $reflection = new \ReflectionClass($this);

        $shortname = $reflection->getShortName();

        $identifier = strtolower(str_replace('ShareNetwork', '', $shortname));

        return $identifier;
    }

    protected function getPhotoUrl(Photo $photo): string
    {
        $reflectionClass = new \ReflectionClass($photo);
        $annotation = $this->annotationReader->getClassAnnotation($reflectionClass, Shareable::class);

        $photoUrl = $this->router->generate($annotation->getRoute(), ['slug' => $photo->getSlug()], RouterInterface::ABSOLUTE_URL);

        return str_replace('http://', 'https://', $photoUrl);
    }

    public function createUrlForPhoto(Photo $photo): string
    {
        return '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    public function getTextColor(): string
    {
        return $this->textColor;
    }
}
