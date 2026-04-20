<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Wari-mara</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/transactions') }}">Transactions</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/depenses') }}">Dépenses</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/revenus') }}">Revenus</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/dettes') }}">Dettes / Factures</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/rapports') }}">Rapports</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/alertes') }}">Alertes intelligentes</a>
        </li>

      </ul>
    </div>
  </div>
</nav>