<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Visualizando informações de : ' . __($user->name));
echo $this->Html->css(['users', 'todosAndUsers']);
?>

<div class="container">
    <div class="card">
        <?= $this->Flash->render('user') ?>

        <div class="card-title">
            <h2 class="user-name">Nome: <span><?= h($user->name) ?></span></h2>
            <p class="user-email">E-mail: <span><?= h($user->email) ?></span></p>
        </div>

        <div class="card-date">
            <p><?= __('Criado em: ') . h($user->created->i18nFormat('dd-MM-yyyy | HH:mm', 'America/Sao_Paulo')) ?></p>
            <?php if ($user->created != $user->modified) : ?>
                <p><?= __('Modificado em: ') . h($user->modified->i18nFormat('dd-MM-yyyy | HH:mm', 'America/Sao_Paulo')) ?></p>
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
            ['controller' => 'Todos', 'action' => 'add'],
            [
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ); ?>

        <?= $this->Html->link(
            $this->Html->image('icon-edit-blue.svg', ['alt' => 'Editar usuário', 'title' => 'Editar usuário']) . __('Editar usuário'),
            ['action' => 'edit', $user->id],
            [
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ) ?>

        <?= $this->Form->postLink(
            $this->Html->image('icon-delete-blue.svg', ['alt' => 'Deletar usuário', 'title' => 'Deletar usuário']) . __('Deletar usuário'),
            ['action' => 'delete', $user->id],
            [
                'confirm' => __('Você tem certeza que deseja deletar seu usuário?'),
                'class' => 'sidebar-item',
                'escape' => false
            ]
        ) ?>
    </aside>

    <div class="related">
        <div class="related-header">
            <h3><?= __('Todos seus afazeres') ?></h3>
            <?= $this->Flash->render() ?>
        </div>

        <?php if (!empty($user->todos)) : ?>
            <table>
                <thead>
                    <tr>
                        <th><?= __('Título') ?></th>
                        <th><?= __('Criado') ?></th>
                        <th><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user->todos as $todo) : ?>
                        <tr>
                            <td>
                                <?= $this->Text->truncate($todo->title, 75, [
                                    'ellipsis' => '...',
                                    'exact' => false
                                ]); ?>
                            </td>

                            <td><?= h($todo->created->i18nFormat('dd-MM-yyyy | HH:mm', 'America/Sao_Paulo')) ?></td>

                            <td>
                                <div class="action">
                                    <?= $this->Html->link(
                                        $this->Html->image('icon-file-gray.svg', ['alt' => 'Ver tarefa', 'title' => 'Ver tarefa']),
                                        ['controller' => 'Todos', 'action' => 'view', $todo->slug],
                                        [
                                            'escape' => false
                                        ]
                                    ) ?>

                                    <?= $this->Html->link(
                                        $this->Html->image('icon-edit-gray.svg', ['alt' => 'Editar tarefa', 'title' => 'Editar tarefa']),
                                        ['controller' => 'Todos', 'action' => 'edit', $todo->slug],
                                        [
                                            'escape' => false
                                        ]
                                    ) ?>

                                    <?= $this->Form->postLink(
                                        $this->Html->image('icon-delete-gray.svg', ['alt' => 'Deletar tarefa', 'title' => 'Deletar tarefa']),
                                        ['controller' => 'Todos', 'action' => 'delete', $todo->slug],
                                        [
                                            'confirm' => __('Você tem certeza que deseja deletar:   {0}?', $todo->title),
                                            'escape' => false
                                        ]
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>