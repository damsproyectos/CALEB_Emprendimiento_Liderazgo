<script lang="ts">
import { useCartStore } from '@/stores/cart.ts';
import { mapState } from 'pinia';
import ShoppingCartItem from './ShoppingCartItem.vue';

export default {
    components: {
        ShoppingCartItem
    },
    computed: {
        // cartStore() {
        //     return useCartStore();
        // },
        // details() {
        //     return this.cartStore.details;
        // },
        ...mapState(useCartStore, ["details"])
    }
}
</script>

<template>
    <v-card>
        <v-card-title>
            Productos agregados al carrito:
        </v-card-title>

        <v-card-text>
            <v-table v-if="details.length > 0">
                <thead>
                <tr>
                    <th class="text-left">
                        Producto
                    </th>
                    <th class="text-center">
                        Cantidad
                    </th>
                    <th>
                        Precio
                    </th>
                    <th class="text-left">
                        Subtotal
                    </th>
                    <th>
                        <span class="d-sr-only">
                            Eliminar
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <ShoppingCartItem 
                        v-for="detail in details" 
                        :key="detail.product.id"
                        :detail="detail" />
                </tbody>
            </v-table>
            <p v-else>
                Aun no has agregado items a tu carrito de compras; haz <RouterLink to="/">click aquí</RouterLink> para ver los productos disponibles. 
            </p>
        </v-card-text>
    </v-card>
</template>