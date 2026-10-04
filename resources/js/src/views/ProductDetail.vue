<script setup lang="ts">
import { useRoute, useRouter } from 'vue-router'
import { useProductsStore } from '@/src/stores/products'
import { useCartStore } from '@/src/stores/cart'
import { onMounted, computed } from 'vue'

const route = useRoute()
const router = useRouter()
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
    // cartStore.add(product.value)
    cartStore.addProduct(product.value)
  }
}

const goBack = () => {
  router.back()
}
</script>

<template>
  <v-container class="py-10">
    <v-row class="justify-center">
      <v-col cols="12" md="10">
        <v-card class="pa-5" elevation="4">
          <v-row>

            <!-- ⭐ BLOQUE DE IMÁGENES -->
            <v-col cols="12" md="6" class="d-flex justify-center align-center">

              <!-- 🟢 1) Varias imágenes -->
              <v-carousel
                v-if="product?.images && product.images.length"
                height="400"
                hide-delimiter-background
                show-arrows-on-hover
                cycle
              >
                <v-carousel-item
                  v-for="(img, index) in product.images"
                  :key="index"
                  :src="img"
                />
              </v-carousel>

              <!-- 🟡 2) Solo imagen principal -->
              <img
                v-else-if="product?.image"
                :src="product.image"
                style="width: 100%; border-radius: 10px"
              />

              <!-- 🔴 3) No hay imágenes -->
              <div
                v-else
                class="p-4 text-center bg-grey-lighten-3 rounded"
                style="width: 100%; height: 300px;"
              >
                <p class="mt-10">Este producto no tiene imágenes.</p>
              </div>

            </v-col>
            <!-- FIN BLOQUE IMÁGENES -->

            <!-- Detalles -->
            <v-col cols="12" md="6">
              <h1 class="text-h4 font-weight-bold mb-2">{{ product.service }}</h1>
              <p class="text-subtitle-1 text-grey-darken-1 mb-3">
                Empresa: {{ product.company }}
              </p>

              <v-divider class="my-4" />

              <div class="text-subtitle-2">Precio:</div>
              <div class="text-h5 font-weight-bold text-success mb-4">
                ${{ product.caleb.toLocaleString() }}
              </div>

              <v-btn color="primary" size="large" class="mt-3" @click="addToCart">
                <v-icon start>mdi-cart</v-icon>
                Agregar al carrito
              </v-btn>

              <v-divider class="my-6" />

              <h3 class="text-h6 font-weight-bold mb-2">
                Descripción
              </h3>

              <p
                v-if="product.description"
                class="text-body-1 text-grey-darken-2"
              >
                {{ product.description }}
              </p>

              <p
                v-else
                class="text-body-2 text-grey"
              >
                Este producto no tiene descripción disponible.
              </p>
            </v-col>

            <v-btn
              variant="text"
              size="small"
              color="primary"
              class="mb-3"
              @click="goBack"
            >
              <v-icon start size="18">mdi-arrow-left</v-icon>
              Volver
            </v-btn>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
