<script lang="ts">
import { useProductsStore } from '@/stores/products';
import { mapActions, mapState } from 'pinia';

export default {
    methods: {
        ...mapActions(useProductsStore, ['orderByName', 'orderByPrice'])
    },
    computed: {
        ...mapState(useProductsStore, ['order'])
    }
}
</script>

<template>
    <v-list-subheader>Orden</v-list-subheader>
    <v-list-item
    color="grey-lighten-4"
    title="Por precio"
    link
    @click="orderByPrice"
    :active="order === 'price'"
    ></v-list-item>

    <v-list-item
    color="grey-lighten-4"
    title="Por nombre"
    link
    @click="orderByName"
    :active="order === 'name'"
    ></v-list-item>
</template>