
<template>

    <v-select :options="flattenedCategories"
              v-model="modelValue"
              class="form-control"
              @update:modelValue="changeData"
              :reduce="cat => cat.id"
              label="fullName"
              placeholder="Select Category..."/>

<!--    <select v-model="selectedCategory">-->
<!--        <option v-for="category in flattenedCategories" :key="category.id" :value="category.id">-->
<!--            {{ getCategoryPrefix(category.level) }} {{ category.name }}-->
<!--        </option>-->
<!--    </select>-->
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import useAxios from '@/composables/useApi.js';

const props = defineProps({
    modelValue:Number|Array,
})

const modelValue = ref(props.modelValue)
const emit = defineEmits(['update:modelValue'])
const changeData = (event) =>{
    emit('update:modelValue', event)
}


const categories = ref([]);



const { loading, error, sendRequest } = useAxios();
const data = ref(null);

onMounted(async () => {
    let responseData;
    responseData = await sendRequest({
        method: 'get',
        url: '/api/category',
    });
    categories.value = responseData;
});


// axios.get('/api/category').then((res) => categories.value = res.data).catch((err) => console.log(err))


const flattenedCategories = computed(() => {
    return flattenCategories(categories.value);
});

const selectedCategory = ref(null);

const selectedCategoryId = ref(null);

function flattenCategories(categories, level = 0, parentPrefix = "") {
    return categories?.reduce((result, category) => {
        const prefix = level > 0 ? `${parentPrefix}-` : parentPrefix;

        const fullName = `${prefix} ${category.name}`;
        const flattenedCategory = { ...category, fullName };
        result.push(flattenedCategory);

        if (category.children_recursive && category.children_recursive.length > 0) {
            result.push(...flattenCategories(category.children_recursive, level + 1, prefix));
        }
        return result;
    }, []);
}
</script>
