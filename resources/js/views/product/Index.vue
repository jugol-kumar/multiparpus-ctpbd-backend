<template lang="html">
    <div>
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h3 class="card-label">All Products
                        <span class="d-block text-muted pt-2 font-size-sm">all product details is here </span></h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <button type="button" class="btn btn-primary font-weight-bolder"  data-toggle="modal"  data-target="#exampleModalLong">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        New Record
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-borderless" id="">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <td>Info</td>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, i) in products">
                        <td>{{ i + 1 }}</td>
                        <td>
                            <div>
                                <h6 class="fw-bold text-capitalize">{{ product.title }}</h6>
                                <div class="d-flex flex-column gap-1">
                                    <small>Stoke: {{ product.stock }}</small>
                                    <small>Price: {{ product.buying_price }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                           <img :src="`${product?.images[0]?.url}`" alt="" style="width:73px;height:70px;border-radius: 50px;"/>
                        </td>
                        <td>
                            <span class="text-capitalize">
                                {{ product.category?.name }}
                            </span>
                        </td>
                        <td>
                            <span class="text-capitalize">{{ product.brand?.title }}</span>
                        </td>
                        <td>
                            <span class="badge badge-warning text-white text-capitalize">{{ product.status }}</span>
                        </td>
                        <td>
                            <router-link :to="{name:'ModifyProduct', params:{id:product.id}}" class="btn btn-clean btn-primary" title="Edit details">
                                Setup Product
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <div class="modal fade" id="exampleModalLong"
             data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex gap-3">
                            <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-primary" @click="saveProductDetails">Save</button>
                                <button class="btn btn-sm btn-danger" ref="Close" data-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                        <button type="button" class="close" ref="Close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveProductDetails">
                            <div class="form-row">
                                <div class="col-md-4 form-group"> 
                                    <label for="productname">Product Name</label>
                                    <input type="text"
                                           id="productname"
                                           v-model="productName"
                                           placeholder="Product Name"
                                           class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="dPrice">Default Price</label>
                                    <input type="text"
                                           id="dPrice"
                                           v-model="defaultPrice"
                                           placeholder="Default Price."
                                           class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="defaultStoke">Default Quantity</label>
                                    <input type="text"
                                           id="defaultStoke"
                                           v-model="defaultStoke"
                                           placeholder="Default Quantity..."
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label>Category</label>
                                    <TreeCategory v-model="categoryId"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Brand</label>
                                    <v-select v-model="brandId" :reduce="brand => brand.id" :options="brands"
                                              label="title" placeholder="Select Brand..."/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea v-model="description"
                                          id="description" cols="30" rows="4"
                                          class="form-control"></textarea>
                            </div>


                            <div class="form-group">
                                <label>Full Details</label>
                               <Editor v-model="details" height="400px" isMultiline/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Editor from "@/components/Editor.vue";
import TreeCategory from "@/components/TreeCategory.vue";

export default {
    name: "Index",
    components:{
        Editor,
        TreeCategory,
    },
    data() {
        return {
            products: [],
            product: {},
            brands: [],

            // add product information.
            productName: null,
            defaultPrice: null,
            defaultStoke: null,
            description: null,
            details: null,
            categoryId: null,
            brandId: null,

        }
    },
    methods: {
        allProducts() {
            this.$axios.get('api/product-with-variations')
                .then(res => {
                    this.products = res.data
                })
                .catch(err => {
                    err.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: err.response.statusText
                    })
                })
        },
        showSingleProduct(id) {


            this.$axios.get('/api/product/' + id)
                .then(res => {
                    $('#exampleModal').modal('show')
                    this.product = res.data;
                })
                .catch(err => {
                    Toast.fire({
                        icon: 'error',
                        title: err.response.statusText
                    })
                })

        },
        deleteProduct(id) {
            Swal.fire({
                title: 'Are You Sure!',
                text: 'you watnt to delete this?',
                icon: 'warning',
                confirmButtonColor: '#ddd',
                cancelButtonColor: 'red',
                confirmButtonText: 'Delete',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    this.$axios.delete('/api/product/' + id)
                        .then(res => {
                            Toast.fire({
                                icon: 'success',
                                title: res.data.message
                            })
                            this.allProducts();
                        })
                        .catch(err => {
                            Toast.fire({
                                icon: 'error',
                                title: err.response.statusText
                            })
                        })
                }
            }).catch(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'dont worry. your data is safe...'
                })
                this.$router.push({name: 'ManageEmployee'});
            })
        },


        saveProductDetails(){
            const formData = new FormData();
            formData.append(`name`, this.productName);
            formData.append(`defaultPrice`, this.defaultPrice);
            formData.append(`defaultQty`, this.defaultStoke);
            formData.append(`categoryId`, this.categoryId);
            formData.append(`brandId`, this.brandId);
            formData.append(`description`, this.description);
            formData.append(`details`, this.details);
            formData.append(`stock`,  this.defaultStoke);
            this.$axios.post('api/save-product-details', formData)
            .then(res => {
                Toast.fire({
                    icon: 'success',
                    title: res.data.message
                })
                this.$refs.Close.click();
                this.allProducts();
            })
            .catch(err => {
                console.log(err)
            })
        },


        // get all variations
        allBrands() {
            this.$axios.get('api/brand', this.from)
            .then(res => {
                this.brands = res.data
            })
            .catch(err => {
                this.errors = err.response.data.errors;
                Toast.fire({
                    icon: 'warning',
                    title: err.response.data.message
                });
            })
        },
    },
    created() {
        this.allProducts();
        this.allBrands();
    }
}
</script>

<style scoped>

</style>
