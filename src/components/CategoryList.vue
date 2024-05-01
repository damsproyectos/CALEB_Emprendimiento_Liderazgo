<script lang="ts">
import { mapActions } from 'pinia';
// import type { Category } from '@/model/types';
import type { Category } from '../model/types';
import { useProductsStore } from '../stores/products'

export default {
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
        ...mapActions(useProductsStore, ['orderByName', 'orderByPrice'])
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

            <v-list-subheader>Orden</v-list-subheader>
            <v-list-item
            color="grey-lighten-4"
            title="Por precio"
            link
            @click="orderByPrice"
            ></v-list-item>

            <v-list-item
            color="grey-lighten-4"
            title="Por nombre"
            link
            @click="orderByName"
            ></v-list-item>
        </v-list>
    </v-sheet>
</template>