<nav class="navbar navbar-dark navbar-expand-lg bg-dark py-3 sticky-top">
    <a class="navbar-brand mb-0 h1 ml-2" href="http://wt78.fei.stuba.sk/zadanie3/">Domov</a>
<?php
    if (isset($_SESSION["email"])){
        echo '<a class="btn btn-warning mb-0 h1 ml-2" onclick="updateHistory()">Log prihlásení</a>';
    };
?>

    <ul class="navbar-nav mr-auto mx-4" style="visibility: hidden">
        <li class="nav-item">
            <a class="nav-link" href="#"></a>
        </li>
    </ul>


</nav>