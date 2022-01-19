<div class="nav">
  <div class="nav-header">
    <div class="nav-title">
      Проект
    </div>
  </div>

  <div class="nav-links">
    <ul>
      <?php
      $urls = array(
        'Начало' => '/',
        'Чакащи рецензии' => '/waiting',
        'Импорт' => '/import',
        'Експорт' => '/export',
        'Още нещо' => '/more'
      );
      foreach ($urls as $name => $url) {
        print '<li><a href="' . $url . '">' . $name . '</a></li>';
      }
      ?>
    </ul>
  </div>
</div>