<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('title', 'Registre-se');


// Templates para deixar o html final igual o planejado
$this->Form->setTemplates([
    'inputContainer' => '<div class="field">{{content}}<label for="{{labelFor}}"><span class="label-content">{{labelContent}}</span></label></div>',

    'inputContainerError' => '<div class="field error">{{content}}<label for="{{labelFor}}"><span class="label-content">{{labelContent}}</span></label>{{error}}</div>'
]);

echo $this->Form->create($user, ['class' => 'aling-center']);

echo $this->Form->control('name', [
    'templateVars' => [
        'labelFor' => 'name',
        'labelContent' => 'Nome',
    ],
    'label' => false
]);

echo $this->Form->control('email', [
    'templateVars' => [
        'labelFor' => 'email',
        'labelContent' => 'E-mail',
    ],
    'label' => false,
    'autocorrect' => "off",
    'autocapitalize' => "off",
    'autocomplete' => "on"
]);

echo $this->Form->control('password', [
    'templateVars' => [
        'labelFor' => 'password',
        'labelContent' => 'Senha',
    ],
    'label' => false,
    'autocorrect' => "off",
    'autocapitalize' => "off",
    'autocomplete' => "on",
    'maxlength' => 255
]);

echo $this->Form->control('retype_password', [
    'templateVars' => [
        'labelFor' => 'retype_password',
        'labelContent' => 'Confirmar senha',
    ],
    'label' => false,
    'type' => 'password',
    'autocorrect' => "off",
    'autocapitalize' => "off",
    'autocomplete' => "on",
    'maxlength' =>255
]);

echo $this->Flash->render();

echo $this->Form->button(__('Cadastrar'), ['class' => 'login_btn']);
echo $this->Form->end();


echo $this->Html->link(
    '<span>Fazer login</span> &rightarrow;',
    ['action' => 'login'],
    ['class' => 'register_link', 'escape' => false]
);
?>

<!-- Tem como "simplificar" desta forma
<?php $this->Form->controls([
    'name' => [
        'templateVars' => [
            'labelFor' => 'name',
            'labelContent' => 'Nome',
        ],
        'label' => false,
        'required' => true,
    ],
    'email' => [
        'templateVars' => [
            'labelFor' => 'email',
            'labelContent' => 'E-mail',
        ],
        'label' => false,
        'autocorrect' => "off",
        'autocapitalize' => "off",
        'autocomplete' => "on",
        'required' => true,
    ],
    'password' => [
        'templateVars' => [
            'labelFor' => 'password',
            'labelContent' => 'Senha',
        ],
        'label' => false,
        'autocorrect' => "off",
        'autocapitalize' => "off",
        'autocomplete' => "on",
        'required' => true,
        'maxlength' => 255,
    ],
    'retype_password' => [
        'templateVars' => [
            'labelFor' => 'retype_password',
            'labelContent' => 'Confirmar senha',
        ],
        'label' => false,
        'type' => 'password',
        'autocorrect' => "off",
        'autocapitalize' => "off",
        'autocomplete' => "on",
        'required' => true,
        'maxlength' => 255,
    ],
], ['fieldset' => false]); ?>
-->