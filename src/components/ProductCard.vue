<script lang="ts">
import { PropType } from 'vue';
import type { Product } from '../model/types';
import { useCartStore } from '@/stores/cart';

export default {
    // data() {
    //     return {
    //         product: {
    //             company: 'Dra. Premauer', 
    //             service: 'Prevención Cancer', 
    //             commercial_price: '50000', 
    //             caleb: '45000', 
    //             address: 'Cuba - Pereira'
    //         }
    //     }
    // }
    // props: ['product'],
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
            cover />

        <!-- <v-card-subtitle class="mt-2">
            {{ product.service }}
        </v-card-subtitle> -->
        <v-card-text>
            <!-- <p>{{ product.service }}</p> -->
            <h3>{{ product.service }}</h3>
        </v-card-text>

        <v-card-subtitle>
            <h5>Precio Comercial: <s>{{ product.commercial_price }}</s></h5> 
        </v-card-subtitle>

        <v-card-title>
            <!-- <p>Precio Comercial: {{ product.commercial_price }}</p> -->

            CALEB: <v-chip class="mb-2">
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