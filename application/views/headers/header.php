<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <title>
    <?php echo $title; ?>
  </title>
  <link rel="shortcut icon" href="<?php echo base_url('public/img/favicon.ico'); ?>" type="image/x-icon">

  <link rel="stylesheet" href="<?php echo base_url('public/css/style.css?v=1.0.0'); ?>" media="all">
  <script type="text/javascript" src="<?php echo base_url('public/js/jquery-3.6.0.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/js/jquery-ui/jquery-ui.min.js'); ?>"></script>

  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,700;0,900;1,100;1,300;1,700;1,900&display=swap"
    rel="stylesheet">

  <?php if (in_array($this->uri->segment(1), ['item', 'estimate'])): ?>
    <link rel="stylesheet" href="<?php echo base_url('public/js/quill/quill.snow.css'); ?>" media="all">
  <?php endif; ?>
</head>

<body
  class="<?php echo $class; ?> <?php echo isset($user->defaulttheme) && $user->defaulttheme == 'dark' ? 'dark-mode' : 'light-mode'; ?>">

  <nav>
    <div class="logo">
      <a href="<?php echo base_url(); ?>">
        <?php echo $this->config->item('name'); ?>
      </a>
    </div>

    <?php if ($user): ?>
      <div class="header-menu">
        <ul>
          <li>
            <a href="" class="click-header-sub-menu">Alunos</a>
            <ul class="header-sub-menu" style="display: none;">
              <li>
                <a href="<?php echo base_url('dates'); ?>">Datas</a>
              </li>
              <li>
                <a href="<?php echo base_url('d'); ?>">Disciplinas</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="" class="click-header-sub-menu">Professores</a>
            <ul class="header-sub-menu" style="display: none;">
              <li>
                <a href="<?php echo base_url('items'); ?>">Itens</a>
              </li>
            </ul>
          </li>
      </div>
    <?php endif; ?>

    <?php if ($user): ?>
      <div class="user-infos">

        <div class="menu-icons">

        </div>
        <div class="avatar">
          <?php echo $user->short_name; ?>
        </div>
        <ul>
          <li>
            <a href="<?php echo base_url('me'); ?>"><i class="ph ph-hard-drives"></i>Minha conta</a>
          </li>
          <li>
            <a href="<?php echo base_url('logout'); ?>"><i class="ph ph-x-circle"></i>Sair</a>
          </li>
        </ul>
      </div>
    <?php endif; ?>

  </nav>
