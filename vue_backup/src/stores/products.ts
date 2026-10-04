import { defineStore } from 'pinia'
import type { Product } from '@/model/types'
// import productsData from '../data/products.json';

// console.log(productsData); //Agregamos un console.log(productsData);para verificar cual es el contenido de productsData; para ver si realmente estamos leyendo bien los datos del archivo products.json, osea que vemos los datos en la consola; eso signifca que el import al store products.ts es ÉXITOSO 

export const useProductsStore = defineStore('products', {
    state: () => ({
        order: 'price' as string,
        categoryId: null as number|null,
        // _products: productsData as Product[]
        _products: [] as Product[],
        loading: true
    }),
    getters: {
        products(state) {
            let products = null;

            //Filter
            if (state.categoryId) {
                products = state._products
                    .filter(p => p.categoryId === state.categoryId);
            } else {
                products = state._products;
            }       
            
            //Order
            if (state.order === '') {
                return products;
            }

            if (state.order === 'price') {
                return products.sort((a,b) => a.caleb - b.caleb);
            }

            if (state.order === 'priceDesc') {
                return products.sort((a,b) => b.caleb - a.caleb);
            }

            if (state.order === 'name') {
                return products.sort((a,b) => a.service.localeCompare(b.service));
            }

            if (state.order === 'nameDesc') {
                return products.sort((a,b) => b.service.localeCompare(a.service));
            }

        }
    },
    actions: {
        fetchProducts() {
            fetch('/data/products.json')
                .then(response => response.json())
                .then((data) => {
                    // console.log(data);
                    this._products = data;
                    this.loading = false;
                });
        },
        selectCategory(categoryId: number) {
            this.categoryId = categoryId;
        },
        orderByPrice() {
            this.order = 'price';
        },
        orderByPriceDesc() {
            this.order = 'priceDesc';
        },
        orderByName() {
            this.order = 'name';
        },
        orderByNameDesc() {
            this.order = 'nameDesc';
        }
    }
})