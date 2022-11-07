<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Todo $todo
 */
?>

<?= $this->Html->css(['todos', 'todosAndUsers']) ?>

<div class="container">
    <div class="card">
        <h2 class="card-title"><?= h($todo->title) ?></h2>

        <div class="card-body-wrapper">
            <h3>Descrição da tarefa:</h3>

            <blockquote class="card-body">
                <?= $todo->hasValue('body')
                    ? $this->Text->autoParagraph(h($todo->body))
                    : 'Nenhuma descrição fornecida. ' . $this->Html->link('Editar tarefa?', ['action' => 'edit', $todo->slug])
                ?>
            </blockquote>
        </div>

        <div class="card-date">
            <p><?= __('Criada em: ') . h($todo->created->i18nFormat('dd-MM-yyyy | HH:mm', 'America/Sao_Paulo')) ?></p>
            <?php if ($todo->created != $todo->modified) : ?>
                <p><?= __('Modificada em: ') . h($todo->modified->i18nFormat('dd-MM-yyyy | HH:mm', 'America/Sao_Paulo')) ?></p>
            <?php endif ?>
        </div>
    </div>

    <aside class="sidebar">
        <h4><?= __('Ações') ?></h4>

        <?= $this->Html->link(
            $this->Html->image('icon-home-blue.svg', ['alt' => 'Voltar para home', 'title' => 'Voltar para home']) . __('Voltar para home'),
            ['action' => 'index'],
            [
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Html->link(
            $this->Html->image('icon-newtodo.svg', ['alt' => 'Nova tarefa', 'title' => 'Adicionar nova tarefa']) . __('Nova tarefa'),
            ['action' => 'add'],
            [
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Html->link(
            $this->Html->image('icon-edit-blue.svg', ['alt' => 'Editar tarefa', 'title' => 'Editar tarefa']) . __('Editar tarefa'),
            ['action' => 'edit', $todo->slug],
            [
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ) ?>

        <?= $this->Form->postLink(
            $this->Html->image('icon-delete-blue.svg', ['alt' => 'Deletar tarefa', 'title' => 'Deletar tarefa']) . __('Deletar tarefa'),
            ['action' => 'delete', $todo->slug],
            [
                'confirm' => __('Você tem certeza que deseja deletar:   {0}?', $todo->title),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ) ?>
    </aside>
</div>

<?= $this->Flash->render() ?>