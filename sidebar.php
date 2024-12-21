<!-- Sidebar -->
<nav id="sidebar" class="bg-white">
  <div class="logo-wrapper">
    <img src="images/bitap-blue.png" alt="Logo" class="img-fluid" style="border-radius: 5px;">
    <p class="sidebar-text">BITAP</p>
  </div>

  <button type="button" id="sidebarToggle" class="btn btn-primary">
    <i class="fas fa-chevron-circle-left"></i>
  </button>

  <ul class="list-unstyled components">
    <li class="nav-item">
      <a class="nav-link active" href="index.php?page=pos">
        <i class="fas fa-cash-register"></i> <span class="sidebar-text">POS</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php?page=dashboard">
        <i class="fas fa-tachometer-alt"></i> <span class="sidebar-text">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="index.php?page=member">
        <i class="fas fa-user"></i> <span class="sidebar-text">Member</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php?page=transaction">
        <i class="fas fa-exchange-alt"></i> <span class="sidebar-text">Transaction</span>
      </a>
    </li>
    </li>
    <?php if ($role === 'admin') { ?>
      <li class="nav-item">
      <a class="nav-link" href="index.php?page=product">
        <i class="fas fa-box"></i> <span class="sidebar-text">Product</span>
      </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?page=user">
            <i class="fas fa-cog"></i> <span class="sidebar-text">User</span>
        </a>
    </li>
    <?php } ?>

    <li class="nav-item">
        <a class="nav-link" href="logout.php">
        <i class="fas fa-sign-out-alt"></i> <span class="sidebar-text">Logout</span>
        </a>
    </li>
  </ul>
</nav>
