<template>
 <div>
   <h1>This is home components</h1>
     <h2>Login user: {{ user }}</h2>
 </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Dashboard",
    data(){
        return {
            user:{}
        }
    },
    methods:{
      getUser(){
          this.user = JSON.parse(User.name())
      }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({name:"Login"})
        }
        this.getUser();
    }
}
</script>

<style scoped>

</style>
