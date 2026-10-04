export interface Product {
    company: string;
    service: string;
    commercial_price: number;
    caleb: number;
    address: string;
    id: number;
    image: string;
    categoryId: number;
}

export interface CartDetail {
    product: Product;
    quantity: number;
}

export interface Category {
    id: number;
    name: string;
    description: string;
}