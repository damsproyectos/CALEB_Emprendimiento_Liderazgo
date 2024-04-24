<script lang="ts">
import { useCartStore } from '@/stores/cart.ts';
import type { PropType } from 'vue'
import type { CartDetail } from '../model/types'
import { mapActions } from 'pinia';

export default {
    props: {
        detail: {
            type: Object as PropType<CartDetail>,
            required: true
        }
    },
    methods: {
        // decrementQuantity(productId: number) {
        //     this.cartStore.decrement(productId);
        // },
        // incrementQuantity(productId: number) {
        //     this.cartStore.increment(productId);
        // },
        // deleteProduct(productId: number) {
        //     this.cartStore.deleteProduct(productId);
        // },
        ...mapActions(useCartStore, {
            decrementQuantity: 'decrement',   //decrementQuantity: Es el método *****decrement: Es la acción
            incrementQuantity: 'increment',
            deleteProduct: 'deleteProduct'
        })
    },
    computed: {
        productImageUrl() {
            return this.detail.product.image 
            ?? "https://cdn.vuetifyjs.com/images/cards/cooking.png";
        },
        subTotal() {
            return this.detail.product.caleb * this.detail.quantity; 
        }
    }
}
</script>

<template>
    <tr>
        <td>
            <v-avatar size="40px">
                <v-img :src="productImageUrl" />
            </v-avatar>
            {{ detail.product.service }}
        </td>
        <td class="text-center">
            <v-btn 
                class="ml-2"
                icon="mdi-minus"
                size="x-small" 
                @click="decrementQuantity(detail.product.id)" />

            Cantidad: {{ detail.quantity }}
            <v-btn 
                icon="mdi-plus"
                size="x-small"
                @click="incrementQuantity(detail.product.id)" /> <!--- incrementQuantity es un método --->
        </td>
        <td>
            ${{ detail.product.caleb }}
        </td>
        <td>
            ${{ subTotal }}
        </td>
        <td>
            <v-btn
                class="ml-2"
                icon="mdi-delete" 
                size="x-small"
                @click="deleteProduct(detail.product.id)" /> <!--- deleteProduct es un método --->
        </td>
    </tr>
</template>