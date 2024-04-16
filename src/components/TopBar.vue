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
          size="32"
        ></v-avatar>

        <RouterLink to="/" custom v-slot="{navigate}">
          <v-btn prepend-icon="mdi-home-variant" :active="$route.name === 'home'" variant="text" @click="navigate">
            Home
          </v-btn>
        </RouterLink>
        <RouterLink to="/advertising" custom v-slot="{navigate}">
          <v-btn prepend-icon="mdi-advertisements" :active="$route.name === 'advertising'" variant="text" @click="navigate">
            Advertising
          </v-btn>
        </RouterLink>
        <RouterLink to="/project" custom v-slot="{navigate}">
          <v-btn prepend-icon="mdi-projector-screen" :active="$route.name === 'project'" variant="text" @click="navigate">
            Project
          </v-btn>
        </RouterLink>
        <RouterLink to="/course" custom v-slot="{navigate}">
          <v-btn prepend-icon="mdi-school" :active="$route.name === 'course'" variant="text" @click="navigate">
            Course
          </v-btn>
        </RouterLink>
        <RouterLink to="/classified" custom v-slot="{navigate}">
          <v-btn prepend-icon="mdi-phone-classic" :active="$route.name === 'classified'" variant="text" @click="navigate">
            Classified
          </v-btn>
        </RouterLink>
        <RouterLink to="/cart" custom v-slot="{navigate}">
          <v-badge :content="itemsCount" :model-value="itemsCount > 0" color="orange-lighten-2">
            <v-btn prepend-icon="mdi-cart " :active="$route.name === 'cart'" variant="text" @click="navigate">
              Cart
            </v-btn>  
          </v-badge>          
        </RouterLink>
        <RouterLink to="/about" custom v-slot="{navigate}">
          <v-btn prepend-icon="mdi-information" :active="$route.name === 'about'" variant="text" @click="navigate">
            About
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