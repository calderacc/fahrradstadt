<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PhotoAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'displayDateTime',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Fotoinformationen', ['class' => 'col-xs-6'])
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('source', TextType::class)
            ->end()

            ->with('Metainformationen', ['class' => 'col-xs-6'])
            ->add('slug', TextType::class)
            ->add('enabled', CheckboxType::class)
            ->add('highlighted', CheckboxType::class)
            ->add('sponsored', CheckboxType::class)
            ->add('affiliated', CheckboxType::class)
            ->end()

            ->with('Daten', ['class' => 'col-xs-6'])
            ->add(
                'dateTime',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd HH:mm:ss'
                ]
            )
            ->add(
                'displayDateTime',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd HH:mm:ss'
                ]
            )
            ->add(
                'updatedAt',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd HH:mm:ss'
                ]
            )
            ->add(
                'createdAt',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd HH:mm:ss'
                ]
            )
            ->end()

            ->with('Datei', ['class' => 'col-xs-6'])
            ->add('imageFile', VichFileType::class)
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('user')
            ->add('dateTime')
            ->add('displayDateTime')
            ->add('enabled')
        ;
    }
}
