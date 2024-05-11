// import type { Category } from '@/model/types';
import type { Category } from "@/model/types";
import { defineStore } from "pinia";
// import categoriesData from '../data/categories.json';

// console.log(categoriesData); //Agregamos un console.log para verificar cual es el contenido de categoriesData; para ver si realmente estamos leyendo bien los datos del archivo categories.json, osea que vemos los datos en la consola; eso significa que el import al store categories.ts es ÉXITOSO.  

export const useCategoriesStore = defineStore('categories', {
    state: () => ({
        // categories: categoriesData as Category[]
        categories: [] as Category[],
        loading: true
    }),
    getters: {

    },
    actions: {
        fetchCategories() {
            fetch('/data/categories.json')
                .then(response => response.json())
                .then((data) => {
                    // console.log(data);
                    this.categories = data;
                    this.loading = false;
                });
        },
    }
})