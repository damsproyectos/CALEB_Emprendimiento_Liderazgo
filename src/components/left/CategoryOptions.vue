<script lang="ts">
import { mapState } from 'pinia';
//import { useCategoriesStore } from '@/../stores/categories'
import { useCategoriesStore } from '../../stores/categories'

export default {
    computed: {
        ...mapState(useCategoriesStore, ['categories'])
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
        }
    }
}
</script>

<template>
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
</template>