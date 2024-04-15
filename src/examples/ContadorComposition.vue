<script setup lang="ts">
    import { onMounted, ref } from 'vue'

    const count = ref(0);

    function aumentar() {
        count.value += 1;
    } 

    // onMounted(function () {
    //    console.log('El valor inicial del contador es  ' + count.value); 
    // });

    onMounted(() => {
        console.log('El valor inicial del contador es      ' + count.value);
    });
</script>

<template>
    <p>Hola soy la versión con Composition API</p>
    <h1>Contador: {{ count }}</h1>

    <!-- <button @click="count = count + 1">
        Incrementar contador
    </button> -->

    <button @click="aumentar">
        Incrementar contador
    </button>
</template>