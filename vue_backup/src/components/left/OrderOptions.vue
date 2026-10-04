<script lang="ts">
import { useProductsStore } from '@/stores/products';
import { mapActions, mapState } from 'pinia';

export default {
    methods: {
        ...mapActions(useProductsStore, [
            'orderByPrice', 'orderByPriceDesc',
            'orderByName', 'orderByNameDesc' 
    ])
    },
    computed: {
        ...mapState(useProductsStore, ['order'])
    }
}
</script>

<template>
    <v-list-subheader>Ordenar por</v-list-subheader>
    <v-list-item
    color="grey-lighten-4"
    title="Más económico"
    link
    @click="orderByPrice"
    :active="order === 'price'"
    ></v-list-item>

    <v-list-item
    color="grey-lighten-4"
    title="Más costoso"
    link
    @click="orderByPriceDesc"
    :active="order === 'priceDesc'"
    ></v-list-item>

    <v-list-item
    color="grey-lighten-4"
    title="Nombre (A-Z)"
    link
    @click="orderByName"
    :active="order === 'name'"
    ></v-list-item>

    <v-list-item
    color="grey-lighten-4"
    title="Nombre (Z-A)"
    link
    @click="orderByNameDesc"
    :active="order === 'nameDesc'"
    ></v-list-item>
</template>