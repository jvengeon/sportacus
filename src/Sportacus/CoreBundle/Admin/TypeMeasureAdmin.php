<?php
namespace Sportacus\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class TypeMeasureAdmin extends Admin
{
    protected $baseRoutePattern = 'type-measure';
    public $supportsPreviewMode = true;
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('name', null, array('label' => 'Nom', 'help' => 'Nom de la mesure. Ex: poids, masse graisseuse...'))
        ->add('unit', null, array('label' => 'Unité', 'help' => 'Unité de la mesure. Ex: kg, %, etc')) //if no type is specified, SonataAdminBundle tries to guess it
        ->add('typeProgression')
        ;
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('name')
        ->add('unit')
        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('name')
        ->add('unit')
        ;
    }
    
}