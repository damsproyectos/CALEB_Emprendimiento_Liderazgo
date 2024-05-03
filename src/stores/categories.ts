// import type { Category } from '@/model/types';
import type { Category } from "@/model/types";
import { defineStore } from "pinia";

export const useCategoriesStore = defineStore('categories', {
    state: () => ({
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
    }),
    getters: {

    },
    actions: {

    },
})