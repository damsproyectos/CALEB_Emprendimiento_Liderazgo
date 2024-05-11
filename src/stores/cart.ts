import { defineStore } from 'pinia'
import type { CartDetail, Product } from '@/model/types';
import { useLocalStorage } from '@vueuse/core';  //useLocalStorage me permite mantener la información o productos agregados, en el carrito de compras, apesar de que cierre o se reinicie la página.

export const useCartStore = defineStore('cart', {
  state: () => ({ 
    // details: [] as CartDetail[]
    details: useLocalStorage<CartDetail[]>('CartDetails', []) 
   }),
  getters: {
    //doubleCount: (state) => state.count * 2,
    cartItemsCount: (state) => {
      let count = 0;
      state.details.forEach(detail => {
        count += detail.quantity;
      });
      return count;
    },
    totalAmount: (state) => {
      let  total = 0;

      state.details.forEach(d => {
        total += d.product.caleb * d.quantity;
      }); 

      return total;
    },
    whatsAppMessage(state) {
      let message = 'Hola, quiero realizar la siguiente compra:\n\n';

      state.details.forEach(d => {
        message += `--------------------------------------------------\n`;
        message += `Producto: ${d.product.service}\n`;
        message += `Cantidad: ${d.quantity}\n`;
        message += `Subtotal: $${d.quantity * d.product.caleb}\n`;
        message += `--------------------------------------------------\n\n`;
      });

      message += `Total a pagar: $${this.totalAmount}\n\n`;
      message += `¡Muchas gracias! 😃🖥️😊`

      return encodeURI(message);
    },
    whatsAppLink() {
      // return 'https://wa.me/573146494446?text=' + this.whatsAppMessage;
      return 'https://api.whatsapp.com/send/?phone=573146494446&text=' + this.whatsAppMessage;
    }
  },
  actions: {
    addProduct(product: Product) {
     // console.log('Agregar producto' + productId);
     const detailFound = this.details.find(d => d.product.id === product.id);

     // console.log(detailFound);
     if (detailFound) {
         //+1
         detailFound.quantity += 1;
     } else {
         this.details.push({
             product,
             quantity: 1 
         });   
     }
    },
    deleteProduct(productId: number) {
      const index = this.details.findIndex(d => d.product.id == productId);
      this.details.splice(index, 1);
    },
    increment(productId: number) {
      const detailFound = this.details.find(d => d.product.id === productId);

      if (detailFound) {
        detailFound.quantity += 1;
      }
    },
    decrement(productId: number) {
      const detailFound = this.details.find(d => d.product.id === productId);

      if (detailFound) {
        detailFound.quantity -= 1;

        if (detailFound.quantity === 0) {
          this.deleteProduct(productId);
        }
      }
    }
  },
})
