<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use AppBundle\Form\Type\PhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    /**
     * @Route("/upload", name="photo_upload")
     */
    public function uploadAction(Request $request)
    {
        $photo = new Photo();

        $uploadForm = $this->createForm(PhotoType::class, $photo);

        $uploadForm->handleRequest($request);

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $photo = $uploadForm->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
        }

        return $this->render(
            'AppBundle:Photo:upload.html.twig',
            [
                'uploadForm' => $uploadForm->createView()
            ]
        );
    }
}
