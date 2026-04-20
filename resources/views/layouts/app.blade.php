<!DOCTYPE html>
<html>
<head>
    <title>Wari-mara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
             padding-top: 70px;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: calc(100vh - 50px); /* IMPORTANT */
            background: black;
            color: white;
            position: fixed;
            top: 50px; /* IMPORTANT */
            left: -250px;
            z-index: 1000;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #333;
        }

        .sidebar.active {
            left: 0;
        }

        /* OVERLAY (fond sombre quand menu ouvert) */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 900;
        }

        .overlay.active {
            display: block;
        }

        /* HEADER */
        .topbar {
            background: black;
            color: white;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;   /* IMPORTANT */
            top: 0;
            width: 100%;
            z-index: 1100;
        }

        .menu-btn {
            font-size: 24px;
            cursor: pointer;
        }

        /* CONTENU */
        .content {
             margin-top: 70px
             padding: 20px;
        }

        footer {
            font-size: 15px;
        }

        .card {
            border-radius: 15px;
        }

        h3 {
            font-weight: bold;
        }
    </style>

    

</head>

<body class="d-flex flex-column min-vh-100">

<div id="sidebar" class="sidebar d-flex flex-column">

    <div>
        <h4 class="text-center mt-3">💰 Wari-mara</h4>

        <a href="{{ url('/dashboard') }}">📊 Dashboard</a>
        <a href="{{ url('/ajouter') }}">💰 Transaction</a>
        <a href="{{ url('/transactions') }}">📈 Revenus/📉 Dépenses</a>
        <a href="{{ url('/dettes') }}">💳 Dettes/Factures</a>
        <a href="{{ url('/rapports') }}">📊 Rapports</a>
        <a href="{{ url('/alertes') }}">🔔 Alertes</a>
    </div>

    <!-- 🔻 LOGOUT EN BAS -->
    <div style="margin-top:auto; padding:10px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-100 btn border text-white">
                🚪 Déconnexion
            </button>
        </form>
    </div>

</div>

<!-- OVERLAY -->
<div id="overlay" class="overlay" onclick="toggleMenu()"></div>

<!-- HEADER -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleMenu()">☰</span>

    <h5>💰 Wari-mara</h5>

    <div>
        <a href="{{ url('/dashboard') }}" class="text-white me-3">Accueil</a>
        <a href="{{ url('/aide') }}" class="text-white me-3">Aide</a>
        <a href="{{ url('/apropos') }}" class="text-white">À propos</a>
    </div>




     @if(auth()->check())
        <span class="text-white me-3">Bienvenu 👤 {{ auth()->user()->name }}</span>
    @endif

</div>

<!-- CONTENU -->
<div class="content flex-grow-1">
    @yield('content')
</div>

<!-- SCRIPT -->
<script>
function toggleMenu() {
    let sidebar = document.getElementById('sidebar');
    let overlay = document.getElementById('overlay');

    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}
</script>


<footer class="bg-dark text-white p-3 mt-auto">

    <div class="container">
        <div class="row text-center text-md-start">

            <!-- GAUCHE -->
            <div class="col-md-4">
                <strong>💰 Wari-mara</strong><br>
                Gestion financière personnelle
            </div>

            <!-- CENTRE -->
            <div class="col-md-4 text-center">
                © 2026 <br>
                Amza & Ali
            </div>

            <!-- DROITE -->
            <div class="col-md-4 text-md-end">
                📞 +226 66 18 38 65 /+226 55 97 19 24 <br>
                📧 Email : amzazoeringre2@gmail.com
                    <br> | yaoa452@gmail.com
            </div>

        </div>
    </div>

</footer>

</body>
</html>
  