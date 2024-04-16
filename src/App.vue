<script lang="ts">
import TopBar from './components/TopBar.vue'

export default {
  components: {
    TopBar
  }
}
</script>

<template>
  <!--<header>
     <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />
    <div class="wrapper">
       <HelloWorld msg="You did it!" /> 
      <nav>
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/advertising">Advertising</RouterLink>
        <RouterLink to="/project">Project</RouterLink>
        <RouterLink to="/course">Course</RouterLink>
        <RouterLink to="/classified">Classified</RouterLink>
        <RouterLink to="/cart">Cart</RouterLink>
        <RouterLink to="/about">About</RouterLink>
      </nav>
    </div>
  </header> -->
  <v-app>
    <TopBar /> <!-----Se encuentran todos los RouterLink son los que nos permite definir enlaces hacia nuestras rutas --->

    <v-main> 
      <v-container>
        <RouterView />  <!-----Routerview: se encarga de mostrar el contenido de cada una de las páginas que visitamos --->
      </v-container>
    </v-main>    
  </v-app>  
</template>




















<!--
<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
-->