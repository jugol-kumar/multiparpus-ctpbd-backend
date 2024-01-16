<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Product Carts
                                <span class="d-block text-muted pt-2 font-size-sm">all employees details is here</span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <router-link :to="{name:'AddEmployee'}" href="#" class="btn btn-default font-weight-bolder btn-sm">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                        <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                    </g>
                                </svg>
                            </span>
                            </router-link>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body pos-card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="">
                            <thead class="pos-t-head">
                            <tr>
                                <!-- <th style="width:1%">#_ID</th> -->
                                <th style="width: 30%">Title</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(product, i) in cart.getAllItems()" :key="`card-product-${i}`">
                                <!-- <td>{{ i+1 }}</td> -->
                                <td><a href="#" @click="showSingleProduct(product.id)">{{ product?.product?.title?.slice(0, 10) }}...</a></td>
                                <td>{{ product.buyQty }}
                                    <a href="javascript:;" @click="quentityIncrement(product.id)" class="btn btn-sm btn-clean btn-icon" title="Delete">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                    <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <a href="javascript:;" @click="quentityDecrement(product.id)" class="btn btn-sm btn-clean btn-icon" title="Delete">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                    <rect fill="#000000" x="6" y="11" width="12" height="2" rx="1"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                </td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.price * product?.buyQty }}</td>
                                <td>
                                    <a href="javascript:;" @click="deleteCartProduct(product.id)" class="btn btn-sm btn-clean btn-icon" title="Delete">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-custom mt-5">
                    <div class="card-body">
                        <form @submit.prevent="saveOrder()">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <select class="form-control form-control-solid" v-model="order.customer">
                                    <option disabled="true" selected>~~Select Customer ~~</option>
                                    <option  v-for="(customer, i) in employes" :value="customer.id" :key="`cm-${i}`">{{ customer.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pay</label>
                                <input type="text" class="form-control form-control-solid" v-model="order.payBill" @keyup="payBillCheck()" placeholder="Enter employee name..."/>
                            </div>
                            <div class="form-group">
                                <label>Due</label>
                                <input type="text" class="form-control form-control-solid" v-model="order.totalDue" disabled="true" placeholder="Enter employee name..."/>
                            </div>

                            <div class="form-group">
                                <label>Pay By</label>
                                <select class="form-control form-control-solid" v-model="order.payby">
                                    <option disabled="true" selected>~~ Select Payment Method~~</option>
                                    <option value="han_cash">Han Cash</option>
                                    <option value="bikash">Bikash</option>
                                    <option value="rocket">Rocket</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="bank_check">Bank Check</option>
                                </select>
                            </div>
                        </form>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">All Products
                                <span class="d-block text-muted pt-2 font-size-sm">all products with product details</span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="text" v-model="filterBox" class="form-control form-control-solid mb-3" placeholder="Product Search Form Here">
                        <div class="example-preview">
                            <TreeCategory v-model="selectCategory" @update:modelValue="changeData"/>
                            <div class="tab-content mt-5" id="myTabContent1">
                                <div class="tab-pane fade show active" id="home-1" role="tabpanel" aria-labelledby="home-tab-1">
                                    <div class="row match-height px-1">
                                        <div class="col-md-4 mt-2 px-1" v-for="(product, i) in filteredProducts"
                                         @dblclick="addToCart(product)" 
                                         @click="showProductDetails(product)"
                                         :key="`pos-s-roduct-${i}`">
                                            <router-link to="" class="card">
                                                <div class="card-body p-0 d-flex flex-column justify-content-between">
                                                    <div class="card-image">
                                                        <img :src="`${ product?.product?.images[0]?.url}`" />
                                                    </div>
                                                    <div class="card-heading">
                                                        {{ product?.product?.title?.slice(0, 10) }} - {{ product.varient?.replace(/\//g, '-')?.slice(0, -1) }}...
                                                    </div>
                                                    <div class="card-text">
                                                        {{ product?.price }} $
                                                    </div>
                                                    <a href="#" class="card-button" @click="doubleClick(product.id)"> Purchase</a>
                                                </div>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                                    <div class="row">
                                        <div class="col-md-4 mt-2" v-for="(product, i) in categoryProducts" 
                                        @dblclick="doubleClick(product.id)" 
                                        :key="`product-${i}`">
                                            <router-link to="">
                                                <div class="card-sl">
                                                    <div class="card-image">
                                                        <img :src="`${product.photo}`" />
                                                    </div>
                                                    <a class="card-action" href="#"><i class="fa fa-heart"></i></a>
                                                    <div class="card-heading">
                                                        {{ product.title }}
                                                    </div>
                                                    <div class="card-text">
                                                        $67,400
                                                    </div>
                                                    <a href="#" class="card-button" @click="doubleClick(product.id)"> Purchase</a>
                                                </div>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, watch, reactive, toRefs, computed } from 'vue';
    import TreeCategory from "@/components/TreeCategory.vue";
    import useApi from "@/composables/useApi.js";
    import useCart from "@/composables/useCart.js";

    const {sendRequest, loading, error} = useApi();
    const cart = useCart();

    let time = null;

    // Define reactive data
    const form = ref({
        name: '',
        position: '',
    });

    const order = ref({
        customer: '',
        totalDue: '',
        payby: '',
        payBill: '',
    });

    const employes = ref([]);
    const products = ref([]);
    const categories = ref([]);
    const categoryProducts = ref([]);
    const CartProducts = ref([]);
    const product = ref(null);
    const filterBox = ref(null);
    const selectCategory = ref(null)

    const filteredProducts = computed(() => {
        let filtered = products.value;

        if (filterBox.value) {
            filtered = filtered.filter(product => {
                return product?.product?.title?.toLowerCase().includes(filterBox.value);
            });
        }

        if (selectCategory.value) {
            filtered = filtered.filter(product => {
                return product?.product?.category?.id === selectCategory.value;
            });
        }
        return filtered;
    });

    // watch([filterBox, selectCategory], () => {
    //     console.log('Filter changed:', filterBox.value, selectCategory.value);
    // });





















    // Methods
    const allCustomer = () => {
        // Your implementation here
    };

    const allProducts = async () => {
        const loadProducts = await sendRequest("api/admin/pos-products")
        if(products){
            products.value = loadProducts
        }
    };

    const addToCart = (product) => {
        cart.addToCart({...product, buyQty:1});
    };

    const showProductDetails = (product) => {
        
    };

    const showSingleProduct = (id) => {
        // Your implementation here
    };

    const deleteCartProduct = (id) => {
        // Your implementation here
    };

    const quantityIncrement = (id) => {
        // Your implementation here
    };

    const quantityDecrement = (id) => {
        // Your implementation here
    };

    const payBillCheck = () => {
        // Your implementation here
    };

    const saveOrder = () => {
        // Your implementation here
    };

    const isLoggedin = () => {
        // Your implementation here
    };

    const singleClick = (id) => {
        // Your implementation here
    };

    const doubleClick = (id) => {
        // Your implementation here
    };

    const changeData = (event) => {
        console.log(event)
    };

    // Computed properties
    const totalQty = ref(0);
    const subTotal = ref(0);
    const grandTotal = ref(0);

    const filterProducts = () => {
        // Your implementation here
    };

    // Watchers
    watch(selectCategory, (item) => {
        console.log(item)
    });

    // Lifecycle hooks
    onMounted(() => {
        allProducts();
        cart.initCart();
    });

</script>


<style scoped>
/* Card Styles */

.card-sl {
    border-radius: 8px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.card-image img {
    max-height: 100%;
    max-width: 100%;
    border-radius: 8px 8px 0px 0;
    min-height:80px;
}

.card-action {
    position: relative;
    float: right;
    margin-top: -15px;
    margin-right: 3px;
    z-index: 2;
    color: #5cd2e2;
    background: #fff;
    border-radius: 100%;
    box-shadow: 0px 0px 4px -1px #868b7d66, 0px 0px 1px 0 #fdff90 inset;
    padding: 5px 5px;
    width: 25px;
    height: 25px;
}

.card-action:hover {
    color: #fff;
    background: #ffecc3;
    -webkit-animation: pulse 1.5s infinite;
}

.card-heading {
    font-size: 15px;
    font-weight: 500;
    background: #fff;
    padding: 0 10px;
}

.card-text {
    padding: 0px 10px;
    background: #fff;
    font-size: 14px;
    font-weight: bold;
    color: #636262;
}

.card-button {
    display: flex;
    justify-content: center;
    padding: 10px 0;
    width: 100%;
    background-color: #1F487E;
    color: #fff;
    border-radius: 0 0 8px 8px;
}

.card-button:hover {
    text-decoration: none;
    background-color: #1D3461;
    color: #fff;

}
.pos-card-body{
    max-height: 30rem;
    overflow-y: scroll;
    background: white;
}
.pos-card-body .pos-t-head{
    position: sticky;
    top: -30px;
    background: white;
}


@-webkit-keyframes pulse {
    0% {
        -moz-transform: scale(0.9);
        -ms-transform: scale(0.9);
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
    }

    70% {
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -webkit-transform: scale(1);
        transform: scale(1);
        box-shadow: 0 0 0 50px rgba(90, 153, 212, 0);
    }

    100% {
        -moz-transform: scale(0.9);
        -ms-transform: scale(0.9);
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
        box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
    }
}
</style>
