export interface Product {
  id: number;
  name: string;
  price: number;
  description: string;
  category: string;
  image_url?: string;
}

export interface CartItem extends Product {
  quantity: number;
}
