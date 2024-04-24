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
                { company: 'Marilyn Ortiz', service: 'Limpieza facial profunda', commercial_price: '100.000', caleb: '80000', address: 'La Villa - Pereira', id: 1, image: 'https://img.freepik.com/foto-gratis/mujer-visitando-cosmetologa-realizando-procedimientos-rejuvenecimiento_1303-26040.jpg?w=900&t=st=1713478321~exp=1713478921~hmac=4f54a059e9141747b58e4ad4e7960c71bf05379dbf87ae423fd3003af1784306' },
                { company: 'Movi&Fisio Integral', service: 'Valoración + 6 terapias', commercial_price: '270.000', caleb: '180000', address: 'La Villa - Pereira', id: 2, image: 'https://img.freepik.com/foto-gratis/mujer-que-tiene-sesion-fisioterapia_23-2149115642.jpg?t=st=1713478744~exp=1713482344~hmac=97f57e0e43b1b779b5e2e94b45cde99b689bf0e7de726be718948181dd2cbd0b&w=900' },
                { company: 'Jeferson Zambrano P', service: 'Limpieza Dental', commercial_price: '80.000', caleb: '60000', address: 'La Villa - Pereira', id: 3, image: 'https://img.freepik.com/foto-gratis/mujer-sonriente-silla-dentista_1153-655.jpg?t=st=1713478956~exp=1713482556~hmac=e7e227b97132cae874c8691cc0aac5e7370930b1096596ed5017b0af2707a807&w=900' },
                { company: 'Dra. Premauer', service: 'Prevención Cancer', commercial_price: '50.000', caleb: '45000', address: 'Cuba - Pereira', id: 4, image: 'https://img.freepik.com/foto-gratis/concienciacion-sobre-dia-mundial-cancer-paciente_23-2151249750.jpg?t=st=1713479278~exp=1713482878~hmac=2fbcaf8d4a4c16d65720442c0d8dd299c7ff9b6f0840bb74c1bc283d54ec5bb4&w=900' },
                { company: 'muebles BL', service: 'silla', commercial_price: '56.000', caleb: '40000', address: 'Cra 17 A # 83B- 59 La Villa - Pereira', id: 5, image: 'https://img.freepik.com/psd-gratis/silla-almohada_176382-873.jpg?t=st=1713530442~exp=1713534042~hmac=44c0b1ec80bf9ac8ce471b4dc48508e71b92ff1dca4f0d5d4db9129b77849e77&w=740' },    
                { company: 'Tecnology', service: 'Monitor', commercial_price: '45.0000', caleb: '400000', address: 'La Villa - Pereira', id: 6, image: 'https://img.freepik.com/psd-gratis/imagen-tridimensional-computadora_53876-1608.jpg?t=st=1713530626~exp=1713534226~hmac=02ca0f1ab05e33183e9917946d1feaf382509bb46626efd4d8f0a1bfa0ab91cc&w=900' },
                { company: 'Bike Store', service: 'Alistamiento de Bicicleta', commercial_price: '120.000', caleb: '80000', address: 'La Villa - Pereira', id: 7, image: '/img/bike.jpeg' },
                { company: 'Luis Arcila', service: 'Finanzas Personales', commercial_price: '2.000.000', caleb: '1800000', address: 'La Villa - Pereira', id: 8, image: '/img/finanzas.webp' },
                { company: 'Luz María Martínez', service: 'Enfermería', commercial_price: '100.000', caleb: '80000', address: 'La Villa - Pereira', id: 9, image: '/img/enfermeria.webp' },
                { company: 'Marilyn Ortiz', service: 'Limpieza facial profunda', commercial_price: '100.000', caleb: '80000', address: 'La Villa - Pereira', id: 10, image: '/img/marilyn.jpeg' },
                { company: 'Movi&Fisio Integral', service: 'Valoración + 6 terapias', commercial_price: '270.000', caleb: '80000', address: 'La Villa - Pereira', id: 11, image: '/img/movifisio.jpeg' },
                { company: 'Jeferson Zambrano P', service: 'Limpieza Dental', commercial_price: '80.000', caleb: '60000', address: 'La Villa - Pereira', id: 12, image: '/img/odontologia.jpeg' },
                { company: 'Dra. Premauer', service: 'Prevención Cancer', commercial_price: '50.000', caleb: '45000', address: 'Cuba - Pereira', id: 13 },
                { company: 'muebles BL', service: 'silla', commercial_price: '56.000', caleb: '40000', address: 'Cra 17 A # 83B- 59 La Villa - Pereira', id: 14 },    
                { company: 'Tecnology', service: 'Microfono', commercial_price: '45.0000', caleb: '400000', address: 'La Villa - Pereira', id:15, image: 'https://img.freepik.com/vector-gratis/microfono-metalico-realista-cantar_52683-10360.jpg?t=st=1713534522~exp=1713538122~hmac=647dc39af1844e0be7d60520a2a20ba225b0e45525b213bcb79036f9c7e37244&w=740' },
                { company: 'Tecnology', service: 'Monitor', commercial_price: '120.000', caleb: '80000', address: 'La Villa - Pereira', id: 16, image: 'https://img.freepik.com/psd-gratis/imagen-tridimensional-computadora_53876-1608.jpg?t=st=1713530626~exp=1713534226~hmac=02ca0f1ab05e33183e9917946d1feaf382509bb46626efd4d8f0a1bfa0ab91cc&w=900' },
                { company: 'Luis Arcila', service: 'Finanzas Personales', commercial_price: '2.000.000', caleb: '1800000', address: 'La Villa - Pereira', id: 17 },
                { company: 'Luz María Martínez', service: 'Enfermería', commercial_price: '100.000', caleb: '80000', address: 'La Villa - Pereira', id: 18 }
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