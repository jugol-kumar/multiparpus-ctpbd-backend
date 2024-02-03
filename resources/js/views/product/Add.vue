<template>
    <div>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Add New Product</h3>
            </div>
            <div class="card-body">
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
                            <v-select v-model="brandId"
                                      class="form-control"
                                      :reduce="brand => brand.id" :options="brands"
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
                        <SummernoteEditor v-model="details"/>
                    </div>
                    <button class="btn btn-primary" type="submit">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import SummernoteEditor from 'vue3-summernote-editor';
import TreeCategory from "@/components/TreeCategory.vue";
import ComponentLoader from "@/components/ComponentLoader.vue";

export default {
    name: "Add",
    components:{
        ComponentLoader,
        SummernoteEditor,
        TreeCategory,
    },
    data(){
        return{
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
        saveProductDetails(){
            this.loading = true
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
                })
                .catch(err => {
                    console.log(err)
                })
                .finally(() => this.loading = false);
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
        this.allBrands();
    }
}
</script>

<style scoped>
.deleteImage{
    position: relative;
    top: -41px;
    left: -31px;
    width: 20px;
    height: 20px;
    background: #00000014;
    display: inline-block;
    color: #efcdcd;
    border-radius: 15px;
    border: none;
    padding: 2px 6px;
    transition: 0.3s all ease;
    cursor:pointer;
}
.deleteImage:hover{
    background: #000;
}


#noShow {
    display: none;
}

.inputFileButton{
    border: 1px solid #ccc;
    display: inline-block;
    padding: 9px 12px;
    cursor: pointer;
    margin-top: 19px;
}
</style>




