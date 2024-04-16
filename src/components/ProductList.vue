<script lang="ts">
import type { Product } from '../model/types';
import ProductCard from './ProductCard.vue';

export default{
    components: {
        ProductCard
    },
    data() {
        return {
            products: [
                { company: 'Marilyn Ortiz', service: 'Limpieza facial profunda', commercial_price: '100.000', caleb: '80.000', address: 'La Villa - Pereira', id: 4},
                { company: 'Movi&Fisio Integral', service: 'Valoración + 6 terapias', commercial_price: '270.000', caleb: '80.000', address: 'La Villa - Pereira', id: 5 },
                { company: 'Jeferson Zambrano P', service: 'Limpieza Dental', commercial_price: '80.000', caleb: '60.000', address: 'La Villa - Pereira', id: 6 },
                { company: 'Dra. Premauer', service: 'Prevención Cancer', commercial_price: '50.000', caleb: '45.000', address: 'Cuba - Pereira', id: 7 },
                { company: 'muebles BL', service: 'silla', commercial_price: '56.000', caleb: '40.000', address: 'Cra 17 A # 83B- 59 La Villa - Pereira', id: 1 },    
                { company: 'Tecnology', service: 'Monitor', commercial_price: '45.0000', caleb: '40.0000', address: 'La Villa - Pereira', id:2 },
                { company: 'Tecnology', service: 'Microfono', commercial_price: '120.000', caleb: '80.000', address: 'La Villa - Pereira', id: 3 },
                { company: 'Luis Arcila', service: 'Finanzas Personales', commercial_price: '2.000.000', caleb: '1.800.000', address: 'La Villa - Pereira', id: 8 },
                { company: 'Luz María Martínez', service: 'Enfermería', commercial_price: '100.000', caleb: '80.000', address: 'La Villa - Pereira', id: 9 },
                { company: 'Marilyn Ortiz', service: 'Limpieza facial profunda', commercial_price: '100.000', caleb: '80.000', address: 'La Villa - Pereira', id: 4 },
                { company: 'Movi&Fisio Integral', service: 'Valoración + 6 terapias', commercial_price: '270.000', caleb: '80.000', address: 'La Villa - Pereira', id: 5 },
                { company: 'Jeferson Zambrano P', service: 'Limpieza Dental', commercial_price: '80.000', caleb: '60.000', address: 'La Villa - Pereira', id: 6 },
                { company: 'Dra. Premauer', service: 'Prevención Cancer', commercial_price: '50.000', caleb: '45.000', address: 'Cuba - Pereira', id: 7 },
                { company: 'muebles BL', service: 'silla', commercial_price: '56.000', caleb: '40.000', address: 'Cra 17 A # 83B- 59 La Villa - Pereira', id: 1 },    
                { company: 'Tecnology', service: 'Monitor', commercial_price: '45.0000', caleb: '40.0000', address: 'La Villa - Pereira', id:2 },
                { company: 'Tecnology', service: 'Microfono', commercial_price: '120.000', caleb: '80.000', address: 'La Villa - Pereira', id: 3 },
                { company: 'Luis Arcila', service: 'Finanzas Personales', commercial_price: '2.000.000', caleb: '1.800.000', address: 'La Villa - Pereira', id: 8 },
                { company: 'Luz María Martínez', service: 'Enfermería', commercial_price: '100.000', caleb: '80.000', address: 'La Villa - Pereira', id: 9 }
            ] as Product[]
        }
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
        <v-row>
            <v-col v-for="p in products" :key="p.id" cols="4">
                <ProductCard    
                    :product="p" />  <!--p se refiere al producto --- products es lista de producctos ------ product es la propiedad (props)-->  
            </v-col>
        </v-row>      
</template>