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
        ->add('content', 'sonata_formatter_type', array(
            'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
            'format_field'   => 'contentFormatter',
            'source_field'   => 'name',
            'source_field_options'      => array(
                'horizontal_input_wrapper_class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'col-lg-12': '',
                'attr' => array('class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'span10 col-sm-10 col-md-10': '', 'rows' => 20)
            ),
            'ckeditor_context'     => 'measure',
            'target_field'   => 'content',
            'listener'       => true,
        ))
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