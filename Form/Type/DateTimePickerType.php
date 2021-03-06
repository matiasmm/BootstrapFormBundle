<?php
/**
 * This file is part of VinceTBootstrapFormBundle for Symfony2
 *
 * @category VinceT
 * @package  VinceTBootstrapFormBundle
 * @author   Vincent Touzet <vincent.touzet@gmail.com>
 * @license  MIT License view the LICENSE file that was distributed with this source code.
 * @link     https://github.com/vincenttouzet/BootstrapFormBundle
 */

namespace VinceT\BootstrapFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use VinceT\BootstrapFormBundle\Form\DataTransformer\DateTimeToPartsTransformer;

/**
 * TimePickerType
 *
 * @category VinceT
 * @package  VinceTBootstrapFormBundle
 * @author   Vincent Touzet <vincent.touzet@gmail.com>
 * @license  MIT License view the LICENSE file that was distributed with this source code.
 * @link     https://github.com/vincenttouzet/BootstrapFormBundle
 */
class DateTimePickerType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dateOptions = array_intersect_key($options, array_flip(array(
            'week_start',
            'view_mode',
            'min_view_mode',
        )));

        $timeOptions = array_intersect_key($options, array_flip(array(
            'minute_step',
            'second_step',
            'disable_focus',
            'with_seconds',
        )));
        $builder
            ->resetViewTransformers()
            ->remove('date')
            ->remove('time')
            ->addViewTransformer(new DateTimeToPartsTransformer())
            ->add('date', 'bootstrap_datepicker', $dateOptions)
            ->add('time', 'bootstrap_timepicker', $timeOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'week_start' => $options['week_start'],
            'view_mode' => $options['view_mode'],
            'min_view_mode' => $options['min_view_mode'],
            'minute_step' => $options['minute_step'],
            'second_step' => $options['second_step'],
            'disable_focus' => $options['disable_focus'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'format' => 'yyyy-MM-dd',
            'week_start' => 0, // day of the week start. 0 for Sunday - 6 for Saturday
            'view_mode' => 0,
            'min_view_mode' => 0,
            'minute_step' => 15,
            'second_step' => 15,
            'disable_focus' => false,
            'attr' => array(
                'class' => 'input-small'
            ),
        ));

        $resolver->setAllowedValues(array(
            'week_start' => array(0, 1, 2, 3, 4, 5, 6),
            'view_mode'    => array(0, 'days', 1, 'months', 2, 'years'),
            'min_view_mode'    => array(0, 'days', 1, 'months', 2, 'years'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'datetime';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bootstrap_datetimepicker';
    }
}
