<template>
    <div>
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h3 class="card-label">Stoke Management
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable" id="">
                    <thead>
                        <tr>
                            <th>Record ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <!-- <th>Supplier</th> -->
                            <th>Stoke Status</th>
                            <th>Unit price</th>
                            <th>Courrent Stoke</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tr v-for="(product, i) in products?.data" :key="`stoke-${i}`">
                        <td>#_{{ i + 1 }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <h5 class="fw-bold">{{ product?.product?.title }}-{{ product?.varient?.replace(/\//g, '-')?.slice(0, -1)  }}</h5>
                                <small class="fs-6">Sku: {{ product?.sku }}</small>
                            </div>
                        </td>
                        <td>{{ product?.product?.category?.name }}</td>
                        <!-- <td>{{ product?.supplier?.name ?? '......' }}</td> -->
                        <td>
                            <span class="badge badge-success bg-success fw-bold text-white" v-if=" product.qty > 0">Available In Stoke</span>
                            <span class="badge badge-danger bg-danger fw-bold text-white" v-else>Out Of Stoke</span>
                        </td>
                        <td>{{ product?.price }} $</td>
                        <td>{{ product.qty }}</td>
                        <td>
                            <button @click="editStoke(product)"
                                class="btn btn-sm btn-clean btn-icon" title="Edit details">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1" />
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tbody>
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card">
                    <div class="card-body">
                        <h4 class="fw-bold">Product: {{ stokeInfo?.product?.title }}</h4>
                        <h6 class="fw-bold">Varient: {{ stokeInfo?.varient?.replace(/\//g, '-')?.slice(0, -1)  }}</h6>
                        <h6 class="fw-bold">Sku: {{ stokeInfo?.sku }}</h6>
                        <h6 class="fw-bold">Unit Price: {{ stokeInfo?.price  }} $</h6>

                        <h6 class="fw-bolder">Current Stoke: <span class="badge bg-primary">{{  stokeInfo.qty }}</span></h6>
                        <hr class="border broder-1">
                        
                        <div>
                            <label for="qty">Add Stoke Quantity</label>
                            <input v-model="qty" class="form-control" placeholder="e.g Add more 500 pc"/>
                        </div>

                        <button class="btn btn-primary ms-auto mt-3" @click="updateStoke">
                            Add To Stoke
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>
import { onMounted, ref } from "vue";
import useApi from "@/composables/useApi.js"
const user = User.userInfo();

const products = ref([]);
const {sendRequest}= useApi();
const stokeInfo = ref({})
const qty = ref(null)

const editStoke = (info)=>{
    $('#exampleModal').modal('show');
    stokeInfo.value = info;
}

const updateStoke = async () =>{
    const data = await sendRequest({
        method: 'put',
        data:{
            qty: qty.value
        },
        url: `/api/admin/update-stokes/${stokeInfo.value?.id}`,
        headers: {
            "Authorization": `Bearer ${user?.token}`
        }
    })

    if(data?.message){
        await getAllStokes();
        $('#exampleModal').modal('hide');
        Toast.fire({
            icon: 'success',
            title: data?.message
        });
    }
    console.log(data)

}

const getAllStokes =async () =>{
    const data = await sendRequest({
        method: 'get',
        url: `/api/admin/product-stokes`,
        headers: {
            "Authorization": `Bearer ${user?.token}`
        }
    })
    products.value = data;
}

onMounted(async () => {
    await getAllStokes();
})
</script>

<style scoped></style>
