<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">CRM</a>
    </div>
        <?php
        $perm = $_SESSION['perm'];
        if ($perm == 1) {
            include_once 'admin_menu.php';
        } else if ($perm == 2) {
            include_once 'emp_menu.php';
        } else if ($perm == 3) {
            include_once 'mngr_menu.php';
        }
        ?>
  </div>
</nav>