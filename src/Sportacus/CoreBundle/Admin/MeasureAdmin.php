<?php
namespace Sportacus\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class MeasureAdmin extends Admin
{
    protected $baseRoutePattern = 'measure';
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('date', 'date', array('label' => 'Date'))
            ->add('value')
            ->add('typeMeasure', 'sonata_type_model_autocomplete', ['property' => 'name', 'to_string_callback' => function($enitity, $property) {
            return $enitity->getName();
        }])
        ;
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('date')
        ->add('value')
        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('date')
        ->add('value')
        ->add('typeMeasure', null, ['associated_tostring' => 'getName'])
        ;
    }
    
}