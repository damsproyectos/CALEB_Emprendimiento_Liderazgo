<script lang="ts">
export default {
    data() {
        return {
            count: 0
        };
    },
    methods: {
        increase() {
            this.count += 1; // this.count = this.count + 1;
        },
        decrease() {
            this.count -= 1; // this.count = this.count - 1;
        }
    },
    mounted() {
        console.log('El Valor inicial del contador es ' + this.count);
    },
}
</script>

<template>
    <p>Objetivo: Tienes que llegar a 20 clicks</p>

    <h1>Contador: {{ count }}</h1>
    
    <button @click="increase">
        Aumentar Contador
    </button>
    
    <p v-if="count <= 10">¡¡Vamos tú puedes!!</p>
    <p v-else>Ya te falta muy poco.....</p><hr/>
    
    <button @click="decrease">
        Disminuir Contador
    </button>
</template>