export interface Product {
    company: string;
    service: string;
    commercial_price: number;
    caleb: number;
    address: string;
    id: number;
}

export interface CartDetail {
    productId: number;
    quantity: number;
}

export interface Category {
    id: number;
    name: string;
}