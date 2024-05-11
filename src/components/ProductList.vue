<script lang="ts">
import ProductCard from './ProductCard.vue';
import { useProductsStore } from '../stores/products'
import { mapState } from 'pinia';

export default{
    components: {
        ProductCard
    },
    computed: {
        ...mapState(useProductsStore, ['products', 'loading'])
    }
}
</script>

<template>
    <!-- <ul>
        <!- <li>Producto 1</li>
        <li>Producto 2</li>
        <li>Producto 3</li> -->
        <!-- <li v-for="product in products">
            {{ product.company }} 
            {{ product.service }}
            ($ {{ product.commercial_price }})
            ($ {{ product.caleb }})
            {{ product.adress }}
        </li>          
    </ul> -->   
    <div v-if="loading" class="d-flex justify-center align-center h-100">
        <v-progress-circular color="primary" indeterminate :size="60" />
    </div>

    <v-row v-else>
        <v-col v-for="p in products" :key="p.id" cols="4">
            <ProductCard    
                :product="p" />  <!--p se refiere al producto --- products es lista de producctos ------ product es la propiedad (props)-->  
        </v-col>
    </v-row>      
</template>