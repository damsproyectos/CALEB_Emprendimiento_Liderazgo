import { defineStore } from 'pinia'
import type { Product } from '@/model/types'

export const useProductsStore = defineStore('products', {
    state: () => ({
        order: '' as string,
        categoryId: null as number|null,
        _products: [
            { 
                company: 'Marilyn Ortiz', 
                image: 'https://img.freepik.com/foto-gratis/mujer-visitando-cosmetologa-realizando-procedimientos-rejuvenecimiento_1303-26040.jpg?w=900&t=st=1713478321~exp=1713478921~hmac=4f54a059e9141747b58e4ad4e7960c71bf05379dbf87ae423fd3003af1784306', 
                service: 'Limpieza facial profunda', 
                commercial_price: 100000, 
                caleb: 80000, 
                address: 'La Villa - Pereira', 
                id: 1,
                categoryId: 1                    
            },
            { 
                company: 'Movi&Fisio Integral', 
                image: 'https://img.freepik.com/foto-gratis/mujer-que-tiene-sesion-fisioterapia_23-2149115642.jpg?t=st=1713478744~exp=1713482344~hmac=97f57e0e43b1b779b5e2e94b45cde99b689bf0e7de726be718948181dd2cbd0b&w=900',
                service: 'Valoración + 6 terapias', 
                commercial_price: 270000, 
                caleb: 180000, 
                address: 'La Villa - Pereira', 
                id: 2,
                categoryId: 1 
            },
            { 
                company: 'Jeferson Zambrano P',                    
                image: 'https://img.freepik.com/foto-gratis/mujer-sonriente-silla-dentista_1153-655.jpg?t=st=1713478956~exp=1713482556~hmac=e7e227b97132cae874c8691cc0aac5e7370930b1096596ed5017b0af2707a807&w=900', 
                service: 'Limpieza Dental', 
                commercial_price: 80000, 
                caleb: 60000, 
                address: 'La Villa - Pereira', 
                id: 3,
                categoryId: 1

            },
            { 
                company: 'Dra. Premauer', 
                image: 'https://img.freepik.com/foto-gratis/concienciacion-sobre-dia-mundial-cancer-paciente_23-2151249750.jpg?t=st=1713479278~exp=1713482878~hmac=2fbcaf8d4a4c16d65720442c0d8dd299c7ff9b6f0840bb74c1bc283d54ec5bb4&w=900',
                service: 'Prevención Cancer', 
                commercial_price: 50000, 
                caleb: 45000, 
                address: 'Cuba - Pereira', 
                id: 4,
                categoryId: 1 
            },
            { 
                company: 'muebles BL',
                image: 'https://img.freepik.com/psd-gratis/silla-almohada_176382-873.jpg?t=st=1713530442~exp=1713534042~hmac=44c0b1ec80bf9ac8ce471b4dc48508e71b92ff1dca4f0d5d4db9129b77849e77&w=740', 
                service: 'silla', 
                commercial_price: 56000, 
                caleb: 40000, 
                address: 'Cra 17 A # 83B- 59 La Villa - Pereira', 
                id: 5,
                categoryId: 3 
            },    
            {
                 company: 'Tecnology', 
                 image: 'https://img.freepik.com/psd-gratis/imagen-tridimensional-computadora_53876-1608.jpg?t=st=1713530626~exp=1713534226~hmac=02ca0f1ab05e33183e9917946d1feaf382509bb46626efd4d8f0a1bfa0ab91cc&w=900',
                 service: 'Monitor', 
                 commercial_price: 450000, 
                 caleb: 400000, 
                 address: 'La Villa - Pereira', 
                 id: 6, 
                 categoryId: 3
            },                
            { 
                company: 'Bike Store', 
                image: '/img/bike.jpeg',
                service: 'Alistamiento de Bicicleta', 
                commercial_price: 120000, 
                caleb: 80000, 
                address: 'La Villa - Pereira', 
                id: 7,
                categoryId: 2
            },
            { 
                company: 'Luis Arcila', 
                image: '/img/finanzas.webp',
                service: 'Finanzas Personales', 
                commercial_price: 2000000, 
                caleb: 1800000, 
                address: 'La Villa - Pereira', 
                id: 8,
                categoryId: 2
            },
            { 
                company: 'Luz María Martínez', 
                image: '/bellesalud/enfermeria.webp',
                service: 'Enfermería', 
                commercial_price: 100000, 
                caleb: 80000, 
                address: 'La Villa - Pereira', 
                id: 9,
                categoryId: 1                    
            },
            { 
                company: 'Marilyn Ortiz',                     
                image: '/bellesalud/marilyn.jpeg',
                service: 'Limpieza facial profunda', 
                commercial_price: 100000, 
                caleb: 80000, address: 'La Villa - Pereira', 
                id: 10,
                categoryId: 1 
            },
            { 
                company: 'Movi&Fisio Integral', 
                image: '/bellesalud/movifisio.jpeg',
                service: 'Valoración + 6 terapias', 
                commercial_price: 270000, 
                caleb: 80000, 
                address: 'La Villa - Pereira', 
                id: 11,
                categoryId: 1 
            },
            { 
                company: 'Jeferson Zambrano P',
                image: '/bellesalud/odontologia.jpeg', 
                service: 'Limpieza Dental', 
                commercial_price: 80000, 
                caleb: 60000, 
                address: 'La Villa - Pereira', 
                id: 12,
                categoryId: 1 
            },
            { 
                company: 'Dra. Premauer', 
                service: 'Prevención Cancer', 
                commercial_price: 50000, 
                caleb: 45000, 
                address: 'Cuba - Pereira', 
                id: 13,
                categoryId: 1
            },
            { 
                company: 'muebles BL', 
                service: 'silla', 
                commercial_price: 56000, 
                caleb: 40000, 
                address: 'Cra 17 A # 83B- 59 La Villa - Pereira', 
                id: 14,
                categoryId: 3 
            },    
            { 
                company: 'Tecnology', 
                image: 'https://img.freepik.com/vector-gratis/microfono-metalico-realista-cantar_52683-10360.jpg?t=st=1713534522~exp=1713538122~hmac=647dc39af1844e0be7d60520a2a20ba225b0e45525b213bcb79036f9c7e37244&w=740',
                service: 'Microfono', 
                commercial_price: 450000, 
                caleb: 400000, 
                address: 'La Villa - Pereira', 
                id:15,
                categoryId: 3 
            },
            { 
                company: 'Tecnology', 
                image: 'https://img.freepik.com/psd-gratis/imagen-tridimensional-computadora_53876-1608.jpg?t=st=1713530626~exp=1713534226~hmac=02ca0f1ab05e33183e9917946d1feaf382509bb46626efd4d8f0a1bfa0ab91cc&w=900',
                service: 'Monitor', 
                commercial_price: 120000, 
                caleb: 80000, 
                address: 'La Villa - Pereira', 
                id: 16,
                categoryId: 3 
            },
            { 
                company: 'Luis Arcila', 
                service: 'Finanzas Personales', 
                commercial_price: 2000000, 
                caleb: 1800000, 
                address: 'La Villa - Pereira', 
                id: 17,
                categoryId: 2
            },
            { 
                company: 'Luz María Martínez', 
                service: 'Enfermería', 
                commercial_price: 100000, 
                caleb: '80000', 
                address: 'La Villa - Pereira', 
                id: 18,
                categoryId: 1 
            },
            { 
                company: 'Innovación', 
                image: '/productos/headphones.jpg',
                service: 'Audífonos', 
                commercial_price: 100000, 
                caleb: '80000', 
                address: 'La Villa - Pereira', 
                id: 19,
                categoryId: 3 
            },
            { 
                company: 'Innovación', 
                image: '/productos/microfono.jpg',
                service: 'Microfono', 
                commercial_price: 100000, 
                caleb: '80000', 
                address: 'La Villa - Pereira', 
                id: 20,
                categoryId: 3 
            },                
            { 
                company: 'Innovación', 
                image: '/productos/monitor.jpg',
                service: 'Monitor', 
                commercial_price: 100000, 
                caleb: '80000', 
                address: 'La Villa - Pereira', 
                id: 21,
                categoryId: 3 
            },                
            { 
                company: 'Innovación', 
                image: '/productos/mouse.jpg',
                service: 'Mouse Gamer', 
                commercial_price: 100000, 
                caleb: '80000', 
                address: 'La Villa - Pereira', 
                id: 22,
                categoryId: 3 
            },                      
            { 
                company: 'Innovación', 
                image: '/productos/parlantes.jpg',
                service: 'Parlantes', 
                commercial_price: 100000, 
                caleb: '80000', 
                address: 'La Villa - Pereira', 
                id: 23,
                categoryId: 3
            },
            { 
                company: 'Innovación', 
                image: '/productos/silla.webp',
                service: 'Silla comedor', 
                commercial_price: 95000, 
                caleb: '70000', 
                address: 'La Villa - Pereira', 
                id: 24,
                categoryId: 3
            },
            { 
                company: 'RiKo Pollo', 
                image: '/comidas/comidas.jpg',
                service: 'Pollo entero', 
                commercial_price: 30000, 
                caleb: '25000', 
                address: 'La Villa - Pereira', 
                id: 25,
                categoryId: 4
            },
            { 
                company: 'Don Tamalon', 
                image: '/comidas/comidas1.jpg',
                service: 'Tamales', 
                commercial_price: 15000, 
                caleb: '12000', 
                address: 'La Villa - Pereira', 
                id: 26,
                categoryId: 4
            },
            { 
                company: 'KokorisPollo', 
                // image: '/productos/comidas.jpg',
                service: 'Pollo entero', 
                commercial_price: 30000, 
                caleb: '25000', 
                address: 'La Villa - Pereira', 
                id: 27,
                categoryId: 4
            },
            { 
                company: 'KokorisPollo', 
                image: 'https://img.freepik.com/foto-gratis/mujer-visitando-cosmetologa-realizando-procedimientos-rejuvenecimiento_1303-26040.jpg?w=900&t=st=1713478321~exp=1713478921~hmac=4f54a059e9141747b58e4ad4e7960c71bf05379dbf87ae423fd3003af1784306',
                service: 'Burritos mexicanos', 
                commercial_price: 30000, 
                caleb: '25000', 
                address: 'La Villa - Pereira', 
                id: 28,
                categoryId: 4
            }
        ] as Product[]
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

            if (state.order === 'name') {
                return products.sort((a,b) => a.company.localeCompare(b.company));
            }

        }
    },
    actions: {
        selectCategory(categoryId: number) {
            this.categoryId = categoryId;
        },
        orderByPrice() {
            this.order = 'price';
        },
        orderByName() {
            this.order = 'name';
        }
    }
})