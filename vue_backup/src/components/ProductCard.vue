<script lang="ts">
import { PropType } from 'vue';
import type { Product } from '../model/types';
import { useCartStore } from '@/stores/cart.ts';

export default {
    props: {
        product: {
            type: Object as PropType<Product>,
            required: true
        }  
    },
    methods: {
        onAddButtonClick() {
            const cartStore = useCartStore();
            cartStore.addProduct(this.product);
        },
        goToProductDetail() {
            this.$router.push({ 
                name: 'product-detail', 
                params: { id: this.product.id } 
            });
        }
    },
    computed: {
        productImageUrl() {
            return this.product.image 
            ?? "https://cdn.vuetifyjs.com/images/cards/cooking.png";
        }
    }
}
</script>

<template>
    <v-card :title="product.company">

        <v-img
            height="250"
            :src="productImageUrl"
            cover
            class="cursor-pointer"
            @click="goToProductDetail"
        />
        <v-card-text>
            <!-- <p>{{ product.service }}</p> -->
            <h3>{{ product.service }}</h3>
        </v-card-text>

        <v-card-subtitle>
            <h5>Precio Comercial: <s>{{ product.commercial_price }}</s></h5> 
        </v-card-subtitle>

        <v-card-title>
            <!-- <p>Precio Comercial: {{ product.commercial_price }}</p> -->

            Caleb: <v-chip class="mb-2">
                 $ {{ product.caleb }}
            </v-chip>
        </v-card-title>

        <v-card-text>
            <p>Dirección: {{ product.address }}</p>
        </v-card-text>

        <v-card-actions>
            <v-btn @click="onAddButtonClick" color="orange-lighten-2">
                Agregar al carrito 
            </v-btn>
        </v-card-actions>
    </v-card>
</template>