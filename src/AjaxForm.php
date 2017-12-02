<?php

namespace rebzden\ajaxform;


use rebzden\ajaxpartial\AjaxPartialWidget;
use yii\base\Widget;
use yii\web\View;
use yii\widgets\ActiveForm;

class AjaxForm extends Widget
{
    public $refreshElements = [];

    public $options = [];

    public $onSubmit = "";

    public $afterSubmit = "";

    public $loadOnInit = false;

    public $submitOnChange = false;

    /**
     * @var ActiveForm
     */
    public $form;

    public function init()
    {
        $this->form = ActiveForm::begin($this->options);
        parent::init();
    }

    public function getId($autoGenerate = true)
    {
        return $this->form->id;
    }

    public function run()
    {
        parent::run();
        ActiveForm::end();
        $this->registerRefreshScript();
    }

    public function field($model, $attribute, $options = [])
    {
        return $this->form->field($model, $attribute, $options);
    }

    private function registerRefreshScript()
    {
        $view = $this->getView();
        $this->registerAjaxPartial();
        $this->registerSubmitOnChange($view);
    }

    /**
     *
     */
    private function registerAjaxPartial()
    {
        $ajaxPartialOptions = [
            'formSelectors' => [
                [
                    'selector'    => '#' . $this->options['id'],
                    'reload'      => $this->refreshElements,
                    'onSubmit'    => $this->onSubmit,
                    'afterSubmit' => $this->afterSubmit
                ]
            ],
        ];
        if ($this->loadOnInit) {
            $ajaxPartialOptions ['loadSelectors'] = $this->refreshElements;
        }
        echo AjaxPartialWidget::widget($ajaxPartialOptions);
    }

    /**
     * @param View $view
     */
    private function registerSubmitOnChange($view)
    {
        if ($this->submitOnChange) {
            AjaxFormAsset::register($view);
            $view->registerJs("
            if (typeof ajaxForm === 'undefined') {
                var ajaxForm = new AjaxForm('#{$this->options['id']}')
            }else{
                ajaxForm.addForm('#{$this->options['id']}');
            }");
        }
    }
}