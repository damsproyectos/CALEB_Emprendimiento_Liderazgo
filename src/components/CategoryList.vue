<script lang="ts">
// import type { Category } from '@/model/types';
import type { Category } from '../model/types';

export default {
    data() {
        return {
            categories: [{
                id: 1,
                name: 'Bellesalud'
            }, {
                id: 2,
                name: 'Servicios'
            }, {
                id: 3,
                name: 'Productos'
            }, {
                id: 4,
                name: 'Comidas'
            }] as Category[]
        }; 
    }
}
</script>

<template>
    <v-sheet rounded="lg">
        <v-list rounded="lg">
            <v-list-item
            v-for="category in categories"
            :key="category.id"
            :title="`${category.name}`"
            link
            ></v-list-item>

            <v-divider class="my-2"></v-divider>

            <v-list-item
            color="grey-lighten-4"
            title="Ordenar por precio"
            link
            ></v-list-item>
        </v-list>
    </v-sheet>
</template>