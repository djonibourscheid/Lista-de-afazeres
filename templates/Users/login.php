<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('title', 'Conecte-se');


// Templates para deixar o html final igual o planejado
$this->Form->setTemplates([
  'inputContainer' => '<div class="field">{{content}}<label for="{{labelFor}}"><span class="label-content">{{labelContent}}</span></label></div>',

  'inputContainerError' => '<div class="field error">{{content}}<label for="{{labelFor}}"><span class="label-content">{{labelContent}}</span></label>{{error}}</div>'
]);

echo $this->Form->create(null, ['class' => 'aling-center']);

echo $this->Form->control('email', [
  'templateVars' => [
    'labelFor' => 'email',
    'labelContent' => 'E-mail',
  ],
  'label' => false,
  'autocorrect' => "off",
  'autocapitalize' => "off",
  'autocomplete' => "on",
  'required' => true,
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
  'required' => true,
  'maxlength' => 255
]);

// Mensagens passadas do controller
echo $this->Flash->render();

echo $this->Form->button(__('Entrar'), ['class' => 'login_btn']);
echo $this->Form->end();


echo $this->Html->link(
  '<span>Cadastrar usuário </span> &rightarrow;',
  ['action' => 'add'],
  ['class' => 'register_link', 'escape' => false]
);
