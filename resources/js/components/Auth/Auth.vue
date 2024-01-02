<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <!--begin::Login-->
            <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
                <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat content__center" style="background-image: url('./assets/media/bg/bg-3.jpg');">
                    <div class="login-form text-center p-7 position-relative overflow-hidden bg-white shadow-lg">
                        <!--begin::Login Header-->
                        <div class="d-flex flex-center mb-15">
<!--                            <a href="#">-->
<!--                                 <img src="./backend/assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />-->
<!--                            </a>-->
                        </div>
                        <!--end::Login Header-->


                        <!--begin::Login Sign in form-->
                        <div class="login-signin">
                            <div class="mb-20">
                                <h3>Login As Admin</h3>
                                <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
                            </div>
                            <form @submit.prevent="loginHere()" class="form" id="kt_login_signin_form">
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8" type="email" :disabled="data.isLoading" placeholder="Email" v-model="data.email" autocomplete="off" />
                                </div>
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8" type="password" :disabled="data.isLoading" placeholder="Password" v-model="data.password" />
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="checkbox-inline">
                                        <label class="checkbox m-0 text-muted">
                                            <input type="checkbox" name="remember" />
                                            <span></span>Remember me</label>
                                    </div>
                                </div>
                                <div v-if="data.isLoading" class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <button v-else id="kt_login_signin_submit" :disabled="data.isLoading" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Login-->
        </div>
    </div>
</template>

<script>
export default {
    name: "Auth",
    data(){
      return{
          data:{
              email:"admin@admin.com",
              password:"12345678",
              isLoading:false,
          },
      }
    },
    methods: {
        loginHere(){

            this.data.isLoading = true;
            this.$axios.post('/api/auth/login', this.data)
            .then(res => {
                User.responseAfterLogin(res);
                Toast.fire({
                    icon:'success',
                    title: 'Login Successfully Done..'
                })
                this.$router.push({name:'Dashboard'});
                this.data.isLoading = false;
            })
            .catch(e=>{
                Toast.fire({
                    icon:'warning',
                    title:e.response.data.error
                });
                if (e.response.status == 500 ){
                    Toast.fire({
                        icon:'error',
                        title:e.response.statusText
                    });
                }
                this.data.isLoading = false;
            });
        },
        meButton(){
            console.log(this.data);
            this.$axios.post('/api/auth/me?token='+this.token)
                .then(res => {
                    console.log(res.data);
                    this.products = res.data;
                })
                .catch(e=>{
                    console.log(e);
                });
        },
        payload(){
            this.axios.post('/api/auth/payload?token='+this.token)
                .then(res => {
                    console.log(res.data);
                    this.products = res.data;
                })
                .catch(e=>{
                    console.log(e);
                });
        },
        logout(){
            this.$axios.post('/api/auth/logout?token='+this.token)
                .then(res => {
                    console.log(res.data);
                    this.products = res.data;
                })
                .catch(e=>{
                    console.log(e);
                });
        }
    },
    created() {
        if (User.loggedIn()){
            this.$router.push({name:"Dashboard"})
        }
    }
}
</script>

<style scoped>
.content__center{
    position: relative;
    left: -12%;
}
</style>
