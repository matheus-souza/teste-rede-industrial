<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">TRI</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" active-class="active" :to="{ name: 'home' }" clas>Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" active-class="active" :to="{ name: 'hello' }" clas>Hello</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Usuários
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Ação</a>
                            <a class="dropdown-item" href="#">Outra ação</a>
                            <a class="dropdown-item" href="#">Algo mais aqui</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>
<script>
    export default {}
</script>
