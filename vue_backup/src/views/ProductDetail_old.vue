<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useProductsStore } from '@/stores/products'
import { useCartStore } from '@/stores/cart'
import { onMounted, computed } from 'vue'

const route = useRoute()
const store = useProductsStore()
const cartStore = useCartStore()

const productId = Number(route.params.id)

const product = computed(() =>
  store._products.find(p => p.id === productId)
)

onMounted(() => {
  if (store._products.length === 0) {
    store.fetchProducts()
  }
})

const addToCart = () => {
  if (product.value) {
    cartStore.add(product.value)
  }
}
</script>

<template>
  <v-container class="py-10">
    <v-row class="justify-center">
      <v-col cols="12" md="10">
        <v-card class="pa-5" elevation="4">
          <v-row>
            <!-- Imagen / Carrusel -->
            <v-col cols="12" md="6" class="d-flex justify-center align-center">
              <v-carousel
                v-if="product?.image"
                height="400"
                hide-delimiter-background
                show-arrows-on-hover
                cycle
              >
                <!-- Cambia a product.images si tienes múltiples -->
                <v-carousel-item :src="product.image" />
              </v-carousel>
            </v-col>

            <!-- Detalles del producto -->
            <v-col cols="12" md="6">
              <h1 class="text-h4 font-weight-bold mb-2">{{ product.service }}</h1>
              <p class="text-subtitle-1 text-grey-darken-1 mb-3">Empresa: {{ product.company }}</p>

              <v-divider class="my-4" />

              <div class="text-subtitle-2">Precio Caleb:</div>
              <div class="text-h5 font-weight-bold text-success mb-4">
                ${{ product.caleb.toLocaleString() }}
              </div>

              <v-btn color="primary" size="large" class="mt-3" @click="addToCart">
                <v-icon start>mdi-cart</v-icon>
                Agregar al carrito
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>


