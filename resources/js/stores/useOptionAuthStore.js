import { defineStore } from "pinia"


export const useOptionAuthStote = defineStore('option_auth', {
    state: () => ({ 
        user: JSON.parse(localStorage.getItem("user")) ?? null, 
        name: 'Eduardo' 
    }),
    
    actions: {
        //
    },


    getters: {
      user(){
        return this.user;
      }
    },
})