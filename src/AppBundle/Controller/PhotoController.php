<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use AppBundle\Form\Type\PhotoType;
use PHPExif\Reader\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use \Malenki\Slug;

class PhotoController extends Controller
{
    public function uploadAction(Request $request, UserInterface $user)
    {
        $photo = new Photo();

        $uploadForm = $this->createForm(PhotoType::class, $photo);

        $uploadForm->handleRequest($request);

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var Photo $photo */
            $photo = $uploadForm->getData();

            $photo
                ->setUser($user)
                ->setDisplayDateTime(new \DateTime())
            ;

            $em->persist($photo); // first persist to generate id
            $em->flush();

            $photo
                ->setDateTime($this->getPhotoDateTime($photo))
                ->setSlug($this->createSlug($photo))
            ;

            $em->persist($photo); // second persist to save slug
            $em->flush();
        }

        return $this->render(
            'AppBundle:Photo:upload.html.twig',
            [
                'uploadForm' => $uploadForm->createView()
            ]
        );
    }

    protected function getPhotoDateTime(Photo $photo): ?\DateTime
    {
        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $this->getParameter('kernel.root_dir').'/../web/'.$helper->asset($photo, 'imageFile');

        $reader = Reader::factory(Reader::TYPE_NATIVE);

        $exif = $reader->getExifFromFile($path);

        $dateTime = $exif->getCreationDate();

        if ($dateTime) {
            return $dateTime;
        }

        return null;
    }

    protected function createSlug(Photo $photo): string
    {
        return new Slug($photo->getTitle().' '.$photo->getId());
    }
}
