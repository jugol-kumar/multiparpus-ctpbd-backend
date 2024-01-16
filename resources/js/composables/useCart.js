import { ref, onMounted } from 'vue';


export default function useCart() {
    let cart = ref([]);


    const addToCart = async (product) => {
        const index = cart.value.findIndex(item => {
            return item?.id === product?.id
        });
        if (index > -1) {
            cart.value[index].buyQty++;
            Toast.fire({
                icon: 'success',
                title: "Quantity Updated..."
            })
        } else {
            cart.value.push(product);
            Toast.fire({
                icon: 'success',
                title: "Added To Pos..."
            })
        }
        await setInLocalStorage();
    }

    const initCart =()=>{
        const storedCart = localStorage.getItem('pos_cart');
        if (storedCart) {
            cart.value = JSON.parse(storedCart);
        }
    }

    const getAllItems =()=>{
        return cart.value;
    }

    
    const setInLocalStorage = async ()=>{
        localStorage.setItem('pos_cart', JSON.stringify(cart.value));
    }

    return {addToCart, initCart, getAllItems, cart}
}
