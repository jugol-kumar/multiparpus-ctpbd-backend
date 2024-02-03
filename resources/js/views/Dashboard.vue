<template>
 <div>
   <h1 class="text-capitalize">Welcome Again <span class="text-primary fw-bold">{{ user?.full_name }}</span></h1>
 </div>
</template>

<script>
export default {
    data(){
        return {
            user: User.userInfo(),
        }
    }
}
</script>

<style scoped>

</style>
