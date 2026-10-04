<script lang="ts">
// import { useCartStore } from '@/stores/cart';
import { useCartStore } from '../stores/cart';

export default {
    computed: {
      itemsCount() {
        const cartStore = useCartStore(); //cartStore es la variable y useCartStore es el método.
        return cartStore.cartItemsCount;
      }
    }
}
</script>

<template>
    <v-app-bar flat>
      <v-container class="mx-auto d-flex align-center justify-center">
        <v-avatar
          class="me-4 "
          color="grey-darken-1"
          size="32">
          <v-img src="/img/caleb.jpeg" />
          </v-avatar>

        <RouterLink to="/" custom v-slot="{navigate}">
          <v-btn :active="$route.name === 'home' || $route.name === 'category'" variant="text" @click="navigate">
            <v-icon class="mr-0 mr-sm-2" icon="mdi-home-variant" />
            <span class="d-none d-sm-flex">Home</span>
          </v-btn>
        </RouterLink>

        <!-- <RouterLink to="/advertising" custom v-slot="{navigate}">
          <v-btn :active="$route.name === 'advertising'" variant="text" @click="navigate">
            <v-icon class="mr-0 mr-sm-2" icon="mdi-advertisements" />
            <span class="d-none d-sm-flex">Advertising</span>
          </v-btn>
        </RouterLink> -->

        <!-- <RouterLink to="/project" custom v-slot="{navigate}">
          <v-btn :active="$route.name === 'project'" variant="text" @click="navigate">
            <v-icon class="mr-0 mr-sm-2" icon="mdi-projector-screen" />
            <span class="d-none d-sm-flex">Project</span>
          </v-btn>
        </RouterLink> -->

        <!-- <RouterLink to="/course" custom v-slot="{navigate}">
          <v-btn :active="$route.name === 'course'" variant="text" @click="navigate">
            <v-icon class="mr-0 mr-sm-2" icon="mdi-school" />
            <span class="d-none d-sm-flex">Course</span>
          </v-btn>
        </RouterLink> -->

        <!-- <RouterLink to="/classified" custom v-slot="{navigate}">
          <v-btn :active="$route.name === 'classified'" variant="text" @click="navigate">
            <v-icon class="mr-0 mr-sm-2" icon="mdi-phone-classic" />
            <span class="d-none d-sm-flex">Classified</span>
          </v-btn>
        </RouterLink> -->

        <RouterLink to="/cart" custom v-slot="{navigate}">
          <v-badge :content="itemsCount" :model-value="itemsCount > 0" color="orange-lighten-2">
            <v-btn :active="$route.name === 'cart'" variant="text" @click="navigate">
              <v-icon class="mr-0 mr-sm-2" icon="mdi-cart" />
              <span class="d-none d-sm-flex">Cart</span>
            </v-btn>  
          </v-badge>          
        </RouterLink>

        <RouterLink to="/about" custom v-slot="{navigate}">
          <v-btn :active="$route.name === 'about'" variant="text" @click="navigate">
            <v-icon class="mr-0 mr-sm-2" icon="mdi-information" />
            <span class="d-none d-sm-flex">About</span>
          </v-btn>
        </RouterLink>   
           
        <v-spacer></v-spacer>

        <v-responsive max-width="160">
          <v-text-field
            density="compact"
            label="Search"
            rounded="lg"
            variant="solo-filled"
            flat
            hide-details
            single-line
          ></v-text-field>
        </v-responsive>
      </v-container>
    </v-app-bar>
</template>