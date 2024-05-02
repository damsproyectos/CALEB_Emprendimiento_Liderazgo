<script lang="ts">
// import type { Category } from '@/model/types';
import type { Category } from '../model/types';
import OrderOptions from './left/OrderOptions.vue';

export default {
    components: {
        OrderOptions
    },
    data() {
        return {
            categories: [
                {
                    id: 1,
                    name: 'Bellesalud',
                    description: 'Belleza y salud'
                }, 
                {
                    id: 2,
                    name: 'Servicios',
                    description: 'Servicios generales'
                }, 
                {
                    id: 3,
                    name: 'Productos',
                    description: 'Productos varios'
                }, 
                {
                    id: 4,
                    name: 'Comidas',
                    description: 'Restaurantes, comidas rápidas'
                }
            ] as Category[]
        }; 
    },
    methods: {
        clearCategory() {
            this.$router.push({
                name: 'home'
            });
        },
        goToCategory(categoryId: number) {
            this.$router.push({
                name: 'category', 
                params: { categoryId }
            })
        },
    }
}
</script>

<template>
    <v-sheet rounded="lg">
        <v-list rounded="lg">
            <v-list-subheader>Categorías</v-list-subheader>
            <v-list-item
            title="Todas"
            link 
            @click="clearCategory()"
            :active="$route.name === 'home'"
            ></v-list-item>

            <v-list-item 
            :active="$route.name === 'category' && Number($route.params.categoryId) === category.id"
            v-for="category in categories"
            :key="category.id"
            :title="`${category.name}`"
            link
            @click="goToCategory(category.id)"
            ></v-list-item>

            <v-divider class="my-2"></v-divider>

            <OrderOptions />
        </v-list>
    </v-sheet>
</template>